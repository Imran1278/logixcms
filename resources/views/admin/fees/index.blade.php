@extends('layouts.app')

@section('page_title', 'Fee Directory & Collections')

@push('styles')
<style>
    .fee-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .fee-header {
        background: #0b2545;
        color: #ffffff;
        border-radius: 16px 16px 0 0 !important;
        padding: 18px 24px;
    }
    .btn-gold-action {
        background-color: #d4af37;
        color: #0b2545;
        font-weight: 700;
        border-radius: 8px;
        padding: 6px 14px;
        border: none;
        transition: all 0.25s ease;
    }
    .btn-gold-action:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <!-- Top Action Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-3 rounded-4 shadow-sm border flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-dark mb-0">Fee Directory & Ledger Operations</h4>
            <p class="text-muted small mb-0">Manage student vouchers, assign custom fee structures, and collect online/cash payments.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Manage Fee Heads Button -->
            <a href="{{ route('fees.heads.index') }}" class="btn btn-outline-dark fw-bold rounded-3 shadow-sm">
                <i class="fa-solid fa-gear text-primary me-1"></i> Manage Fee Heads
            </a>
            <a href="{{ route('fees.settings.index') }}" class="btn btn-outline-secondary fw-bold rounded-3 shadow-sm">
                <i class="fa-solid fa-sliders text-warning me-1"></i> Fee Configurations
            </a>
            <a href="{{ route('fees.defaulters') }}" class="btn btn-outline-danger fw-bold rounded-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> Defaulters List
            </a>
            <button class="btn btn-dark fw-bold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#assignFeeModal">
                <i class="fa-solid fa-plus-circle text-warning me-1"></i> Quick Collect Fee
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-sm btn-success fw-bold ms-3 shadow-sm">
                    <i class="fa-brands fa-whatsapp me-1"></i> Send WhatsApp Receipt
                </a>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card fee-card border-0 mb-4">
        <div class="card-header fee-header d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i> Student Fee Directory</span>
            <span class="badge bg-warning text-dark fw-bold">
                {{ count($admissions ?? []) }} Active Ledger Records
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase fs-8 text-secondary">
                            <th class="ps-3" style="width: 120px;">Reg No</th>
                            <th>Student Name</th>
                            <th>Course & Batch</th>
                            <th>Net Agreed Fee</th>
                            <th>Total Paid</th>
                            <th>Remaining Balance</th>
                            <th class="text-center pe-3" style="width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions ?? [] as $admission)
                        @php 
                            $allocation = $admission->feeAllocations->first();
                            $isAllocated = !is_null($allocation);
                            
                            if($isAllocated) {
                                $netFee = $allocation->net_payable;
                                $paid = $allocation->paid_amount;
                                $due = $allocation->due_amount;
                            } else {
                                $netFee = ($admission->total_agreed_fee ?? 0) - ($admission->discount_amount ?? 0);
                                $paid = $admission->feeCollections ? $admission->feeCollections->sum('amount_paid') : 0;
                                $due = max(0, $netFee - $paid);
                            }
                        @endphp
                        <tr>
                            <td class="ps-3">
                                <span class="badge bg-dark font-monospace px-2 py-1">{{ $admission->registration_no ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $admission->student_name ?? 'N/A' }}</div>
                                <small class="text-muted"><i class="fa-solid fa-user me-1"></i>{{ $admission->father_name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $admission->course->course_code ?? $admission->course->course_name ?? 'N/A' }}</div>
                                <small class="text-muted">Batch: {{ $admission->batch->batch_number ?? $admission->batch->batch_code ?? 'N/A' }}</small>
                            </td>
                            <td class="fw-bold text-dark">
                                @if($isAllocated || $netFee > 0)
                                    Rs. {{ number_format($netFee) }}
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td class="text-success fw-bold">Rs. {{ number_format($paid) }}</td>
                            <td>
                                @if(!$isAllocated && $netFee == 0)
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fw-bold">
                                        <i class="fa-solid fa-clock me-1"></i>Pending Allotment
                                    </span>
                                @elseif($due > 0)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fw-bold">
                                        Rs. {{ number_format($due) }}
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-bold">
                                        <i class="fa-solid fa-check me-1"></i>Cleared
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('fees.allot.create', $admission->id) }}" class="btn btn-outline-primary btn-sm fw-bold" title="Custom Allot Fee Heads">
                                        <i class="fa-solid fa-sliders me-1"></i> Allot
                                    </a>
                                    
                                    @if($isAllocated && $due > 0)
                                        <a href="{{ route('fees.create', $admission->id) }}" class="btn btn-gold-action btn-sm">
                                            <i class="fa-solid fa-plus-circle me-1"></i> Collect
                                        </a>
                                    @elseif($isAllocated && $due == 0)
                                        <span class="badge bg-light text-muted border py-2 px-2 fw-bold"><i class="fa-solid fa-circle-check text-success me-1"></i> Paid</span>
                                    @else
                                        <button class="btn btn-light btn-sm text-muted border" disabled title="Allot fee first">Collect</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No student fee records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Assign / Add Fee Modal -->
<div class="modal fade" id="assignFeeModal" tabindex="-1" aria-labelledby="assignFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('fees.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold fs-6" id="assignFeeModalLabel">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i> Quick Collect Fee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Select Student Admission *</label>
                        <select name="admission_id" class="form-select" required>
                            <option value="">-- Choose Enrolled Student --</option>
                            @foreach($admissions ?? [] as $adm)
                                <option value="{{ $adm->id }}">{{ $adm->registration_no }} - {{ $adm->student_name }} ({{ $adm->course->course_code ?? 'Course' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Amount (Rs) *</label>
                            <input type="number" name="amount_paid" class="form-control" placeholder="e.g. 5000" required min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Payment Date *</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Payment Method *</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Easypaisa/Jazzcash">EasyPaisa / JazzCash</option>
                            <option value="Stripe">Stripe (Online Credit/Debit Card)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Transaction Ref / Remarks</label>
                        <input type="text" name="remarks" class="form-control" placeholder="e.g. Monthly Fee / Exam Fee">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark btn-sm px-4">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection