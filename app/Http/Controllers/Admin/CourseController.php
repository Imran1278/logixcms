<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::latest('id')->paginate(10);
        
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name'      => 'required|string|max:255',
            'course_code'      => 'required|string|max:50',
            'duration'         => 'nullable|string',
            'duration_type'    => 'nullable|string',
            'standard_fee'     => 'required|numeric',
            'registration_fee' => 'nullable|numeric',
            'certification_fee'=> 'nullable|numeric',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'      => 'nullable|string',
            'objectives'       => 'nullable|string',
            'eligibility'      => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/courses', 'public');
            $validated['image'] = $path;
        }

        // Explicitly capture rich text content
        $validated['description'] = $request->input('description');
        $validated['objectives']  = $request->input('objectives');
        $validated['eligibility'] = $request->input('eligibility');

        Course::create($validated);

        return back()->with('success', 'Course created successfully with all curriculum details!');
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_name'      => 'required|string|max:255',
            'course_code'      => 'required|string|max:50',
            'duration'         => 'nullable|string',
            'standard_fee'     => 'required|numeric',
            'registration_fee' => 'nullable|numeric',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'      => 'nullable|string',
            'objectives'       => 'nullable|string',
            'eligibility'      => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/courses', 'public');
            $validated['image'] = $path;
        }

        $validated['description'] = $request->input('description');
        $validated['objectives']  = $request->input('objectives');
        $validated['eligibility'] = $request->input('eligibility');

        $course->update($validated);

        return back()->with('success', 'Course updated successfully!');
    }

    /**
     * Display the specified course details.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        
        $otherCourses = Course::where('id', '!=', $id)
            ->where('status', 1)
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.courses.show', compact('course', 'otherCourses'));
    }
}