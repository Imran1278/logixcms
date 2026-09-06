<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceReportExport;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Attendance;
use App\Models\Batch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendanceController extends Controller
{
    /**
     * Display batch list & manual attendance input form.
     */
    public function index(Request $request): View
    {
        $batches = Batch::with('course')->get();
        $selectedBatch = null;
        $students = collect();
        $date = $request->date ?? date('Y-m-d');

        if ($request->filled('batch_id')) {
            $selectedBatch = Batch::findOrFail($request->batch_id);

            // Fetch students along with their specific date attendance status
            $students = Admission::where('batch_id', $request->batch_id)
                ->with(['attendances' => function ($query) use ($date) {
                    $query->where('attendance_date', $date);
                }])
                ->get();
        }

        return view('admin.attendance.index', compact('batches', 'selectedBatch', 'students', 'date'));
    }

    /**
     * Store or Update attendance for a batch.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'batch_id'        => 'required|exists:batches,id',
            'attendance_date' => 'required|date',
            'attendance'      => 'required|array',
            'remarks'         => 'nullable|array',
        ]);

        foreach ($validated['attendance'] as $admissionId => $status) {
            Attendance::updateOrCreate(
                [
                    'admission_id'    => $admissionId,
                    'attendance_date' => $validated['attendance_date'],
                ],
                [
                    'batch_id' => $validated['batch_id'],
                    'status'   => $status,
                    'remarks'  => $request->remarks[$admissionId] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance batch records updated successfully!');
    }

    /**
     * Attendance Summary Report with Analytics & Date Range Filter.
     */
    public function report(Request $request): View
    {
        $batches = Batch::with('course')->get();
        $selectedBatch = null;
        $attendances = collect();

        $fromDate = $request->from_date ?? date('Y-m-01');
        $toDate = $request->to_date ?? date('Y-m-d');

        $analytics = [
            'total'              => 0,
            'present'            => 0,
            'absent'             => 0,
            'late'               => 0,
            'leave'              => 0,
            'present_percentage' => 0,
            'absent_percentage'  => 0,
        ];

        if ($request->filled('batch_id')) {
            $selectedBatch = Batch::findOrFail($request->batch_id);

            $attendances = Attendance::with(['admission', 'batch'])
                ->where('batch_id', $request->batch_id)
                ->whereBetween('attendance_date', [$fromDate, $toDate])
                ->orderBy('attendance_date', 'desc')
                ->get();

            $total = $attendances->count();
            if ($total > 0) {
                $present = $attendances->filter(fn($a) => strtolower($a->status) === 'present')->count();
                $absent  = $attendances->filter(fn($a) => strtolower($a->status) === 'absent')->count();
                $late    = $attendances->filter(fn($a) => strtolower($a->status) === 'late')->count();
                $leave   = $attendances->filter(fn($a) => strtolower($a->status) === 'leave')->count();

                $analytics = [
                    'total'              => $total,
                    'present'            => $present,
                    'absent'             => $absent,
                    'late'               => $late,
                    'leave'              => $leave,
                    'present_percentage' => round(($present / $total) * 100, 1),
                    'absent_percentage'  => round(($absent / $total) * 100, 1),
                ];
            }
        }

        return view('admin.attendance.report', compact('batches', 'selectedBatch', 'attendances', 'fromDate', 'toDate', 'analytics'));
    }

    /**
     * Export attendance report to Excel.
     */
    public function exportExcel(Request $request): BinaryFileResponse
    {
        $batchId  = $request->batch_id;
        $fromDate = $request->from_date ?? date('Y-m-01');
        $toDate   = $request->to_date ?? date('Y-m-d');

        $fileName = 'attendance_report_' . date('Y_m_d') . '.xlsx';

        return Excel::download(new AttendanceReportExport($batchId, $fromDate, $toDate), $fileName);
    }

    /**
     * Export attendance report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $batchId  = $request->batch_id;
        $fromDate = $request->from_date ?? date('Y-m-01');
        $toDate   = $request->to_date ?? date('Y-m-d');

        $query = Attendance::with(['admission', 'student', 'batch']);

        if ($batchId) {
            $query->where('batch_id', $batchId);
        }

        if ($fromDate && $toDate) {
            $query->whereBetween('attendance_date', [$fromDate, $toDate]);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();
        $batch = $batchId ? Batch::find($batchId) : null;

        $pdf = Pdf::loadView('reports.attendance_pdf', compact('attendances', 'batch', 'fromDate', 'toDate'));

        $fileName = 'attendance_report_' . date('Y_m_d') . '.pdf';
        return $pdf->download($fileName);
    }
}