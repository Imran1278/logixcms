<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeeHeadController extends Controller
{
    /**
     * Display fee heads management page.
     */
    public function index(): View
    {
        $feeHeads = FeeHead::latest()->get();
        return view('admin.fees.heads.index', compact('feeHeads'));
    }

    /**
     * Store a newly created fee head in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_heads,name',
            'type' => 'required|in:Recurring,One-Time',
        ]);

        FeeHead::create([
            'name'      => $request->name,
            'type'      => $request->type,
            'is_active' => true,
        ]);

        return back()->with('success', 'Fee Head created successfully!');
    }

    /**
     * Delete fee head.
     */
    public function destroy(FeeHead $feeHead): RedirectResponse
    {
        $feeHead->delete();
        return back()->with('success', 'Fee Head deleted successfully!');
    }
}