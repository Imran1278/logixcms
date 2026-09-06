@extends('layouts.app')

@section('page_title', 'Attendance Report & Analytics')

@push('styles')
<style>
    .report-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .report-header {
        background: #0b2545;
        color: #ffffff;
        border-radius: 16px 16px 0 0 !important;
        padding: 18px 24px;
    }
    .stat-box {
        border-radius: 12px;
        padding: 16px;
        transition: transform 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="card report-card border-0 mb-4">
        <div class="card-header report-header d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5"><i class="fa-solid fa-chart-pie me-2 text-warning"></i> Attendance Analytics & Reports</span>
            <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-warning text-dark fw-bold px-3">
                <i class="fa-solid fa-square-plus me-1"></i> Mark Attendance
            </a>
        </div>
        <div class="card-body p-4">
            
            <!-- Date-Range Filter & Export Form -->
            <form method="GET" action="{{ route('attendance.report') }}" class="mb-4 p-3 bg-light rounded-3 border">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary">Select Batch</label>
                        <select name="batch_id" class="form-select shadow-sm" required>
                            <option value="">-- Choose Batch --</option>
                            @foreach($batches as $b)
                                <option value="{{ $b->id }}" {{ request('batch_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->batch_code ?? $b->batch_number ?? 'Batch #'.$b->id }} ({{ $b->course->course_name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary">From Date</label>
                        <input type="date" name="from_date" class="form-control shadow-sm" value="{{ $fromDate }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary">To Date</label>
                        <input type="date" name="to_date" class="form-control shadow-sm" value="{{ $toDate }}">
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                                <i class="fa-solid fa-filter me-1"></i> Filter
                            </button>

                            @if(request('batch_id'))
                                <a href="{{ route('attendance.export.excel', ['batch_id' => request('batch_id'), 'from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                                   class="btn btn-success fw-bold text-nowrap shadow-sm" title="Export to Excel">
                                    <i class="fa-solid fa-file-excel"></i>
                                </a>
                                <a href="{{ route('attendance.export.pdf', ['batch_id' => request('batch_id'), 'from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                                   class="btn btn-danger fw-bold text-nowrap shadow-sm" title="Export to PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            @if($selectedBatch)
            <hr class="my-4">
            
            <!-- Summary Analytics Row with Chart -->
            <div class="row g-4 mb-4 align-items-center">
                <!-- Summary Stats Cards -->
                <div class="col-lg-7">
                    <div class="row g-3 text-center">
                        <div class="col-6 col-md-3">
                            <div class="stat-box bg-light border">
                                <small class="text-muted fw-bold fs-8 text-uppercase">Total Logs</small>
                                <h3 class="fw-bold mb-0 text-dark mt-1">{{ $analytics['total'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box bg-success-subtle border border-success-subtle">
                                <small class="text-success fw-bold fs-8 text-uppercase">Present</small>
                                <h3 class="fw-bold mb-0 text-success mt-1">{{ $analytics['present'] ?? 0 }}</h3>
                                <small class="fw-bold text-success">{{ $analytics['present_percentage'] ?? 0 }}%</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box bg-danger-subtle border border-danger-subtle">
                                <small class="text-danger fw-bold fs-8 text-uppercase">Absent</small>
                                <h3 class="fw-bold mb-0 text-danger mt-1">{{ $analytics['absent'] ?? 0 }}</h3>
                                <small class="fw-bold text-danger">{{ $analytics['absent_percentage'] ?? 0 }}%</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box bg-warning-subtle border border-warning-subtle">
                                <small class="text-warning-emphasis fw-bold fs-8 text-uppercase">Late / Leave</small>
                                <h3 class="fw-bold mb-0 text-warning-emphasis mt-1">{{ ($analytics['late'] ?? 0) + ($analytics['leave'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Percentage Donut Chart -->
                <div class="col-lg-5">
                    <div class="p-3 border rounded-3 bg-white shadow-sm d-flex flex-column align-items-center">
                        <h6 class="fw-bold text-secondary mb-2 fs-8 text-uppercase"><i class="fa-solid fa-chart-pie me-1 text-primary"></i> Attendance Distribution</h6>
                        <div style="width: 160px; height: 160px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Logs Table -->
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase fs-8 text-secondary">
                            <th class="ps-3">Date</th>
                            <th>Reg No</th>
                            <th>Student Name</th>
                            <th>Time Log</th>
                            <th class="text-center">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                        <tr>
                            <td class="ps-3">
                                <small class="fw-bold text-dark font-monospace">
                                    {{ \Carbon\Carbon::parse($att->attendance_date)->format('d M, Y') }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-dark font-monospace">
                                    {{ $att->admission->registration_no ?? $att->student->registration_no ?? $att->user->cnic ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $att->admission->student_name ?? $att->student->student_name ?? $att->user->name ?? 'N/A' }}
                            </td>
                            <td>
                                <small class="text-muted font-monospace">
                                    {{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A') : 'Manual' }}
                                </small>
                            </td>
                            <td class="text-center">
                                @php $statusLower = strtolower($att->status); @endphp

                                @if($statusLower == 'present')
                                    <span class="badge bg-success-subtle text-success px-3 py-1 fw-bold"><i class="fa-solid fa-check me-1"></i> Present</span>
                                @elseif($statusLower == 'absent')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-1 fw-bold"><i class="fa-solid fa-xmark me-1"></i> Absent</span>
                                @elseif($statusLower == 'late')
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-1 fw-bold"><i class="fa-solid fa-clock me-1"></i> Late</span>
                                @else
                                    <span class="badge bg-info-subtle text-info px-3 py-1 fw-bold"><i class="fa-solid fa-envelope me-1"></i> Leave</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $att->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No records found for the range {{ \Carbon\Carbon::parse($fromDate)->format('d M') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('attendanceChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent', 'Late', 'Leave'],
                    datasets: [{
                        data: [
                            {{ $analytics['present'] ?? 0 }}, 
                            {{ $analytics['absent'] ?? 0 }}, 
                            {{ $analytics['late'] ?? 0 }}, 
                            {{ $analytics['leave'] ?? 0 }}
                        ],
                        backgroundColor: ['#198754', '#dc3545', '#ffc107', '#0dcaf0'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: { boxWidth: 10, padding: 6, font: { size: 9 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush