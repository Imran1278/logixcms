<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Exception;

class FooterController extends Controller
{
    /**
     * Display the Admin Footer CMS settings page.
     */
    public function index(): View
    {
        $footer = Footer::first() ?? new Footer();
        return view('admin.footer.index', compact('footer'));
    }

    /**
     * Save or update footer configurations.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'about_description' => ['nullable', 'string'],
            'phone_number'      => ['nullable', 'string', 'max:100'],
            'working_hours'     => ['nullable', 'string', 'max:100'],
            'learning_title'    => ['nullable', 'string', 'max:100'],
            'map_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'copyright_text'    => ['nullable', 'string', 'max:255'],
            'bottom_phone'      => ['nullable', 'string', 'max:100'],
            'twitter_url'       => ['nullable', 'url', 'max:255'],
            'instagram_url'     => ['nullable', 'url', 'max:255'],
            'facebook_url'      => ['nullable', 'url', 'max:255'],
            'linkedin_url'      => ['nullable', 'url', 'max:255'],
            'support_links'     => ['nullable', 'array'],
        ]);

        try {
            $footer = Footer::first() ?? new Footer();

            // Handle Map Graphic Upload
            if ($request->hasFile('map_image')) {
                if (!empty($footer->map_image) && File::exists(public_path($footer->map_image))) {
                    File::delete(public_path($footer->map_image));
                }

                $file = $request->file('map_image');
                $filename = time() . '_map.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/footer'), $filename);
                $validated['map_image'] = 'uploads/footer/' . $filename;
            }

            Footer::updateOrCreate(['id' => $footer->id], $validated);

            return redirect()->back()->with('success', 'Footer settings updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update footer settings: ' . $e->getMessage());
        }
    }
}