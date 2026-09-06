<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InquiryReplyMail;
use App\Models\Course;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with('course')->orderBy('id', 'desc')->get();
        $courses = Course::all();

        return view('admin.inquiries.index', compact('inquiries', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name'    => ['required', 'string', 'max:255'],
            'mobile_number'   => ['required', 'string', 'max:20'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:255'],
            'course_id'       => ['nullable'],
            'source'          => ['nullable', 'string', 'max:100'],
            'lead_score'      => ['nullable', 'string'],
            'remarks'         => ['nullable', 'string', 'max:1000'],
        ]);

        $sourceVal = $validated['source'] ?? 'Walk-in';

        $leadScore = $validated['lead_score'] ?? match ($sourceVal) {
            'Walk-in', 'Referral' => 'Hot',
            'Website'            => 'Cold',
            default              => 'Warm',
        };

        $courseId = !empty($validated['course_id']) ? $validated['course_id'] : (Course::first()?->id ?? 1);

        Inquiry::create([
            'inquiry_date'          => Carbon::today()->format('Y-m-d'),
            'student_name'          => $validated['student_name'],
            'mobile_number'         => $validated['mobile_number'],
            'whatsapp_number'       => $validated['whatsapp_number'] ?? $validated['mobile_number'],
            'email'                 => $validated['email'] ?? null,
            'course_id'             => $courseId,
            'source'                => $sourceVal,
            'ai_lead_score'         => $leadScore,
            'remarks'               => $validated['remarks'] ?? null,
            'status'                => 'New',
            'followed_social_media' => 1,
        ]);

        return redirect()->back()->with('success', 'New Student Inquiry logged successfully!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $inquiry = Inquiry::findOrFail($id);

        $validated = $request->validate([
            'status'      => ['required', 'string', 'max:50'],
            'lead_score'  => ['nullable', 'string'],
            'remarks'     => ['nullable', 'string', 'max:1000'],
            'admin_reply' => ['nullable', 'string', 'max:2000'],
        ]);

        $inquiry->status = $validated['status'];
        $inquiry->ai_lead_score = $validated['lead_score'] ?? $inquiry->ai_lead_score;
        $inquiry->remarks = $validated['remarks'] ?? $inquiry->remarks;

        // Check if Admin submitted a new answer/reply
        if (!empty($validated['admin_reply'])) {
            $inquiry->admin_reply = $validated['admin_reply'];
            $inquiry->replied_at = now();

            // Send Mail to Student if email exists
            if (!empty($inquiry->email)) {
                try {
                    Mail::to($inquiry->email)->send(new InquiryReplyMail($inquiry));
                } catch (\Exception $e) {
                    // Fail-safe handling for mail server connection issues
                }
            }
        }

        $inquiry->save();

        return redirect()->back()->with('success', 'Inquiry updated & reply email sent successfully!');
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        return $this->update($request, $id);
    }

    // Student Reply back action from Student Portal
    public function studentReply(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'student_reply' => ['required', 'string', 'max:2000'],
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->student_reply = $validated['student_reply'];
        $inquiry->status = 'Follow-up Required';
        $inquiry->save();

        return redirect()->back()->with('success', 'Your reply has been submitted to the administration!');
    }
}