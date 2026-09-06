<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Attendance Report - Logix College</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 11px; 
            color: #1e293b; 
            margin: 0;
            padding: 0;
        }
        .pdf-header { 
            border-bottom: 2px solid #0b2545; 
            padding-bottom: 12px; 
            margin-bottom: 15px; 
        }
        .brand-title { 
            margin: 0; 
            color: #0b2545; 
            font-size: 20px; 
            font-weight: bold;
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        .sub-title { 
            margin: 3px 0 0; 
            color: #64748b; 
            font-size: 11px; 
        }
        .meta-table { 
            width: 100%; 
            margin-bottom: 15px; 
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
        }
        .meta-table td { 
            padding: 4px 0; 
            font-size: 11px;
        }
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px; 
        }
        table.data-table th { 
            background-color: #0b2545; 
            color: #ffffff; 
            font-weight: bold; 
            text-transform: uppercase;
            font-size: 9px;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #0b2545;
        }
        table.data-table td { 
            border: 1px solid #cbd5e1; 
            padding: 7px 6px; 
            font-size: 10px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge { 
            padding: 3px 8px; 
            border-radius: 4px; 
            font-size: 9px; 
            font-weight: bold; 
            text-align: center;
            display: inline-block;
        }
        .bg-present { background-color: #d1e7dd; color: #0f5132; }
        .bg-absent { background-color: #f8d7da; color: #842029; }
        .bg-leave { background-color: #cff4fc; color: #055160; }
        .bg-late { background-color: #fff3cd; color: #664d03; }
        .pdf-footer { 
            margin-top: 25px; 
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            text-align: right; 
            font-size: 9px; 
            color: #94a3b8; 
        }
    </style>
</head>
<body>

    <div class="pdf-header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <h2 class="brand-title">LOGIX COLLEGE</h2>
                    <p class="sub-title">Official Student Attendance Ledger</p>
                </td>
                <td style="text-align: right; vertical-align: bottom;">
                    <p class="sub-title">Generated: {{ date('d M, Y | h:i A') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="meta-table">
        <table style="width: 100%;">
            <tr>
                <td><strong>Batch Code:</strong> {{ $batch->batch_code ?? $batch->batch_number ?? 'All Batches' }}</td>
                <td style="text-align: right;">
                    <strong>Date Scope:</strong> 
                    @if(isset($fromDate) && isset($toDate))
                        {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }} — {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}
                    @else
                        All Historical Logs
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th style="width: 70px;">Date</th>
                <th style="width: 85px;">Reg No</th>
                <th>Student Name</th>
                <th style="width: 75px;">Batch</th>
                <th style="width: 65px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->attendance_date)->format('d-m-Y') }}</td>
                <td><strong>{{ $item->admission->registration_no ?? $item->student->registration_no ?? $item->user->cnic ?? 'N/A' }}</strong></td>
                <td>{{ $item->admission->student_name ?? $item->student->student_name ?? $item->user->name ?? 'N/A' }}</td>
                <td>{{ $item->batch->batch_code ?? $item->batch->batch_number ?? 'N/A' }}</td>
                <td style="text-align: center;">
                    @php $statusLower = strtolower($item->status); @endphp
                    @if($statusLower == 'present')
                        <span class="badge bg-present">PRESENT</span>
                    @elseif($statusLower == 'absent')
                        <span class="badge bg-absent">ABSENT</span>
                    @elseif($statusLower == 'leave')
                        <span class="badge bg-leave">LEAVE</span>
                    @else
                        <span class="badge bg-late">{{ strtoupper($item->status) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 15px; color: #64748b;">No attendance records found for this selection.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pdf-footer">
        <p>This is a system-generated official record from LOGIX ERP. No physical signature is required.</p>
    </div>

</body>
</html>