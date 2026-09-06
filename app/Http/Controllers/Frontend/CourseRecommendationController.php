<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FinderQuestion;
use App\Models\FinderOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CourseRecommendationController extends Controller
{
    /**
     * Public View for Course Finder
     */
    public function index(): View
    {
        $questions = FinderQuestion::with(['options' => function ($query) {$query->orderBy('id', 'asc');
        }])->orderBy('step_number', 'asc')->get();

        return view('course_finder.index', compact('questions'));
    }

    /**
     * Admin Dashboard View for Course Finder CMS
     */
    public function adminIndex(): View
    {
        $questions = FinderQuestion::with('options')->orderBy('step_number', 'asc')->get();

        return view('admin.course_finder.index', compact('questions'));
    }

    /**
     * Admin Store New Question & Options
     */
    public function adminStore(Request $request): RedirectResponse
    {
        $validated =$request->validate([
            'question'        => 'required|string|max:255',
            'field_name'      => 'required|string|max:100',
            'step_number'     => 'required|integer|min:1',
            'icon'            => 'nullable|string|max:255',
            'options'         => 'required|array|min:2',
            'options.*.label' => 'required|string|max:255',
            'options.*.value' => 'required|string|max:255',
            'options.*.icon'  => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated) {$question = FinderQuestion::create([
                    'question'    => $validated['question'],
                    'field_name'  => $validated['field_name'],
                    'step_number' => $validated['step_number'],
                    'icon'        => $validated['icon'] ?? null,
                ]);

                foreach ($validated['options'] as$opt) {
                    if (!empty($opt['label']) && !empty($opt['value'])) {$question->options()->create([
                            'option_label' => $opt['label'],
                            'option_value' => $opt['value'],
                            'icon'         => $opt['icon'] ?? null,
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', 'Question step created successfully!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Failed to create step: ' . $e->getMessage());
        }
    }

    /**
     * Admin Delete Question Step
     */
    public function adminDestroy(int $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $question = FinderQuestion::findOrFail($id);
                $question->options()->delete();$question->delete();
            });

            return redirect()->back()->with('success', 'Step deleted successfully!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Unable to delete step.');
        }
    }

    /**
     * Dynamic Course Recommendation Logic Process
     */
    public function recommend(Request $request): JsonResponse
    {
        $userAnswers =$request->except(['_token']);

        if (empty($userAnswers)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Please select your preferences.'
            ], 422);
        }

        // Convert field values to human-readable Question -> Option Label text
        $formattedAnswers = [];
        foreach ($userAnswers as $fieldName =>$selectedValue) {
            $question = FinderQuestion::where('field_name',$fieldName)->first();
            
            if ($question) {
                $option = FinderOption::where('finder_question_id',$question->id)
                    ->where(function($q) use ($selectedValue) {
                        $q->where('option_value',$selectedValue)
                          ->orWhere('id', $selectedValue)
                          ->orWhere('option_label', $selectedValue);
                    })->first();

                $selectedLabel =$option ? $option->option_label :$selectedValue;
                $formattedAnswers[] = "Question: \"{$question->question}\" -> Answer Selected: \"{$selectedLabel}\"";
            } else {
                $formattedAnswers[] = ucfirst(str_replace('_', ' ', $fieldName)) . ": " . $selectedValue;
            }
        }

        $answersText = implode("\n", $formattedAnswers);

        // Call Gemini AI
        $recommendedCourses =$this->getAiRecommendations($answersText,$userAnswers);

        return response()->json([
            'status' => 'success',
            'data'   => $recommendedCourses
        ]);
    }

    /**
     * Gemini AI Request Function
     */
    private function getAiRecommendations(string $answersText, array$rawAnswers): array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            Log::error('GEMINI_API_KEY is missing in your .env file!');
            return $this->getFallbackRecommendations($rawAnswers);
        }

        $prompt = "You are an expert career counselor for an IT and Vocational Training Institute.
Analyze the following user preferences and choices:

{$answersText}

Task:
1. Based strictly on their specific choices above, recommend 2 or 3 best matching courses.
2. If they chose design, offer design courses. If they chose web/coding, offer web development courses.
3. Provide a personalized 2-sentence reason for each course.

Output Requirement:
Return ONLY a valid JSON array of objects. Do not include markdown block wrappers or backticks.
[
  {
    \"title\": \"Course Name\",
    \"duration\": \"3 Months\",
    \"career\": \"Career Path / Job Roles\",
    \"reason\": \"Detailed personalized reason.\"
  }
]";

        try {
            // Updated Endpoint to standard gemini-1.5-flash
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key={$apiKey}";

            $response = Http::withHeaders([                 'Content-Type' => 'application/json',             ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'      => 0.7,
                    'topP'             => 0.95,
                    'responseMimeType' => 'application/json'
                ]
            ]);

            if ($response->successful()) {
                $responseData =$response->json();
                $aiText =$responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Clean JSON string
                $cleanJson = trim(preg_replace('/^```json\s*|^```\s*|\s*```$/m', '', $aiText));
                $courses = json_decode($cleanJson, true);

                if (is_array($courses) && count($courses) > 0) {
                    return $courses;
                }
                
                Log::warning('Gemini AI returned empty or invalid JSON structure: ' . $aiText);
            } else {
                // Log actual API Error details
                Log::error('Gemini API HTTP Error ' . $response->status() . ': ' . $response->body());
            }
        } catch (Throwable $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        // If Gemini API fails, Fallback will trigger
        return $this->getFallbackRecommendations($rawAnswers);
    }

    /**
     * Fallback Response (Only used if Gemini API fails)
     */
    private function getFallbackRecommendations(array $data): array
    {
        return [
            [
                'title'    => 'Full Stack Web Development (Fallback)',
                'duration' => '3 Months',
                'career'   => 'Web Developer / Software Engineer',
                'reason'   => 'API Connection Issue: Showing standard default web development path.'
            ]
        ];
    }
}