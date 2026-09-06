<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\Tutor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the CMS editor in admin area.
     */
    public function index(): View
    {
        $about = AboutContent::first() ?? new AboutContent();
        return view('admin.about.index', compact('about'));
    }

    /**
     * Update About page dynamic content, videos, industry logos & awards.
     */
    public function updateAdmin(Request $request): RedirectResponse
    {
        $about = AboutContent::first() ?? new AboutContent();

        $validated = $request->validate([
            'home_title'                 => ['required', 'string', 'max:255'],
            'home_description'           => ['nullable', 'string'],
            'home_video_file'            => ['nullable', 'file', 'mimes:mp4,mkv,webm', 'max:51200'], // 50MB
            'our_vision'                 => ['nullable', 'string'],
            'trained_professionals_info' => ['nullable', 'string'],
            'why_logix_title'           => ['nullable', 'string', 'max:255'],
            'why_logix_description'     => ['nullable', 'string'],
            'why_logix_icon'            => ['nullable', 'string', 'max:100'],
            'educational_goals'         => ['nullable', 'string'],
            'our_mission'                => ['nullable', 'string'],
            'specific_goals'             => ['nullable', 'string'],
            'college_awards'             => ['nullable', 'string'],
            'industries'                 => ['nullable', 'array'],
            'industries.*.name'          => ['nullable', 'string', 'max:255'],
            'industries.*.description'   => ['nullable', 'string'],
            'industries.*.image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'awards'                     => ['nullable', 'array'],
            'awards.*'                   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $about, &$validated) {
            // 1. Handle Promotional Video Upload
            if ($request->hasFile('home_video_file')) {
                if (!empty($about->home_video_url) && File::exists(public_path($about->home_video_url))) {
                    File::delete(public_path($about->home_video_url));
                }

                $file = $request->file('home_video_file');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-.]/', '', $file->getClientOriginalName());
                $file->move(public_path('uploads/videos'), $filename);
                $validated['home_video_url'] = 'uploads/videos/' . $filename;
            }

            // 2. Handle Industry Cards Array
            $newIndustries = [];
            if ($request->has('industries')) {
                foreach ($request->industries as $index => $ind) {
                    $imgPath = $ind['existing_image'] ?? null;

                    if ($request->hasFile("industries.{$index}.image")) {
                        $file = $ind['image'];
                        $name = time() . '_ind_' . $index . '.' . $file->extension();
                        $file->move(public_path('uploads/industries'), $name);
                        $imgPath = 'uploads/industries/' . $name;
                    }

                    if (!empty($ind['name']) || !empty($ind['description']) || $imgPath) {
                        $newIndustries[] = [
                            'name'        => $ind['name'] ?? '',
                            'description' => $ind['description'] ?? '',
                            'image'       => $imgPath,
                        ];
                    }
                }
            }
            $validated['industries'] = $newIndustries;

            // 3. Handle Award Images Upload
            $existingAwards = $about->awards ?? [];
            if ($request->hasFile('awards')) {
                foreach ($request->file('awards') as $awardFile) {
                    $aName = time() . '_award_' . uniqid() . '.' . $awardFile->extension();
                    $awardFile->move(public_path('uploads/awards'), $aName);
                    $existingAwards[] = 'uploads/awards/' . $aName;
                }
            }
            $validated['awards'] = $existingAwards;

            // Save Model
            $about->fill($validated)->save();
        });

        return redirect()->route('admin.about.index')
            ->with('success', 'About content updated successfully!');
    }

    /**
     * Delete a single award image via AJAX.
     */
    public function deleteAward(Request $request): JsonResponse
    {
        $request->validate(['index' => ['required', 'integer']]);

        $about = AboutContent::first();

        if ($about && isset($about->awards[$request->index])) {
            $awards = $about->awards;
            $filePath = public_path($awards[$request->index]);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            array_splice($awards, (int) $request->index, 1);
            $about->awards = array_values($awards);
            $about->save();

            return response()->json(['status' => 'success', 'message' => 'Award deleted successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Award image not found.'], 442);
    }

    /**
     * Display the public About Details page.
     */
    public function showDetails(): View
    {
        $about = AboutContent::first();
        $allTutors = Tutor::where('status', 1)->latest()->get();

        return view('about_details', compact('about', 'allTutors'));
    }
}