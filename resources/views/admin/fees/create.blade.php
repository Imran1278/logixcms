@extends('layouts.app')

@section('page_title', 'Collect Fee Payment')

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
</style>
@endpush

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card fee-card border-0 mb-4">
                <div class="card-header fee-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-cash-register me-2 text-warning"></i> Receive Fee — {{ $admission->student_name }}</h5>
                    <span class="badge bg-warning text-dark font-monospace px-3 py-2">REG: {{ $admission->registration_no }}</span>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row g-3 bg-light p-3 rounded-3 border mb-4 text-center">
                        <div class="col-md-4 border-end">
                            <small class="text-uppercase text-muted fw-bold fs-8">Net Agreed Fee</small>
                            <h4 class="fw-bold text-dark mb-0 mt-1">Rs. {{ number_format($admission->total_agreed_fee - ($admission->discount_amount ?? 0)) }}</h4>
                        </div>
                        <div class="col-md-4 border-end">
                            <small class="text-uppercase text-muted fw-bold fs-8">Total Paid Till Date</small>
                            <h4 class="fw-bold text-success mb-0 mt-1">Rs. {{ number_format($admission->paid_fee) }}</h4>
                        </div>
                        <div class="col-md-4">
                            <small class="text-uppercase text-muted fw-bold fs-8">Remaining Balance</small>
                            <h4 class="fw-bold text-danger mb-0 mt-1">Rs. {{ number_format($admission->due_fee) }}</h4>
                        </div>
                    </div>

                    <form action="{{ route('fees.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="admission_id" value="{{ $admission->id }}">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Amount Receiving (PKR) <span class="text-danger">*</span></label>
                                <input type="number" name="amount_paid" class="form-control fs-5 text-success fw-bold shadow-sm" max="{{ max(1, $admission->due_fee) }}" placeholder="Max Outstanding: {{ $admission->due_fee }}" required min="1">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select shadow-sm" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Stripe">Stripe (Real Credit / Debit Card Gateway)</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Easypaisa/Jazzcash">Easypaisa / Jazzcash</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Trx / Ref No (Optional)</label>
                                <input type="text" name="transaction_reference" class="form-control shadow-sm" placeholder="e.g. TRX-982183">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Remarks / Installment Details</label>
                            <input type="text" name="remarks" class="form-control shadow-sm" placeholder="e.g. 1st Installment for Fall Term">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('fees.index') }}" class="btn btn-light border px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 py-2 text-dark shadow-sm">
                                <i class="fa-solid fa-credit-card me-1"></i> Proceed Payment & Print Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection