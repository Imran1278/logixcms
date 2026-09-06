<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentAttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected int $userId;
    protected ?string $fromDate;
    protected ?string $toDate;

    public function __construct(int $userId, ?string $fromDate = null, ?string $toDate = null)
    {
        $this->userId   = $userId;
        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;
    }

    /**
     * Retrieve attendance collection.
     */
    public function collection()
    {
        $query = Attendance::where('admission_id', $this->userId);

        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('attendance_date', [$this->fromDate, $this->toDate]);
        }

        return $query->orderBy('attendance_date', 'desc')->get();
    }

    /**
     * Map dataset attributes to structured columns.
     */
    public function map($attendance): array
    {
        return [
            \Carbon\Carbon::parse($attendance->attendance_date)->format('d M, Y'),
            $attendance->check_in_time ? date('h:i A', strtotime($attendance->check_in_time)) : 'N/A',
            ucfirst($attendance->status),
            $attendance->remarks ?? '-',
        ];
    }

    /**
     * Table headings configuration.
     */
    public function headings(): array
    {
        return [
            'Attendance Date',
            'Check-In Time',
            'Status',
            'Remarks',
        ];
    }

    /**
     * Apply custom styles to Excel worksheet.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Header Row Styling
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color'    => ['argb' => '0B2545'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}