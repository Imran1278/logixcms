@extends('layouts.app')

@section('page_title', 'Mark Student Attendance')

@push('styles')
<style>
    .att-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .att-header {
        background: #0b2545;
        color: #ffffff;
        border-radius: 16px 16px 0 0 !important;
        padding: 18px 24px;
    }
    .status-btn-group .btn-check:checked + .btn-outline-success {
        background-color: #198754 !important;
        color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-danger {
        background-color: #dc3545 !important;
        color: #fff !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
    .status-btn-group .btn-check:checked + .btn-outline-info {
        background-color: #0dcaf0 !important;
        color: #000 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="card att-card border-0 mb-4">
        <div class="card-header att-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-clipboard-user me-2 text-warning"></i> Mark Daily Attendance</h5>
            <a href="{{ route('attendance.report') }}" class="btn btn-sm btn-warning text-dark fw-bold px-3">
                <i class="fa-solid fa-chart-line me-1"></i> Attendance Analytics & Reports
            </a>
        </div>
        <div class="card-body p-4">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('attendance.index') }}" class="row g-3 mb-4 p-3 bg-light rounded-3 border">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-secondary">Select Academic Batch</label>
                    <select name="batch_id" class="form-select shadow-sm" required>
                        <option value="">-- Choose Batch --</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id }}" {{ request('batch_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->batch_code ?? $b->batch_number ?? 'Batch #'.$b->id }} ({{ $b->course->course_name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Attendance Date</label>
                    <input type="date" name="date" class="form-control shadow-sm" value="{{ $date ?? date('Y-m-d') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary fw-bold w-100 shadow-sm">
                        <i class="fa-solid fa-filter me-1"></i> Fetch Class Sheet
                    </button>
                </div>
            </form>

            @if($selectedBatch)
            <hr class="my-4">
            
            <!-- Attendance Marking Form -->
            <form method="POST" action="{{ route('attendance.store') }}">
                @csrf
                <input type="hidden" name="batch_id" value="{{ $selectedBatch->id }}">
                <input type="hidden" name="attendance_date" value="{{ $date }}">

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr class="text-uppercase fs-8 tracking-wider">
                                <th class="ps-3" style="width: 150px;">Reg No</th>
                                <th>Student Name</th>
                                <th class="text-center" style="width: 340px;">Mark Status</th>
                                <th style="width: 250px;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                @php
                                    $prevAttendance = $student->attendances->first() ?? null;
                                    $prevStatus = $prevAttendance->status ?? 'Present';
                                    $prevRemarks = $prevAttendance->remarks ?? '';
                                    $studentName = $student->student_name ?? $student->name ?? 'Student #'.$student->id;
                                    $regNo = $student->registration_no ?? $student->roll_no ?? 'N/A';
                                @endphp
                            <tr>
                                <td class="ps-3">
                                    <span class="badge bg-dark font-monospace px-2 py-1">{{ $regNo }}</span>
                                </td>
                                <td class="fw-bold text-dark">{{ $studentName }}</td>
                                <td class="text-center">
                                    <div class="btn-group status-btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="p_{{ $student->id }}" value="Present" {{ strtolower($prevStatus) == 'present' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success btn-sm fw-bold" for="p_{{ $student->id }}">P</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="a_{{ $student->id }}" value="Absent" {{ strtolower($prevStatus) == 'absent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger btn-sm fw-bold" for="a_{{ $student->id }}">A</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="l_{{ $student->id }}" value="Late" {{ strtolower($prevStatus) == 'late' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning btn-sm fw-bold" for="l_{{ $student->id }}">L</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="lv_{{ $student->id }}" value="Leave" {{ strtolower($prevStatus) == 'leave' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-info btn-sm fw-bold" for="lv_{{ $student->id }}">LV</label>
                                    </div>
                                </td>
                                <td class="pe-3">
                                    <input type="text" name="remarks[{{ $student->id }}]" class="form-control form-control-sm" value="{{ $prevRemarks }}" placeholder="Notes...">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No students enrolled in this batch yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->count() > 0)
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Attendance Sheet
                        </button>
                    </div>
                @endif
            </form>
            @endif
        </div>
    </div>
</div>
@endsection