<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeaderSettingController extends Controller
{
    public function index(): View
    {
        $settings = HeaderSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.header_settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except('_token', 'site_logo');

        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            ]);

            $oldLogo = HeaderSetting::getByKey('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('settings', 'public');
            HeaderSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        foreach ($data as $key => $value) {
            HeaderSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Header and Navigation settings updated successfully!');
    }
}