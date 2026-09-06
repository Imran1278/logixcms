<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Exception;

class TutorController extends Controller
{
    /**
     * Display Tutor CMS Management view.
     */
    public function index(): View
    {
        $tutors = Tutor::latest()->paginate(10);
        return view('admin.tutors.index', compact('tutors'));
    }

    /**
     * Store new Tutor profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'rank'      => ['required', 'string', 'max:255'],
            'image'     => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'bio'       => ['nullable', 'string'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube'   => ['nullable', 'url', 'max:255'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/tutors'), $imageName);
                $validated['image'] = 'uploads/tutors/' . $imageName;
            }

            $validated['status'] = 1;

            Tutor::create($validated);

            return redirect()->back()->with('success', 'Tutor added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add tutor: ' . $e->getMessage());
        }
    }

    /**
     * Delete existing Tutor record & image resource.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $tutor = Tutor::findOrFail($id);

            if ($tutor->image && File::exists(public_path($tutor->image))) {
                File::delete(public_path($tutor->image));
            }

            $tutor->delete();

            return redirect()->back()->with('success', 'Tutor deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete tutor resource.');
        }
    }
}