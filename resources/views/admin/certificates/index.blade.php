@extends('layouts.app')

@section('page_title', 'Course Completion Certificates')

@push('styles')
<style>
    :root {
        --admin-navy: #0b2545;
        --admin-gold: #d4af37;
    }

    .cert-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }

    .cert-header {
        background: linear-gradient(135deg, var(--admin-navy) 0%, #13315c 100%);
        color: #ffffff;
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.25rem 1.75rem;
    }

    .btn-gold-action {
        background-color: var(--admin-gold);
        color: #0b2545;
        font-weight: 700;
        border-radius: 0.75rem;
        border: none;
        padding: 0.75rem;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.35);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        
        <!-- Issue Certificate Form -->
        <div class="col-lg-4">
            <div class="cert-card border-0 h-100">
                <div class="cert-header">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fa-solid fa-award text-warning me-2"></i> Issue New Certificate</h5>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <form method="POST" action="{{ route('certificates.store') }}" class="w-100">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Select Student <span class="text-danger">*</span></label>
                            <select name="admission_id" class="form-select shadow-none" required>
                                <option value="">-- Choose Student --</option>
                                @foreach($admissions as $st)
                                    <option value="{{ $st->id }}">{{ $st->student_name }} ({{ $st->registration_no }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Grade / Evaluation <span class="text-danger">*</span></label>
                            <select name="grade" class="form-select shadow-none" required>
                                <option value="A+ (Excellent)">A+ (Excellent)</option>
                                <option value="A (Very Good)">A (Very Good)</option>
                                <option value="B (Good)">B (Good)</option>
                                <option value="Satisfactory">Satisfactory</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small">Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date" class="form-control shadow-none" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <button type="submit" class="btn btn-gold-action w-100 shadow-sm">
                            <i class="fa-solid fa-certificate me-1"></i> Generate Certificate
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Certificate Directory Table -->
        <div class="col-lg-8">
            <div class="cert-card border-0 overflow-hidden h-100">
                <div class="cert-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i> Issued Certificates History</h5>
                    <span class="badge bg-warning text-dark fw-bold font-monospace px-3 py-2">{{ count($certificates) }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase fs-8 text-secondary">
                                <tr>
                                    <th class="ps-4 py-3">Certificate No</th>
                                    <th class="py-3">Student Name</th>
                                    <th class="py-3">Course</th>
                                    <th class="text-center py-3">Grade</th>
                                    <th class="text-end pe-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $cert)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="badge bg-dark font-monospace px-2 py-1">#{{ $cert->certificate_no }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $cert->admission->student_name }}</td>
                                    <td class="small text-secondary">{{ $cert->admission->course->course_name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-bold">{{ $cert->grade }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('certificates.show', $cert->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-2 px-3 fw-bold shadow-none">
                                            <i class="fa-solid fa-print me-1"></i> Print
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-3 mb-2 d-block opacity-50"></i>
                                        No certificates issued yet.
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