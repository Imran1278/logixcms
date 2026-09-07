<!-- resources/views/admin/fees/defaulters.blade.php -->
@extends('layouts.app')

@section('page_title', 'Fee Defaulters Directory')

@push('styles')
<style>
    :root {
        --logix-navy: #0B2545;
        --logix-gold: #D4AF37;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-3 rounded-4 shadow-sm border">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--logix-navy);">
                <i class="fa-solid fa-users-slash me-2 text-warning"></i> Fee Defaulters Directory
            </h4>
            <p class="text-muted small mb-0">List of students with outstanding dues and unpaid fee balances.</p>
        </div>
        <div>
            <a href="{{ route('fees.index') }}" class="btn btn-outline-dark fw-bold rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to All Fees
            </a>
        </div>
    </div>

    <!-- Defaulters Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header text-white p-3 d-flex justify-content-between align-items-center" style="background-color: var(--logix-navy);">
            <span class="fw-bold fs-6"><i class="fa-solid fa-list me-2 text-warning"></i> Active Fee Defaulters</span>
            <span class="badge bg-warning text-dark fw-bold fs-7">{{ count($defaulters ?? []) }} Defaulters Found</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase fs-8 text-secondary">
                            <th class="ps-3">Reg No</th>
                            <th>Student Name</th>
                            <th>Course & Batch</th>
                            <th>Contact / Mobile</th>
                            <th>Net Payable</th>
                            <th>Amount Paid</th>
                            <th>Outstanding Due</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $waService = new \App\Services\WhatsAppService(); @endphp
                        @forelse($defaulters as $defaulter)
                        @php
                            $msg = "Dear {$defaulter->admission->student_name},\n"
                                 . "This is a reminder regarding your outstanding fee balance of PKR " . number_format($defaulter->due_amount) . " for Session {$defaulter->academic_session}.\n"
                                 . "Please clear your dues as soon as possible.\n"
                                 . "Thank you - LOGIX CMS Management";
                            
                            $waUrl = $waService->getWhatsAppLink($defaulter->admission->mobile_number ?? $defaulter->admission->whatsapp_number ?? '', $msg);
                        @endphp
                        <tr>
                            <td class="ps-3">
                                <span class="badge bg-dark font-monospace">{{ $defaulter->admission->registration_no ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $defaulter->admission->student_name ?? 'N/A' }}</div>
                                <small class="text-muted"><i class="fa-solid fa-user me-1"></i>{{ $defaulter->admission->father_name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $defaulter->admission->course->course_name ?? 'N/A' }}</div>
                                <small class="text-muted">Session: {{ $defaulter->academic_session }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><i class="fa-solid fa-phone me-1 text-warning"></i>{{ $defaulter->admission->mobile_number ?? $defaulter->admission->mobile_contact ?? 'N/A' }}</div>
                            </td>
                            <td class="fw-bold text-dark">Rs. {{ number_format($defaulter->net_payable) }}</td>
                            <td class="text-success fw-bold">Rs. {{ number_format($defaulter->paid_amount) }}</td>
                            <td>
                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1 fs-7 fw-bold">
                                    Rs. {{ number_format($defaulter->due_amount) }}
                                </span>
                            </td>
                            <td class="text-center pe-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-success btn-sm fw-bold shadow-sm">
                                        <i class="fa-brands fa-whatsapp me-1"></i> Alert
                                    </a>
                                    <a href="{{ route('fees.create', $defaulter->admission_id) }}" class="btn btn-sm fw-bold shadow-sm" style="background-color: var(--logix-navy); color: var(--logix-gold);">
                                        <i class="fa-solid fa-cash-register me-1"></i> Collect
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-circle-check fs-2 text-warning d-block mb-2"></i>
                                Great! There are no active fee defaulters at this moment.
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