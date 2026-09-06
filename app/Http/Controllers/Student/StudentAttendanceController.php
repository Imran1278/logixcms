<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Exports\StudentAttendanceExport;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentAttendanceController extends Controller
{
    /**
     * Display QR Setup or Attendance Dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();

        // 1. If 2FA is not enabled, generate secret & show QR Code view
        if (!$user->is_2fa_enabled) {
            if (!$user->google2fa_secret) {
                $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->save();
            }

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name', 'EduPortal'),
                $user->email,
                $user->google2fa_secret
            );

            $writer = new Writer(new ImageRenderer(new RendererStyle(200), new SvgImageBackEnd()));
            $qrCodeSvg = $writer->writeString($qrCodeUrl);

            return view('student.attendance.setup_2fa', compact('qrCodeSvg'));
        }

        // 2. Fetch Student Attendance & Leaves History
        $attendances = Attendance::where('admission_id', $user->id)
            ->orderBy('attendance_date', 'desc')
            ->get();

        $leaves = Leave::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('student.partials.attendance', compact('attendances', 'leaves'));
    }

    /**
     * Initial 2FA Link Verification
     */
    public function enable2FA(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric'
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            $user->is_2fa_enabled = true;
            $user->save();

            return redirect()->to(route('student.dashboard') . '#attendances')
                ->with('success', 'Authenticator Linked Successfully!')
                ->with('auto_open_checkin', true);
        }

        return back()->with('error', 'Invalid Authenticator OTP Code. Please try again.');
    }

    /**
     * Daily Check-In Attendance via OTP
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric'
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp_code);

        if (!$valid) {
            return back()->with('error', 'Invalid Authenticator Code.');
        }

        $today = date('Y-m-d');
        $batchId = $user->batch_id ?? ($user->admission->batch_id ?? 1);

        Attendance::updateOrCreate(
            [
                'admission_id'    => $user->id,
                'attendance_date' => $today,
            ],
            [
                'batch_id'      => $batchId,
                'status'        => 'Present',
                'check_in_time' => now()->toTimeString(),
            ]
        );

        return redirect()->to(route('student.dashboard') . '#attendances')
            ->with('success', 'Attendance Checked-In Successfully for Today!');
    }

    /**
     * Submit Leave Application
     */
    public function applyLeave(Request $request)
    {
        $request->validate([
            'leave_date' => 'required|date',
            'reason'     => 'required|string|max:500',
        ]);

        $user = auth()->user();
        $batchId = $user->batch_id ?? ($user->admission->batch_id ?? 1);

        Leave::create([
            'user_id'    => $user->id,
            'batch_id'   => $batchId,
            'leave_date' => $request->leave_date,
            'reason'     => $request->reason,
            'status'     => 'Pending',
        ]);

        return redirect()->to(route('student.dashboard') . '#attendances')
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Export Attendance History to Excel
     */
    public function exportExcel(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        return Excel::download(
            new StudentAttendanceExport(auth()->id(), $fromDate, $toDate), 
            'my_attendance_report_' . date('Y_m_d') . '.xlsx'
        );
    }

    /**
     * Export Attendance History to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Attendance::where('admission_id', auth()->id());

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('attendance_date', [$request->from_date, $request->to_date]);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();
        
        $pdf = Pdf::loadView('reports.student_attendance_pdf', compact('attendances'));

        return $pdf->download('my_attendance_report_' . date('Y_m_d') . '.pdf');
    }
}