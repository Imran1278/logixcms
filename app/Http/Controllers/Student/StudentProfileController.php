<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StudentProfileController extends Controller
{
    /**
     * Display profile completion form.
     *
     * @return \Illuminate\View\View
     */
    public function showCompleteForm(): View
    {
        $courses = Course::latest()->get();
        return view('student.complete-profile', compact('courses'));
    }

    /**
     * Handle student profile submission and synchronize admission records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'father_name'        => 'required|string|max:255',
            'cnic'               => 'required|string|max:20',
            'mobile_number'      => 'required|string|max:20',
            'whatsapp_number'    => 'nullable|string|max:20',
            'guardian_phone'     => 'nullable|string|max:20',
            'dob'                => 'nullable|date',
            'gender'             => 'required|in:Male,Female,Other',
            'last_qualification' => 'required|string|max:255',
            'home_address'       => 'required|string|max:500',
            'course_id'          => 'nullable|exists:courses,id',
            'shift'              => 'nullable|string|max:50',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        DB::transaction(function () use ($user, $validated) {
            // 1. Synchronize user profile fields
            $user->update([
                'father_name'         => $validated['father_name'],
                'cnic'                => $validated['cnic'],
                'phone'               => $validated['mobile_number'],
                'qualification'       => $validated['last_qualification'],
                'address'             => $validated['home_address'],
                'is_profile_complete' => true,
                'profile_completed'   => true,
            ]);

            // 2. Fetch selected course fee
            $courseFee = 0;
            if (!empty($validated['course_id'])) {
                $course = Course::find($validated['course_id']);
                $courseFee = $course->fee ?? $course->total_fee ?? 0;
            }

            // 3. Fetch or generate registration sequence
            $existingAdmission = Admission::where('email', $user->email)
                ->orWhere('user_id', $user->id)
                ->first();

            if ($existingAdmission) {
                $regNo = $existingAdmission->registration_no;
                $nextSeq = $existingAdmission->reg_sequence_no ?? 1;
            } else {
                $latestReg = Admission::orderBy('id', 'desc')->first();
                $nextSeq = $latestReg ? (($latestReg->reg_sequence_no ?? 0) + 1) : 1;
                $paddedSeq = str_pad($nextSeq, 5, '0', STR_PAD_LEFT);
                $yearMonth = Carbon::now()->format('Y-m');
                $regNo = "LC-REG-{$yearMonth}-{$paddedSeq}";
            }

            // 4. Upsert Admission Record
            Admission::updateOrCreate(
                [
                    'email' => $user->email,
                ],
                [
                    'user_id'            => $user->id,
                    'registration_no'    => $regNo,
                    'reg_sequence_no'    => $nextSeq,
                    'admission_date'     => $existingAdmission->admission_date ?? Carbon::today()->format('Y-m-d'),
                    'student_name'       => $user->name,
                    'father_name'        => $validated['father_name'],
                    'cnic'               => $validated['cnic'],
                    'cnic_bform'         => $validated['cnic'],
                    'dob'                => $validated['dob'] ?? null,
                    'gender'             => $validated['gender'],
                    'home_address'       => $validated['home_address'],
                    'residential_address'=> $validated['home_address'],
                    'mobile_number'      => $validated['mobile_number'],
                    'mobile_contact'     => $validated['mobile_number'],
                    'whatsapp_number'    => $validated['whatsapp_number'] ?? $validated['mobile_number'],
                    'whatsapp_contact'   => $validated['whatsapp_number'] ?? $validated['mobile_number'],
                    'guardian_phone'     => $validated['guardian_phone'] ?? null,
                    'guardian_contact'   => $validated['guardian_phone'] ?? null,
                    'last_qualification' => $validated['last_qualification'],
                    'course_id'          => $validated['course_id'] ?? null,
                    'shift'              => $validated['shift'] ?? 'Morning',
                    'preferred_shift'    => $validated['shift'] ?? 'Morning',
                    'total_agreed_fee'   => $courseFee,
                    'status'             => $existingAdmission->status ?? 'Learning',
                ]
            );
        });

        return redirect()->route('student.dashboard')->with('success', 'Profile and admission credentials updated successfully!');
    }
}