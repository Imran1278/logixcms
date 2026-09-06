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
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .cert-header {
        background: linear-gradient(135deg, var(--admin-navy) 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px 16px 0 0 !important;
        padding: 16px 20px;
    }

    .btn-gold-action {
        background-color: var(--admin-gold);
        color: #0b2545;
        font-weight: 700;
        border-radius: 10px;
        border: none;
        padding: 10px;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.35);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="row g-4">
        
        <!-- Issue Certificate Form -->
        <div class="col-lg-4">
            <div class="cert-card border-0">
                <div class="cert-header">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fa-solid fa-award text-warning me-2"></i> Issue New Certificate</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('certificates.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Select Student *</label>
                            <select name="admission_id" class="form-select shadow-sm" required>
                                <option value="">-- Choose Student --</option>
                                @foreach($admissions as $st)
                                    <option value="{{ $st->id }}">{{ $st->student_name }} ({{ $st->registration_no }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Grade / Evaluation *</label>
                            <select name="grade" class="form-select shadow-sm" required>
                                <option value="A+ (Excellent)">A+ (Excellent)</option>
                                <option value="A (Very Good)">A (Very Good)</option>
                                <option value="B (Good)">B (Good)</option>
                                <option value="Satisfactory">Satisfactory</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Issue Date *</label>
                            <input type="date" name="issue_date" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <button type="submit" class="btn btn-gold-action w-100">
                            <i class="fa-solid fa-certificate me-1"></i> Generate Certificate
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Certificate Directory Table -->
        <div class="col-lg-8">
            <div class="cert-card border-0">
                <div class="cert-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i> Issued Certificates History</h5>
                    <span class="badge bg-light text-dark fw-bold">{{ count($certificates) }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th class="ps-3">Certificate No</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $cert)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <span class="badge bg-dark font-monospace px-2 py-1">#{{ $cert->certificate_no }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $cert->admission->student_name }}</td>
                                    <td class="small text-secondary">{{ $cert->admission->course->course_name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-bold">{{ $cert->grade }}</span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <a href="{{ route('certificates.show', $cert->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-2 px-3 fw-bold">
                                            <i class="fa-solid fa-print me-1"></i> Print
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No certificates issued yet.</td>
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