<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Mail\StudentInquiryMail;
use App\Models\Course;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mobile_number'         => ['required', 'string', 'max:20'],
            'followed_social_media' => ['required'],
            'remarks'               => ['required', 'string', 'max:1000'],
            'course_id'             => ['nullable'],
            'whatsapp_number'       => ['nullable', 'string', 'max:20'],
            'father_mobile'         => ['nullable', 'string', 'max:20'],
            'cnic'                  => ['nullable', 'string', 'max:20'],
        ], [
            'followed_social_media.required' => 'Social Media follow check is mandatory.',
            'mobile_number.required'         => 'Mobile number is required.',
            'remarks.required'               => 'Inquiry message details are required.',
        ]);

        $user = auth()->user();
        $studentObj = $user->student ?? null;

        $mobileNumber = $validated['mobile_number'] 
            ?? ($studentObj->mobile_number ?? $studentObj->phone ?? null) 
            ?? $user->phone 
            ?? 'N/A';

        $whatsappNumber = !empty($validated['whatsapp_number']) 
            ? $validated['whatsapp_number'] 
            : (($studentObj->whatsapp_number ?? null) ?? $mobileNumber);

        $fatherMobile = !empty($validated['father_mobile']) 
            ? $validated['father_mobile'] 
            : (($studentObj->father_mobile ?? null) ?? 'N/A');

        $cnicNumber = !empty($validated['cnic']) 
            ? $validated['cnic'] 
            : (($studentObj->cnic ?? null) ?? ($user->cnic ?? null));

        // Get first available course ID safely to respect Foreign Key Constraint
        $validCourseId = !empty($validated['course_id']) 
            ? $validated['course_id'] 
            : (Course::first()?->id ?? 1);

        try {
            $inquiry = Inquiry::create([
                'inquiry_date'          => Carbon::today()->format('Y-m-d'),
                'student_name'          => $user->name ?? $studentObj->full_name ?? 'Student User',
                'mobile_number'         => $mobileNumber,
                'whatsapp_number'       => $whatsappNumber,
                'father_mobile'         => $fatherMobile,
                'email'                 => $user->email ?? null,
                'cnic'                  => $cnicNumber,
                'course_id'             => $validCourseId,
                'source'                => 'Student Portal',
                'status'                => 'New',
                'followed_social_media' => 1,
                'ai_lead_score'         => 'Warm',
                'remarks'               => $validated['remarks'],
                'assigned_counselor_id' => null,
            ]);

            try {
                $adminEmail = config('mail.from.address', env('MAIL_FROM_ADDRESS'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new StudentInquiryMail($inquiry));
                }
            } catch (\Exception $e) {
                Log::error('StudentInquiryMail Sending Failed: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Inquiry Store Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to submit inquiry: ' . $e->getMessage());
        }
    }
}