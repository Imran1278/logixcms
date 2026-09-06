<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchController extends Controller
{
    /**
     * List all batches with dynamic status calculation.
     */
    public function index(): View
    {
        $batches = Batch::with(['course', 'teacher'])
            ->orderBy('id', 'desc')
            ->get();

        $today = Carbon::today();
        foreach ($batches as $batch) {
            $startDate = Carbon::parse($batch->start_date);
            $endDate = Carbon::parse($batch->end_date);

            if ($today->lt($startDate)) {
                $batch->calculated_status = 'Upcoming';
            } elseif ($today->between($startDate, $endDate)) {
                $batch->calculated_status = 'Active';
            } else {
                $batch->calculated_status = 'Completed';
            }
        }

        return view('admin.batches.index', compact('batches'));
    }

    /**
     * Show create batch form.
     */
    public function create(): View
    {
        $courses = Course::where('status', 1)->get();
        return view('admin.batches.create', compact('courses'));
    }

    /**
     * Display detailed batch record.
     */
    public function show(int|string $id): View
    {
        $batch = Batch::with(['course', 'admissions'])->findOrFail($id);

        return view('admin.batches.show', compact('batch'));
    }

    /**
     * Fetch next available batch number via AJAX.
     */
    public function getNextBatchNumber(int|string $courseId): JsonResponse
    {
        $course = Course::findOrFail($courseId);

        $lastBatch = Batch::where('course_id', $courseId)
            ->orderBy('batch_sequence_no', 'desc')
            ->first();

        $nextSequence = $lastBatch ? ($lastBatch->batch_sequence_no + 1) : 101;
        $nextBatchCode = $course->course_code . '-' . $nextSequence;

        return response()->json([
            'course_code'            => $course->course_code,
            'next_sequence'          => $nextSequence,
            'suggested_batch_number' => $nextBatchCode,
            'duration'               => $course->duration,
            'duration_type'          => $course->duration_type,
        ]);
    }

    /**
     * Store new batch entry.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id'         => 'required|exists:courses,id',
            'batch_sequence_no' => 'required|integer',
            'start_date'        => 'required|date',
            'class_timing'      => 'nullable|string|max:100',
            'class_room'        => 'nullable|string|max:100',
            'teacher_id'        => 'nullable|exists:users,id',
            'capacity'          => 'required|integer|min:1',
            'batch_title'       => 'nullable|string|max:255',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Prevent duplicate sequence numbers for the same course
        $existingSequence = Batch::where('course_id', $course->id)
            ->where('batch_sequence_no', $validated['batch_sequence_no'])
            ->exists();

        if ($existingSequence) {
            return back()->withErrors(['batch_sequence_no' => 'This batch sequence already exists for this course!'])->withInput();
        }

        $batchNumber = $course->course_code . '-' . $validated['batch_sequence_no'];

        // Calculate End Date based on Course Duration
        $startDate = Carbon::parse($validated['start_date']);
        if ($course->duration_type === 'Months') {
            $endDate = $startDate->copy()->addMonths($course->duration);
        } else {
            $endDate = $startDate->copy()->addWeeks($course->duration);
        }

        Batch::create([
            'course_id'         => $course->id,
            'batch_number'      => $batchNumber,
            'batch_sequence_no' => $validated['batch_sequence_no'],
            'batch_title'       => $validated['batch_title'] ?? ($course->course_name . ' - Batch ' . $validated['batch_sequence_no']),
            'start_date'        => $startDate->format('Y-m-d'),
            'end_date'          => $endDate->format('Y-m-d'),
            'class_timing'      => $validated['class_timing'] ?? null,
            'class_room'        => $validated['class_room'] ?? null,
            'teacher_id'        => $validated['teacher_id'] ?? null,
            'capacity'          => $validated['capacity'],
            'status'            => 'Upcoming',
        ]);

        return redirect()->back()->with('success', "Batch {$batchNumber} created successfully!");
    }
}