<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StudentRegisteredMail;
use App\Models\Admission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    /**
     * Display student directory with CNIC filter capabilities & pagination.
     */
    public function index(Request $request): View
    {
        $cnic = trim($request->get('cnic'));

        $query = Admission::with(['course', 'batch', 'user']);

        if ($cnic) {
            $query->where(function($q) use ($cnic) {
                $q->where('cnic_bform', 'LIKE', "%{$cnic}%")
                  ->orWhereHas('user', fn($u) => $u->where('cnic', 'LIKE', "%{$cnic}%"));
            });
        }

        // Fast Pagination for 1000+ Records
        $admissions = $query->orderBy('id', 'desc')->paginate(15)->appends($request->all());

        // Fallback search on users table if no admission record matches and CNIC is searched
        if ($admissions->isEmpty() && $cnic) {
            $admissions = User::where('role', 'student')
                ->where('cnic', 'LIKE', "%{$cnic}%")
                ->with(['course', 'batch'])
                ->paginate(15)
                ->appends($request->all());
        }

        return view('admin.admissions.index', compact('admissions', 'cnic'));
    }

    /**
     * Show registration form.
     */
    public function create(): View
    {
        return view('admin.admissions.create');
    }

    /**
     * Store pre-registration data and notify student via email.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'   => 'required|email|unique:users,email',
            'cnic'    => 'required|string|unique:users,cnic',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $picturePath = null;
            if ($request->hasFile('picture')) {
                $picturePath = $request->file('picture')->store('students', 'public');
            }

            // 1. Create User Identity
            $user = User::create([
                'name'              => 'Pending Entry',
                'email'             => $request->email,
                'cnic'              => $request->cnic,
                'picture'           => $picturePath,
                'role'              => 'student',
                'password'          => Hash::make(Str::random(16)),
                'profile_completed' => false,
            ]);

            // 2. Generate Sequence & Registration Number
            $latestReg = Admission::lockForUpdate()->orderBy('id', 'desc')->first();
            $nextSeq   = $latestReg ? ($latestReg->reg_sequence_no + 1) : 1;
            $paddedSeq = str_pad($nextSeq, 5, '0', STR_PAD_LEFT);
            $yearMonth = Carbon::now()->format('Y-m');
            $regNo     = "LC-REG-{$yearMonth}-{$paddedSeq}";

            // 3. Create Admission Record
            Admission::create([
                'registration_no' => $regNo,
                'reg_sequence_no' => $nextSeq,
                'admission_date'  => Carbon::now()->toDateString(),
                'user_id'         => $user->id,
                'student_name'    => 'Pending Entry',
                'father_name'     => 'Pending Entry',
                'mobile_number'   => 'N/A',
                'email'           => $request->email,
                'cnic_bform'      => $request->cnic,
                'status'          => 'Learning',
            ]);

            // 4. Send Email Notification
            try {
                Mail::to($user->email)->send(new StudentRegisteredMail($user));
            } catch (\Exception $mailEx) {
                Log::warning('Student registration email failed: ' . $mailEx->getMessage());
            }

            DB::commit();

            return redirect()->route('admissions.index')
                ->with('success', "Student pre-registration completed! Reg No: {$regNo}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show detailed profile view.
     */
    public function show(int|string $id): View
    {
        $admission = Admission::with(['course', 'batch', 'attendances', 'user'])->find($id);

        if (!$admission) {
            $user = User::with(['course', 'batch'])->findOrFail($id);

            $admission = (object) [
                'id'                 => $user->id,
                'registration_no'    => 'REG-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'student_name'       => $user->name ?? 'Pending Profile Completion',
                'father_name'        => $user->father_name ?? 'N/A',
                'cnic_bform'         => $user->cnic ?? 'N/A',
                'gender'             => 'N/A',
                'dob'                => 'N/A',
                'blood_group'        => 'N/A',
                'mobile_number'      => $user->phone ?? 'N/A',
                'whatsapp_number'    => $user->phone ?? 'N/A',
                'email'              => $user->email ?? 'N/A',
                'guardian_name'      => 'N/A',
                'guardian_relation'  => 'N/A',
                'guardian_mobile'    => 'N/A',
                'last_qualification' => $user->qualification ?? 'N/A',
                'home_address'       => $user->address ?? 'N/A',
                'status'             => $user->profile_completed ? 'Learning' : 'Pending Profile',
                'total_agreed_fee'   => 0,
                'discount_amount'    => 0,
                'paid_fee'           => 0,
                'due_fee'            => 0,
                'course'             => $user->course ?? (object) ['course_name' => 'Unallocated'],
                'batch'              => $user->batch ?? (object) ['batch_number' => 'Unallocated'],
                'attendances'        => collect(),
                'user'               => $user,
            ];
        }

        return view('admin.admissions.show', compact('admission'));
    }
}