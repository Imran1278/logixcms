<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use App\Models\LatestNews;
use App\Models\UpcomingNews;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Exception;

class NewsReleaseController extends Controller
{
    /**
     * Admin News & Press Releases CMS Dashboard.
     */
    public function index(): View
    {
        $pressReleases = PressRelease::latest()->get();
        $latestNews    = LatestNews::latest()->get();
        $upcomingNews  = UpcomingNews::latest()->get();

        return view('admin.news_releases.index', compact('pressReleases', 'latestNews', 'upcomingNews'));
    }

    /**
     * Store new Press Release.
     */
    public function storePressRelease(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/press_releases'), $filename);
                $validated['image'] = 'uploads/press_releases/' . $filename;
            }

            $validated['status'] = 1;

            PressRelease::create($validated);

            return redirect()->back()->with('success', 'Press Release added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Unable to add Press Release: ' . $e->getMessage());
        }
    }

    /**
     * Destroy Press Release.
     */
    public function destroyPressRelease(int $id): RedirectResponse
    {
        try {
            $item = PressRelease::findOrFail($id);

            if ($item->image && File::exists(public_path($item->image))) {
                File::delete(public_path($item->image));
            }

            $item->delete();

            return redirect()->back()->with('success', 'Press Release deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Deletion failed.');
        }
    }

    /**
     * Store Latest News Entry.
     */
    public function storeLatestNews(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'news_date'   => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        LatestNews::create($validated);

        return redirect()->back()->with('success', 'Latest News added successfully!');
    }

    /**
     * Destroy Latest News Entry.
     */
    public function destroyLatestNews(int $id): RedirectResponse
    {
        LatestNews::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Latest News deleted successfully!');
    }

    /**
     * Store Upcoming News Entry.
     */
    public function storeUpcomingNews(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'news_date'   => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        UpcomingNews::create($validated);

        return redirect()->back()->with('success', 'Upcoming News added successfully!');
    }

    /**
     * Destroy Upcoming News Entry.
     */
    public function destroyUpcomingNews(int $id): RedirectResponse
    {
        UpcomingNews::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Upcoming News deleted successfully!');
    }
}