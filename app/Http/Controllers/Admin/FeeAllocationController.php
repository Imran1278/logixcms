<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\FeeAllocation;
use App\Models\FeeAllocationItem;
use App\Models\FeeHead;
use App\Models\FeeSetting;
use App\Services\WhatsAppService;
use App\Mail\FeeAssignedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FeeAllocationController extends Controller
{
    // Directory View with Admissions & Fee Relationships
    public function index()
    {
        $admissions = Admission::with(['course', 'batch', 'feeAllocations', 'feeCollections'])
            ->latest()
            ->get();

        return view('admin.fees.index', compact('admissions'));
    }

    // Allotment Form View with Dynamic Configurations
    public function create($admission_id)
    {
        $admission = Admission::with(['course', 'batch'])->findOrFail($admission_id);

        if (Schema::hasColumn('fee_heads', 'is_active')) {
            $feeHeads = FeeHead::where('is_active', true)->get();
        } else {
            $feeHeads = FeeHead::all();
        }

        // Fetch dynamic configurations
        $sessions = FeeSetting::where('type', 'session')->get();
        $frequencies = FeeSetting::where('type', 'frequency')->get();
        $scholarshipReasons = FeeSetting::where('type', 'scholarship_reason')->get();

        return view('admin.fees.allot', compact('admission', 'feeHeads', 'sessions', 'frequencies', 'scholarshipReasons'));
    }

    // Save Allotment, Dispatch Mail & Generate Direct WhatsApp Link
    public function store(Request $request, WhatsAppService $whatsAppService)
    {
        $request->validate([
            'admission_id'         => 'required|exists:admissions,id',
            'academic_session'     => 'required|string',
            'fee_heads'            => 'required|array|min:1',
            'fee_heads.*.head_id'  => 'required|exists:fee_heads,id',
            'fee_heads.*.amount'   => 'required|numeric|min:0',
            'discount_amount'      => 'nullable|numeric|min:0',
        ]);

        $netPayable = 0;
        $allocation = null;

        DB::transaction(function () use ($request, &$netPayable, &$allocation) {
            $totalAmount = 0;
            foreach ($request->fee_heads as $head) {
                $totalAmount += floatval($head['amount']);
            }

            $discount = floatval($request->discount_amount ?? 0);
            $netPayable = max(0, $totalAmount - $discount);

            $allocation = FeeAllocation::create([
                'admission_id'         => $request->admission_id,
                'academic_session'     => $request->academic_session,
                'total_amount'         => $totalAmount,
                'discount_amount'      => $discount,
                'discount_reason'      => $request->discount_reason,
                'discount_approved_by' => $request->discount_approved_by,
                'net_payable'          => $netPayable,
                'paid_amount'          => 0.00,
                'due_amount'           => $netPayable,
                'status'               => 'Unpaid',
                'created_by'           => Auth::user()->name ?? 'Admin Staff',
            ]);

            foreach ($request->fee_heads as $head) {
                FeeAllocationItem::create([
                    'fee_allocation_id' => $allocation->id,
                    'fee_head_id'       => $head['head_id'],
                    'amount'            => $head['amount'],
                    'frequency'         => $head['frequency'] ?? 'Monthly',
                    'due_date'          => $head['due_date'] ?? null,
                ]);
            }
        });

        // Fetch admission details with course
        $admission = Admission::with('course')->find($request->admission_id);

        // Dispatch Email Notification to Student
        if ($admission && !empty($admission->email)) {
            try {
                Mail::to($admission->email)->send(new FeeAssignedMail($allocation, $admission));
            } catch (\Exception $e) {
                Log::error('Fee Assigned Mail Sending Failed: ' . $e->getMessage());
            }
        }

        // Generate WhatsApp Link
        $phone = $admission->whatsapp_number ?? $admission->mobile_number ?? '';

        $msg = "Dear {$admission->student_name},\n"
             . "Your fee structure for Session {$request->academic_session} has been updated.\n"
             . "Net Payable Amount: PKR " . number_format($netPayable) . "\n"
             . "Thank you - Logix College Management";

        $waUrl = $whatsAppService->getWhatsAppLink($phone, $msg);

        return redirect()->route('fees.index')
            ->with('success', 'Custom Fee Structure successfully allotted and notification mail sent!')
            ->with('wa_url', $waUrl);
    }

    // Defaulters List Report
    public function defaulters()
    {
        $defaulters = FeeAllocation::with(['admission.course', 'admission.batch'])
            ->where('due_amount', '>', 0)
            ->latest()
            ->get();

        return view('admin.fees.defaulters', compact('defaulters'));
    }
}