@extends('layouts.app')

@section('page_title', 'All Batches Directory')

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
        --table-hover-bg: #162842;
        --subtle-badge-bg: #162842;
    }

    .batch-card {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .batch-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 18px 24px;
        border-bottom: 2px solid var(--color-gold);
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

    .subtle-badge {
        background-color: var(--subtle-badge-bg);
        color: var(--text-primary);
        border: 1px solid var(--panel-border);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="card batch-card border-0 mb-4">
        <div class="card-header batch-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width:42px; height:42px;">
                    <i class="fa-solid fa-layer-group fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white">Academic Batches Directory</h5>
                    <small class="text-light opacity-75">Manage active programs, allocations & compliance status</small>
                </div>
            </div>
            <a href="{{ route('batches.create') }}" class="btn btn-gold-action shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Create New Batch
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr class="text-uppercase">
                            <th class="ps-4">Batch Code</th>
                            <th>Course & Department</th>
                            <th>Duration / Dates</th>
                            <th>Timing & Lab</th>
                            <th>Readiness Status</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batches as $batch)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-dark text-warning border border-warning-subtle font-monospace px-3 py-2 fs-6 rounded-3">
                                    {{ $batch->batch_number ?? $batch->batch_code ?? 'LC-00' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-theme-primary fs-6">{{ $batch->course->title ?? $batch->course->course_name ?? 'N/A' }}</div>
                                <small class="text-theme-muted"><i class="fa-solid fa-book-bookmark me-1 text-primary"></i> Code: {{ $batch->course->code ?? $batch->course->course_code ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="small fw-bold text-theme-primary">
                                    <i class="fa-regular fa-calendar me-1 text-primary"></i> {{ \Carbon\Carbon::parse($batch->start_date)->format('d M, Y') }}
                                </div>
                                <small class="text-theme-muted d-block">To: {{ \Carbon\Carbon::parse($batch->end_date)->format('d M, Y') }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-theme-primary d-block"><i class="fa-regular fa-clock me-1 text-warning"></i> {{ $batch->class_timing ?? $batch->timing ?? '10:00 AM - 12:00 PM' }}</span>
                                <small class="badge subtle-badge border mt-1"><i class="fa-solid fa-vial-circle-check me-1 text-success"></i> Lab Allocated</small>
                            </td>
                            <td>
                                <div class="d-flex gap-1" title="Academic Setup & Accreditation Status">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="fa-solid fa-shield-check me-1"></i> Admin</span>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle"><i class="fa-solid fa-list-check me-1"></i> Merit</span>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><i class="fa-solid fa-chalkboard-user me-1"></i> Faculty</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = strtolower($batch->calculated_status ?? $batch->status ?? 'active');
                                @endphp
                                @if($status == 'active')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-circle-play me-1"></i> Active</span>
                                @elseif($status == 'upcoming')
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-clock-rotate-left me-1"></i> Upcoming</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold">Completed</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('batches.show', $batch->id) }}" class="btn btn-outline-primary btn-sm fw-bold px-3 py-1 rounded-pill" title="View Batch Overview & Student Enrollments">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-theme-muted">
                                <i class="fa-solid fa-layer-group fs-2 d-block mb-2 text-warning opacity-50"></i>
                                No active or upcoming batches created yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection