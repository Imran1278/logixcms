<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FinderQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class FinderQuestionController extends Controller
{
    /**
     * Display all Finder Questions in Admin
     */
    public function index(): View
    {
        $questions = FinderQuestion::with('options')->orderBy('step_number', 'asc')->get();
        return view('admin.course_finder.index', compact('questions'));
    }

    /**
     * Store new Question Step with Options
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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
            DB::transaction(function () use ($validated) {
                $question = FinderQuestion::create([
                    'question'    => $validated['question'],
                    'field_name'  => $validated['field_name'],
                    'step_number' => $validated['step_number'],
                    'icon'        => $validated['icon'] ?? null,
                ]);

                foreach ($validated['options'] as $opt) {
                    if (!empty($opt['label']) && !empty($opt['value'])) {
                        $question->options()->create([
                            'option_label' => $opt['label'],
                            'option_value' => $opt['value'],
                            'icon'         => $opt['icon'] ?? null,
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', 'Question step created successfully.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Error creating question step: ' . $e->getMessage());
        }
    }

    /**
     * Delete Question Step
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $question = FinderQuestion::findOrFail($id);
                $question->options()->delete();
                $question->delete();
            });

            return redirect()->back()->with('success', 'Question step deleted successfully.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Unable to delete question step.');
        }
    }
}