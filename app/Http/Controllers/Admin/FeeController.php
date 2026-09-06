<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\FeeAllocation;
use App\Models\FeeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class FeeController extends Controller
{
    // List all student ledgers & allocations
    public function index()
    {
        $admissions = Admission::with(['course', 'batch', 'feeCollections', 'feeAllocations'])
            ->latest()
            ->get();

        return view('admin.fees.index', compact('admissions'));
    }

    // Show Fee Collection Form
    public function create($admission_id)
    {
        $admission = Admission::with(['course', 'batch', 'feeAllocations'])->findOrFail($admission_id);

        // Fetch latest active allocation or calculate fallback values
        $latestAllocation = $admission->feeAllocations()->latest()->first();

        if ($latestAllocation) {
            $admission->total_agreed_fee = $latestAllocation->net_payable;
            $admission->discount_amount = $latestAllocation->discount_amount;
            $admission->paid_fee = $latestAllocation->paid_amount;
            $admission->due_fee = $latestAllocation->due_amount;
        } else {
            $totalAgreed = $admission->total_agreed_fee ?? 0;
            $discount = $admission->discount_amount ?? 0;
            $paid = $admission->feeCollections()->sum('amount_paid');
            $admission->paid_fee = $paid;
            $admission->due_fee = max(0, ($totalAgreed - $discount) - $paid);
        }

        return view('admin.fees.create', compact('admission'));
    }

    // Process Fee Payment (Cash / Stripe / Bank / Mobile Wallet)
    public function store(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'amount_paid'  => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
        ]);

        $admission = Admission::findOrFail($request->admission_id);
        $latestAllocation = FeeAllocation::where('admission_id', $admission->id)->latest()->first();

        // 1. Stripe Payment Gateway Handling
        if ($request->payment_method === 'Stripe') {
            Stripe::setApiKey(config('services.stripe.secret', env('STRIPE_SECRET')));

            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pkr',
                        'product_data' => [
                            'name' => "Fee Payment - {$admission->student_name} ({$admission->registration_no})",
                        ],
                        'unit_amount' => (int)($request->amount_paid * 100), // convert to cents/paisa
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('fees.stripe.success') . "?session_id={CHECKOUT_SESSION_ID}&admission_id={$admission->id}&amount={$request->amount_paid}",
                'cancel_url' => route('fees.index'),
            ]);

            return redirect()->away($checkoutSession->url);
        }

        // 2. Standard Payment (Cash / Bank / EasyPaisa / JazzCash)
        $collection = DB::transaction(function () use ($request, $admission, $latestAllocation) {
            $receiptNo = 'REC-' . date('Y') . '-' . str_pad(FeeCollection::count() + 1, 4, '0', STR_PAD_LEFT);

            $feeCollection = FeeCollection::create([
                'receipt_no'            => $receiptNo,
                'admission_id'          => $admission->id,
                'fee_allocation_id'     => $latestAllocation ? $latestAllocation->id : null,
                'amount_paid'           => $request->amount_paid,
                'payment_date'          => $request->payment_date,
                'payment_method'        => $request->payment_method,
                'transaction_reference' => $request->transaction_reference ?? $request->remarks,
                'received_by'           => Auth::user()->name ?? 'Admin Staff',
                'remarks'               => $request->remarks,
            ]);

            // Update Allocation balances if allocation exists
            if ($latestAllocation) {
                $latestAllocation->paid_amount += $request->amount_paid;
                $latestAllocation->due_amount = max(0, $latestAllocation->net_payable - $latestAllocation->paid_amount);
                $latestAllocation->status = ($latestAllocation->due_amount == 0) ? 'Paid' : 'Partial';
                $latestAllocation->save();
            }

            return $feeCollection;
        });

        return redirect()->route('fees.receipt', $collection->id)
            ->with('success', 'Fee payment recorded successfully.');
    }

    // Stripe Success Callback
    public function stripeSuccess(Request $request)
    {
        $admissionId = $request->get('admission_id');
        $amount = $request->get('amount');
        $sessionId = $request->get('session_id');

        $admission = Admission::findOrFail($admissionId);
        $latestAllocation = FeeAllocation::where('admission_id', $admission->id)->latest()->first();

        $collection = DB::transaction(function () use ($admission, $amount, $sessionId, $latestAllocation) {
            $receiptNo = 'REC-' . date('Y') . '-' . str_pad(FeeCollection::count() + 1, 4, '0', STR_PAD_LEFT);

            $feeCollection = FeeCollection::create([
                'receipt_no'            => $receiptNo,
                'admission_id'          => $admission->id,
                'fee_allocation_id'     => $latestAllocation ? $latestAllocation->id : null,
                'amount_paid'           => $amount,
                'payment_date'          => now()->toDateString(),
                'payment_method'        => 'Stripe',
                'transaction_reference' => $sessionId,
                'received_by'           => 'Stripe Gateway',
                'remarks'               => 'Online Card Payment via Stripe Checkout',
            ]);

            if ($latestAllocation) {
                $latestAllocation->paid_amount += $amount;
                $latestAllocation->due_amount = max(0, $latestAllocation->net_payable - $latestAllocation->paid_amount);
                $latestAllocation->status = ($latestAllocation->due_amount == 0) ? 'Paid' : 'Partial';
                $latestAllocation->save();
            }

            return $feeCollection;
        });

        return redirect()->route('fees.receipt', $collection->id)
            ->with('success', 'Stripe Online Payment Processed Successfully!');
    }

    // View Print Voucher Receipt
    public function receipt($id)
    {
        $fee = FeeCollection::with(['admission.course', 'admission.batch', 'allocation.items.head'])->findOrFail($id);

        $latestAllocation = $fee->allocation;

        if ($latestAllocation) {
            $totalAgreed = $latestAllocation->net_payable;
            $totalPaidTillNow = $latestAllocation->paid_amount;
            $balance = $latestAllocation->due_amount;
        } else {
            $netFee = ($fee->admission->total_agreed_fee ?? 0) - ($fee->admission->discount_amount ?? 0);
            $totalPaidTillNow = FeeCollection::where('admission_id', $fee->admission_id)
                ->where('id', '<=', $fee->id)
                ->sum('amount_paid');
            $totalAgreed = $netFee;
            $balance = max(0, $netFee - $totalPaidTillNow);
        }

        return view('admin.fees.receipt', compact('fee', 'totalAgreed', 'totalPaidTillNow', 'balance'));
    }
}