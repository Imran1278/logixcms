<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLeaveController extends Controller
{
    /**
     * Display pending and processed leave applications with Student 2FA status.
     */
    public function index(): View
    {
        $leaves = Leave::with(['user', 'batch'])->latest()->get();
        return view('admin.leaves.index', compact('leaves'));
    }

    /**
     * Reset Student 2FA Authenticator (Requires Student to re-scan QR Code).
     */
    public function reset2FA(int $studentId): RedirectResponse
    {
        $student = User::findOrFail($studentId);
        $student->google2fa_secret = null;
        $student->is_2fa_enabled = false;
        $student->save();

        return redirect()->back()->with('success', 'Student 2FA Authenticator reset successfully. The student will be prompted to scan a new QR code upon next check-in.');
    }

    /**
     * Update Leave Status (Approve or Reject) with Admin Remarks.
     */
    public function updateLeaveStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status'        => 'required|in:Approved,Rejected',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $leave = Leave::findOrFail($id);
        $leave->status = $validated['status'];
        $leave->admin_remarks = $validated['admin_remarks'] ?? null;
        $leave->save();

        return redirect()->back()->with('success', 'Leave application status updated to ' . $validated['status'] . '.');
    }
}