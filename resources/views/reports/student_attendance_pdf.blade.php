<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Attendance Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #0b2545;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            color: #0b2545;
            text-transform: uppercase;
        }
        .meta-info {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
            border-left: 4px solid #0b2545;
        }
        .meta-info td {
            padding: 4px 8px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th {
            background-color: #0b2545;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            padding: 8px;
            border: 1px solid #0b2545;
            text-align: left;
        }
        table.data-table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: middle;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .badge-present { background-color: #d1e7dd; color: #0f5132; }
        .badge-absent { background-color: #f8d7da; color: #842029; }
        .badge-late { background-color: #fff3cd; color: #664d03; }
        .badge-leave { background-color: #cff4fc; color: #055160; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td class="title">Student Attendance Ledger</td>
                <td style="text-align: right; font-size: 10px; color: #64748b;">
                    Generated: {{ date('d M, Y | h:i A') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="meta-info">
        <table style="width: 100%;">
            <tr>
                <td style="width: 15%;"><strong>Student:</strong></td>
                <td style="width: 35%;">{{ auth()->user()->name ?? 'Student' }}</td>
                <td style="width: 15%;"><strong>Email:</strong></td>
                <td style="width: 35%;">{{ auth()->user()->email ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%; text-align: center;">#</th>
                <th style="width: 30%;">Date</th>
                <th style="width: 30%;">Check-In Time</th>
                <th style="width: 32%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $att)
                @php
                    $statusClass = match(strtolower($att->status)) {
                        'present' => 'badge-present',
                        'absent'  => 'badge-absent',
                        'late'    => 'badge-late',
                        'leave'   => 'badge-leave',
                        default   => 'badge-present'
                    };
                @endphp
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($att->attendance_date)->format('d M, Y') }}</td>
                <td>
                    {{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A') : 'Manual Mark' }}
                </td>
                <td style="text-align: center;">
                    <span class="badge {{ $statusClass }}">{{ strtoupper($att->status) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #6c757d; padding: 15px;">
                    No attendance records available for this period.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated document from Logix College ERP. No signature required.</p>
    </div>
</body>
</html>