<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Inquiry;
use App\Models\FeeAllocation;
use App\Models\FeeCollection;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\Leave;
use App\Models\StudentLeave;
use App\Models\Download; //
use App\Mail\AdminAlertMail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard view.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user()->fresh();

        // 1. Fetch Profile Picture URL safely
        $avatarPath = $user->picture ?? $user->profile_photo_path ?? null;
        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            $avatarUrl = asset('storage/' . $avatarPath);
        } else {
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=d4af37&color=0b2545';
        }

        // 2. Fetch Student Admission details
        $admission = Admission::with(['course', 'batch', 'feeAllocations.items.feeHead', 'feeCollections'])
            ->where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();

        // Fetch Academic & Experience Records safely for View
        $educationDetails = [];
        $rawEducation = $user->education_details ?? ($admission->education_details ?? null);
        if ($rawEducation) {
            $educationDetails = is_string($rawEducation) ? json_decode($rawEducation, true) : $rawEducation;
        }

        $experienceDetails = [];
        $rawExperience = $user->experience_details ?? ($admission->experience_details ?? null);
        if ($rawExperience) {
            $experienceDetails = is_string($rawExperience) ? json_decode($rawExperience, true) : $rawExperience;
        }

        // Fetch Student's Enrolled Course List Dynamically
        $coursesList = collect();
        if ($admission && $admission->course) {
            $coursesList->push($admission->course);
        }

        // 3. Fetch Fee Allocation & Ledger Summary
        $feeAllocation = null;
        $feeItems = collect();
        $feeCollections = collect();
        $feeSummary = [
            'total_agreed' => 0,
            'discount'     => 0,
            'net_payable'  => 0,
            'paid_amount'  => 0,
            'due_amount'   => 0,
            'status'       => 'Pending Allotment',
            'is_allocated' => false
        ];

        if ($admission) {
            $feeAllocation = $admission->feeAllocations()->with(['items.feeHead', 'items.head'])->first();
            
            if ($feeAllocation) {
                $feeItems = $feeAllocation->items;
                $feeSummary['total_agreed'] = $feeAllocation->total_amount;
                $feeSummary['discount']     = $feeAllocation->discount_amount;
                $feeSummary['net_payable']  = $feeAllocation->net_payable;
                $feeSummary['paid_amount']  = $feeAllocation->paid_amount;
                $feeSummary['due_amount']   = $feeAllocation->due_amount;
                $feeSummary['status']       = $feeAllocation->status;
                $feeSummary['is_allocated'] = true;
            } else {
                $netAgreed = max(0, ($admission->total_agreed_fee ?? 0) - ($admission->discount_amount ?? 0));
                $paid = $admission->feeCollections ? $admission->feeCollections->sum('amount_paid') : 0;
                $due = max(0, $netAgreed - $paid);

                $feeSummary['total_agreed'] = $admission->total_agreed_fee ?? 0;
                $feeSummary['discount']     = $admission->discount_amount ?? 0;
                $feeSummary['net_payable']  = $netAgreed;
                $feeSummary['paid_amount']  = $paid;
                $feeSummary['due_amount']   = $due;
                $feeSummary['status']       = $netAgreed > 0 ? ($due == 0 ? 'Cleared' : 'Pending Allotment') : 'Pending Allotment';
            }

            // Safe Query: Search only by columns that actually exist in fee_collections table
            $query = FeeCollection::where('admission_id', $admission->id);

            if (Schema::hasColumn('fee_collections', 'user_id')) {
                $query->orWhere('user_id', $user->id);
            }

            $feeCollections = $query->latest()->get();
        }

        // 4. Fetch available courses & batches for student selection
        $availableCourses = Course::where(function ($query) {
            $query->whereIn('status', ['active', 'Active', '1'])
                  ->orWhereNull('status');
        })->latest()->get();

        if ($availableCourses->isEmpty()) {
            $availableCourses = Course::latest()->get();
        }

        $availableBatches = Batch::with('course')->latest()->get();

        // 5. Safe Inquiry Search
        $inquiries = Inquiry::where('email', $user->email)->latest()->get();

        // 6. Safe Attendance Search
        $attendances = Attendance::where('admission_id', $user->id)
            ->orWhere(function($query) use ($admission, $user) {
                if ($admission) {
                    $query->where('admission_id', $admission->id);
                }
                if (Schema::hasColumn('attendances', 'user_id')) {
                    $query->orWhere('user_id', $user->id);
                }
            })
            ->orderBy('attendance_date', 'desc')
            ->get();

        // 7. Safe Certificates Search
        $certificates = collect();
        if (Schema::hasColumn('certificates', 'user_id')) {
            $certificates = Certificate::where('user_id', $user->id)->latest()->get();
        } elseif ($admission && Schema::hasColumn('certificates', 'admission_id')) {
            $certificates = Certificate::where('admission_id', $admission->id)->latest()->get();
        }

        // 8. Safe Student Leaves Search
        $leaves = Leave::where('user_id', $user->id)->latest()->get();

        // 9. Fetch Downloads Grouped by Categories for Student Portal Tab
        $downloads = Download::latest()->get()->groupBy('category');

        // 10. Dynamic Announcements: Fetch Latest News & Press Releases
        $latestNews = collect();
        if (Schema::hasTable('latest_news')) {
            $newsQuery = DB::table('latest_news');
            if (Schema::hasColumn('latest_news', 'status')) {
                $newsQuery->whereIn('status', ['active', 'Active', '1', 1]);
            }
            $latestNews = $newsQuery->latest('created_at')->take(5)->get();
        }

        $pressReleases = collect();
        if (Schema::hasTable('press_releases')) {
            $pressQuery = DB::table('press_releases');
            if (Schema::hasColumn('press_releases', 'status')) {
                $pressQuery->whereIn('status', ['active', 'Active', '1', 1]);
            }
            $pressReleases = $pressQuery->latest('created_at')->take(5)->get();
        }

        // 11. Fetch About Content (Section 3: Industry Partners / Accreditations)
        $aboutContent = DB::table('about_contents')->first();
        $accreditations = [];

        if ($aboutContent && !empty($aboutContent->industries)) {
            $decoded = is_string($aboutContent->industries) 
                ? json_decode($aboutContent->industries, true) 
                : $aboutContent->industries;

            $accreditations = is_array($decoded) ? $decoded : [];
        }

        // 12. Fetch Courses for Footer
        $footerCourses = Course::where(function ($query) {
            $query->whereIn('status', ['active', 'Active', '1'])
                  ->orWhereNull('status');
        })->latest()->take(4)->get();

        // 13. Generate 2FA QR Code if secret key exists or create new secret
        $google2fa = new Google2FA();
        if (empty($user->google2fa_secret)) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name', 'LOGIX College'),
            $user->email,
            $user->google2fa_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('student.dashboard', compact(
            'user', 
            'avatarUrl',
            'admission', 
            'feeAllocation',
            'feeItems',
            'feeCollections',
            'feeSummary',
            'availableCourses', 
            'availableBatches',
            'inquiries',
            'attendances',
            'certificates',
            'leaves',
            'downloads',
            'latestNews',
            'pressReleases',
            'accreditations',
            'coursesList',
            'footerCourses',
            'qrCodeSvg',
            'educationDetails',
            'experienceDetails'
        ));
    }

    /**
     * Enable 2FA by verifying the setup code.
     */
    public function enable2fa(Request $request): RedirectResponse
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            $user->is_2fa_enabled = true;
            $user->save();

            return redirect()->to(route('student.dashboard') . '#attendances')
                ->with('success', 'Google Authenticator linked successfully! You can now mark your daily attendance.')
                ->with('auto_open_checkin', true);
        }

        return back()->with('error', 'Invalid Authenticator code. Please try again.');
    }

    /**
     * Mark daily attendance using 2FA OTP.
     */
    public function checkIn(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp_code);

        if (!$valid) {
            return back()->with('error', 'Invalid Authenticator OTP. Verification failed.');
        }

        $today = Carbon::now()->toDateString();
        $batchId = $user->batch_id ?? ($user->admission->batch_id ?? 1);

        Attendance::updateOrCreate(
            [
                'admission_id'    => $user->id,
                'attendance_date' => $today,
            ],
            [
                'batch_id'      => $batchId,
                'status'        => 'Present',
                'check_in_time' => Carbon::now()->toTimeString(),
            ]
        );

        return redirect()->to(route('student.dashboard') . '#attendances')
            ->with('success', 'Attendance checked in successfully!');
    }

    /**
     * Handle student fee payment (Supports Direct & Stripe Online Checkout).
     */
    public function payFee(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $admission = Admission::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->firstOrFail();

        $allocation = FeeAllocation::where('admission_id', $admission->id)->first();

        $maxPayable = $allocation ? $allocation->due_amount : max(0, ($admission->total_agreed_fee ?? 0) - ($admission->discount_amount ?? 0));

        $request->validate([
            'amount_paid'    => 'required|numeric|min:1|max:' . ($maxPayable > 0 ? $maxPayable : 999999),
            'payment_method' => 'required|string',
            'remarks'        => 'nullable|string|max:255',
        ]);

        $paidAmount = floatval($request->amount_paid);

        // Check if Payment Method is Stripe
        if (str_contains(strtolower($request->payment_method), 'stripe') || str_contains(strtolower($request->payment_method), 'card')) {
            $stripeSecret = config('services.stripe.secret', env('STRIPE_SECRET'));

            if (!$stripeSecret) {
                return back()->with('error', 'Stripe payment gateway is not properly configured in .env file.');
            }

            Stripe::setApiKey($stripeSecret);

            try {
                $session = StripeSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'pkr',
                            'product_data' => [
                                'name' => 'Tuition / Course Fee - ' . ($admission->student_name ?? $user->name),
                                'description' => 'Fee Payment for Reg No: ' . ($admission->registration_no ?? 'N/A'),
                            ],
                            'unit_amount' => intval($paidAmount * 100),
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'customer_email' => $user->email,
                    'success_url' => route('student.fees.stripe.callback') . '?session_id={CHECKOUT_SESSION_ID}&admission_id=' . $admission->id . '&amount=' . $paidAmount,
                    'cancel_url' => route('student.dashboard') . '#fee-section',
                ]);

                return redirect()->away($session->url);
            } catch (\Exception $e) {
                return back()->with('error', 'Stripe Initialization Error: ' . $e->getMessage());
            }
        }

        // Manual / Direct Local Payment Handling
        DB::transaction(function () use ($request, $user, $admission, $allocation, $paidAmount) {
            FeeCollection::create([
                'admission_id'      => $admission->id,
                'user_id'           => $user->id,
                'fee_allocation_id' => $allocation ? $allocation->id : null,
                'amount_paid'       => $paidAmount,
                'payment_date'      => now()->toDateString(),
                'payment_method'    => $request->payment_method,
                'remarks'           => $request->remarks ?? 'Paid by Student via Portal',
            ]);

            if ($allocation) {
                $newPaidTotal = floatval($allocation->paid_amount) + $paidAmount;
                $newDueAmount = max(0, floatval($allocation->net_payable) - $newPaidTotal);
                $status = $newDueAmount <= 0 ? 'Paid' : 'Partial';

                $allocation->update([
                    'paid_amount' => $newPaidTotal,
                    'due_amount'  => $newDueAmount,
                    'status'      => $status,
                ]);
            }
        });

        return back()->with('success', 'Payment recorded successfully! Your fee ledger has been updated.');
    }

    /**
     * Handle Stripe Checkout Payment Success Callback
     */
    public function stripeCallback(Request $request): RedirectResponse
    {
        $sessionId   = $request->query('session_id');
        $admissionId = $request->query('admission_id');
        $amount      = floatval($request->query('amount'));

        if (!$sessionId || !$admissionId) {
            return redirect()->route('student.dashboard')->with('error', 'Invalid Stripe Callback request.');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $admission = Admission::findOrFail($admissionId);
        $allocation = FeeAllocation::where('admission_id', $admission->id)->first();

        DB::transaction(function () use ($user, $admission, $allocation, $amount, $sessionId) {
            FeeCollection::create([
                'admission_id'      => $admission->id,
                'user_id'           => $user->id,
                'fee_allocation_id' => $allocation ? $allocation->id : null,
                'amount_paid'       => $amount,
                'payment_date'      => now()->toDateString(),
                'payment_method'    => 'Stripe Online Card',
                'remarks'           => 'Stripe Session ID: ' . $sessionId,
            ]);

            if ($allocation) {
                $newPaidTotal = floatval($allocation->paid_amount) + $amount;
                $newDueAmount = max(0, floatval($allocation->net_payable) - $newPaidTotal);
                $status = $newDueAmount <= 0 ? 'Paid' : 'Partial';

                $allocation->update([
                    'paid_amount' => $newPaidTotal,
                    'due_amount'  => $newDueAmount,
                    'status'      => $status,
                ]);
            }
        });

        return redirect()->route('student.dashboard')->with('success', 'Online Stripe Payment completed successfully! Ledger updated.');
    }

    /**
     * Submit a new inquiry and alert admin via email.
     */
    public function storeInquiry(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'message' => 'required|string|min:5',
        ]);

        Inquiry::create([
            'student_name'    => $user->name ?? 'Student',
            'email'           => $user->email,
            'mobile_number'   => $user->mobile_contact ?? $user->phone ?? 'N/A',
            'whatsapp_number' => $user->whatsapp_contact ?? $user->mobile_contact ?? null,
            'remarks'         => $request->message,
            'source'          => 'Student Portal',
            'status'          => 'New',
            'lead_score'      => 'Hot',
            'inquiry_date'    => now()->format('Y-m-d'),
        ]);

        $adminEmail = config('mail.from.address', 'admin@logixcollege.edu.pk');
        try {
            Mail::to($adminEmail)->send(new AdminAlertMail(
                "New Student Portal Inquiry: " . ($user->name ?? 'Student'),
                "Student: " . ($user->name ?? 'Student') . " (CNIC: {$user->cnic}, Email: {$user->email})\n\nSubmitted Inquiry/Issue:\n'{$request->message}'"
            ));
        } catch (\Exception $e) {}

        return back()->with('success', 'Your inquiry/problem has been submitted to admin successfully.');
    }

    /**
     * Apply for leave.
     */
    public function applyLeave(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $request->validate([
            'leave_date' => 'required|date|after_or_equal:today',
            'reason'     => 'required|string|min:5',
        ]);

        $batchId = $user->batch_id ?? ($user->admission->batch_id ?? 1);

        Leave::create([
            'user_id'    => $user->id,
            'batch_id'   => $batchId,
            'leave_date' => $request->leave_date,
            'reason'     => $request->reason,
            'status'     => 'Pending',
        ]);

        return redirect()->to(route('student.dashboard') . '#attendances')
            ->with('success', 'Leave application submitted successfully.');
    }

    /**
     * Complete student profile, update dynamic fields, sync admission & notify admin.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'name'                => 'required|string|max:255',
            'father_name'         => 'required|string|max:255',
            'mobile_contact'      => 'required|string|max:20',
            'whatsapp_contact'    => 'nullable|string|max:20',
            'guardian_name'       => 'nullable|string|max:255',
            'guardian_contact'    => 'nullable|string|max:20',
            'gender'              => 'nullable|string',
            'blood_group'         => 'nullable|string',
            'last_qualification'  => 'nullable|string',
            'residential_address' => 'nullable|string',
            'course_id'           => 'required|exists:courses,id',
            'batch_id'            => 'required|exists:batches,id',
            'picture'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password'            => 'nullable|string|min:6|confirmed',
            'education'           => 'nullable|array',
            'experience'          => 'nullable|array',
        ]);

        if ($request->hasFile('picture')) {
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }
            $user->picture = $request->file('picture')->store('students', 'public');
        }

        $educationList  = $request->filled('education') ? array_values($request->education) : null;
        $experienceList = $request->filled('experience') ? array_values($request->experience) : null;

        $user->name = $request->name;
        if ($request->filled('father_name')) {
            $user->father_name = $request->father_name;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->profile_completed = true;
        $user->is_profile_complete = true;
        $user->save();

        $course = Course::find($request->course_id);
        $totalFee = $course->fee ?? $course->total_fee ?? 0;

        $existingAdmission = Admission::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();

        if ($existingAdmission) {
            $regNo = $existingAdmission->registration_no ?? ('LC-REG-' . date('Y-m-') . str_pad($user->id, 5, '0', STR_PAD_LEFT));
            $nextSeq = $existingAdmission->reg_sequence_no ?? 1;
        } else {
            $latestReg = Admission::orderBy('id', 'desc')->first();
            $nextSeq = $latestReg ? (($latestReg->reg_sequence_no ?? 0) + 1) : 1;
            $paddedSeq = str_pad($nextSeq, 5, '0', STR_PAD_LEFT);
            $yearMonth = Carbon::now()->format('Y-m');
            $regNo = "LC-REG-{$yearMonth}-{$paddedSeq}";
        }

        Admission::updateOrCreate(
            ['user_id' => $user->id],
            [
                'registration_no'    => $regNo,
                'reg_sequence_no'    => $nextSeq,
                'student_name'       => $request->name,
                'father_name'        => $request->father_name,
                'course_id'          => $request->course_id,
                'batch_id'           => $request->batch_id,
                'cnic_bform'         => $user->cnic,
                'email'              => $user->email,
                'mobile_number'      => $request->mobile_contact,
                'whatsapp_number'    => $request->whatsapp_contact ?? $request->mobile_contact,
                'guardian_name'      => $request->guardian_name,
                'guardian_mobile'    => $request->guardian_contact,
                'gender'             => $request->gender ?? 'Male',
                'blood_group'        => $request->blood_group,
                'last_qualification' => $request->last_qualification,
                'education_details'  => $educationList,
                'experience_details' => $experienceList,
                'home_address'       => $request->residential_address,
                'total_agreed_fee'   => $totalFee,
                'status'             => $existingAdmission->status ?? 'Learning',
            ]
        );

        $adminEmail = config('mail.from.address', 'admin@logixcollege.edu.pk');
        try {
            Mail::to($adminEmail)->send(new AdminAlertMail(
                "Profile & Course Selection Completed: {$user->name}",
                "Student {$user->name} (CNIC: {$user->cnic}) updated profile details and selected Course ID: {$request->course_id}, Batch ID: {$request->batch_id}."
            ));
        } catch (\Exception $e) {}

        return back()->with('success', 'Profile, course, and batch choices saved successfully!');
    }
}