@extends('layouts.app')

@section('page_title', 'Batch Overview - ' . ($batch->batch_number ?? $batch->batch_code ?? $batch->batch_name))

@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        
        --panel-bg: #FFFFFF;
        --panel-border: #E2E8F0;
        --panel-header-bg: #0A2D5A;
        --panel-header-text: #FFFFFF;
        --input-bg: #FFFFFF;
        --input-border: #CBD5E1;
        --input-text: #0F172A;
        --text-primary: #0F172A;
        --text-muted: #64748B;
        --card-bg: #FFFFFF;
        --box-subtle-bg: #F8FAFC;
        --table-hover-bg: #F8FAFC;
        --subtle-badge-bg: #F1F5F9;
    }

    [data-bs-theme="dark"] {
        --panel-bg: #0F1B2D;
        --panel-border: #1E293B;
        --panel-header-bg: #06152B;
        --panel-header-text: #F1F5F9;
        --input-bg: #162842;
        --input-border: #334155;
        --input-text: #F8FAFC;
        --text-primary: #F8FAFC;
        --text-muted: #94A3B8;
        --card-bg: #0F1B2D;
        --box-subtle-bg: #162842;
        --table-hover-bg: #162842;
        --subtle-badge-bg: #162842;
    }

    .overview-card {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .overview-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 16px 24px;
        border-bottom: 2px solid var(--color-gold);
    }

    .checklist-card {
        background: var(--box-subtle-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
    }

    .checklist-item {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
        padding: 14px;
        height: 100%;
    }

    .table-custom {
        color: var(--text-primary);
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--subtle-badge-bg);
        border-bottom: 1px solid var(--panel-border);
    }

    .table-custom thead th {
        color: var(--text-muted);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 16px;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid var(--panel-border);
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .text-theme-primary {
        color: var(--text-primary) !important;
    }

    .text-theme-muted {
        color: var(--text-muted) !important;
    }

    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 50px;
        padding: 8px 18px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    
    <!-- Top Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('batches.index') }}" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0 text-theme-primary">Batch {{ $batch->batch_number ?? $batch->batch_code ?? $batch->batch_name }}</h4>
                <small class="text-theme-muted">Course: <strong class="text-primary">{{ $batch->course->title ?? $batch->course->course_name ?? 'N/A' }}</strong></small>
            </div>
        </div>
        <a href="{{ route('batches.index') }}" class="btn btn-gold-action shadow-sm">
            <i class="fa-solid fa-list me-1"></i> Back to Batches
        </a>
    </div>

    <!-- 5 Criteria Compliance Indicator Section -->
    <div class="card checklist-card border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-theme-primary mb-3"><i class="fa-solid fa-list-check text-warning me-2"></i> Batch Launch Readiness Checklist (5 Mandates)</h6>
            <div class="row g-3">
                <div class="col-md">
                    <div class="checklist-item shadow-sm">
                        <small class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-circle-check me-1"></i> 1. Approvals</small>
                        <span class="small text-theme-muted d-block">HEC / NOC Approved & Seat Plan Defined</span>
                    </div>
                </div>
                <div class="col-md">
                    <div class="checklist-item shadow-sm">
                        <small class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-circle-check me-1"></i> 2. Admissions</small>
                        <span class="small text-theme-muted d-block">Entry Test, Merit List & Fee Verified</span>
                    </div>
                </div>
                <div class="col-md">
                    <div class="checklist-item shadow-sm">
                        <small class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-circle-check me-1"></i> 3. Academic Setup</small>
                        <span class="small text-theme-muted d-block">Faculty, Lab & Syllabus Allocated</span>
                    </div>
                </div>
                <div class="col-md">
                    <div class="checklist-item shadow-sm">
                        <small class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-circle-check me-1"></i> 4. Student Support</small>
                        <span class="small text-theme-muted d-block">Orientation, LMS & ID Card Ready</span>
                    </div>
                </div>
                <div class="col-md">
                    <div class="checklist-item shadow-sm">
                        <small class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-circle-check me-1"></i> 5. Resources</small>
                        <span class="small text-theme-muted d-block">Faculty Budget & Library Books Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Batch Info Card -->
        <div class="col-lg-4">
            <div class="card overview-card border-0 mb-4">
                <div class="card-header overview-header">
                    <h6 class="fw-bold mb-0 text-warning"><i class="fa-solid fa-circle-info me-2"></i> Batch Summary Details</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-theme-muted d-block fw-bold text-uppercase fs-8">Course Title</small>
                        <span class="fw-bold fs-6 text-primary">{{ $batch->course->title ?? $batch->course->course_name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-theme-muted d-block fw-bold text-uppercase fs-8">Start Date</small>
                        <span class="fw-semibold text-theme-primary">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M, Y') }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-theme-muted d-block fw-bold text-uppercase fs-8">Estimated End Date</small>
                        <span class="fw-semibold text-theme-primary">{{ \Carbon\Carbon::parse($batch->end_date)->format('d M, Y') }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-theme-muted d-block fw-bold text-uppercase fs-8">Class Timing & Lab</small>
                        <span class="fw-semibold text-theme-primary">{{ $batch->class_timing ?? $batch->timing ?? 'Not Assigned' }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-theme-muted d-block fw-bold text-uppercase fs-8">Batch Capacity Limit</small>
                        <span class="fw-bold text-theme-primary fs-5">{{ $batch->capacity ?? 30 }} Students</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Students Table -->
        <div class="col-lg-8">
            <div class="card overview-card border-0">
                <div class="card-header overview-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-white fs-6"><i class="fa-solid fa-user-graduate me-2 text-warning"></i> Enrolled Students</span>
                    <span class="badge bg-warning text-dark font-monospace fw-bold fs-6">{{ count($batch->admissions ?? []) }} / {{ $batch->capacity ?? 30 }} Enrolled</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="ps-4">Reg No</th>
                                    <th>Student Name</th>
                                    <th>Contact</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batch->admissions ?? [] as $admission)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-dark text-warning border border-warning-subtle font-monospace fs-6 px-2 py-1 rounded-3">
                                            {{ $admission->registration_no }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-theme-primary">{{ $admission->student_name }}</td>
                                    <td class="text-theme-muted"><i class="fa-solid fa-phone text-success me-1"></i> {{ $admission->mobile_number }}</td>
                                    <td class="pe-4 text-end">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold px-3 py-1 rounded-pill">{{ $admission->status }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-theme-muted">
                                        <i class="fa-solid fa-user-slash fs-2 d-block mb-2 text-warning opacity-50"></i>
                                        No students enrolled in this batch yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection