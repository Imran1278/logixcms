<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeeSettingController extends Controller
{
    public function index(): View
    {
        $sessions = FeeSetting::where('type', 'session')->latest()->get();
        $frequencies = FeeSetting::where('type', 'frequency')->latest()->get();
        $scholarshipReasons = FeeSetting::where('type', 'scholarship_reason')->latest()->get();

        return view('admin.fees.settings.index', compact('sessions', 'frequencies', 'scholarshipReasons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type'  => 'required|in:session,frequency,scholarship_reason',
            'title' => 'required|string|max:255',
        ]);

        FeeSetting::create([
            'type'  => $request->type,
            'title' => $request->title,
        ]);

        return back()->with('success', 'Fee setting added successfully!');
    }

    public function destroy(FeeSetting $feeSetting): RedirectResponse
    {
        $feeSetting->delete();
        return back()->with('success', 'Fee setting deleted successfully!');
    }
}