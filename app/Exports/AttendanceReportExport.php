<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AttendanceReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected ?int $batchId;
    protected ?string $fromDate;
    protected ?string $toDate;

    public function __construct(?int $batchId = null, ?string $fromDate = null, ?string $toDate = null)
    {
        $this->batchId = $batchId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
     * Fetch attendance records based on filters.
     */
    public function collection(): Collection
    {
        return Attendance::query()
            ->with([
                'admission:id,student_name,registration_no',
                'batch:id,batch_code'
            ])
            ->when($this->batchId, fn ($query) => $query->where('batch_id', $this->batchId))
            ->when($this->fromDate && $this->toDate, fn ($query) => $query->whereBetween('attendance_date', [$this->fromDate, $this->toDate]))
            ->orderBy('attendance_date', 'desc')
            ->get();
    }

    /**
     * Excel sheet headers.
     */
    public function headings(): array
    {
        return [
            'Date',
            'Student Name',
            'Registration No',
            'Batch Code',
            'Status',
            'Remarks'
        ];
    }

    /**
     * Map dataset attributes to columns.
     *
     * @param Attendance $attendance
     */
    public function map($attendance): array
    {
        return [
            $attendance->attendance_date,
            $attendance->admission?->student_name ?? 'N/A',
            $attendance->admission?->registration_no ?? 'N/A',
            $attendance->batch?->batch_code ?? 'N/A',
            ucfirst((string) $attendance->status),
            $attendance->remarks ?? '-'
        ];
    }

    /**
     * Column formatting rules.
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    /**
     * Apply Enterprise Navy & Gold styling to header row.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Style header row (Row 1)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '0B2545'], // Enterprise Navy Header
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}