@extends('layouts.app')

@section('page_title', 'Collect Fee Payment')

@push('styles')
<style>
    .fee-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }
    .fee-header {
        background: linear-gradient(135deg, #0b2545 0%, #13315c 100%);
        color: #ffffff;
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.25rem 1.75rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-exclamation fs-5 me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card fee-card border-0 mb-4">
                <div class="card-header fee-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-cash-register me-2 text-warning"></i> Receive Fee — {{ $admission->student_name }}</h5>
                    <span class="badge bg-warning text-dark font-monospace px-3 py-2 fs-6 align-self-start align-self-md-auto">REG: {{ $admission->registration_no }}</span>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Financial Summary Metrics -->
                    <div class="row g-3 bg-light p-4 rounded-4 border mb-4 text-center">
                        <div class="col-md-4 border-end-md">
                            <span class="d-block text-uppercase text-muted fw-bold fs-7 mb-1">Net Agreed Fee</span>
                            <h3 class="fw-bold text-dark mb-0">Rs. {{ number_format($admission->total_agreed_fee - ($admission->discount_amount ?? 0)) }}</h3>
                        </div>
                        <div class="col-md-4 border-end-md">
                            <span class="d-block text-uppercase text-muted fw-bold fs-7 mb-1">Total Paid Till Date</span>
                            <h3 class="fw-bold text-success mb-0">Rs. {{ number_format($admission->paid_fee) }}</h3>
                        </div>
                        <div class="col-md-4">
                            <span class="d-block text-uppercase text-muted fw-bold fs-7 mb-1">Remaining Balance</span>
                            <h3 class="fw-bold text-danger mb-0">Rs. {{ number_format($admission->due_fee) }}</h3>
                        </div>
                    </div>

                    <form action="{{ route('fees.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="admission_id" value="{{ $admission->id }}">

                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Payment Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-calendar"></i></span>
                                    <input type="date" name="payment_date" class="form-control shadow-none" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Amount Receiving (PKR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success fw-bold">Rs</span>
                                    <input type="number" name="amount_paid" class="form-control fs-5 text-success fw-bold shadow-none" max="{{ max(1, $admission->due_fee) }}" placeholder="Max: {{ $admission->due_fee }}" required min="1">
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Payment Method <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-wallet"></i></span>
                                    <select name="payment_method" class="form-select shadow-none" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Stripe">Stripe (Real Credit / Debit Card Gateway)</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Easypaisa/Jazzcash">Easypaisa / Jazzcash</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Trx / Ref No (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-hashtag"></i></span>
                                    <input type="text" name="transaction_reference" class="form-control shadow-none" placeholder="e.g. TRX-982183">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Remarks / Installment Details</label>
                            <textarea name="remarks" class="form-control shadow-none" rows="2" placeholder="e.g. 1st Installment for Fall Term"></textarea>
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-3 pt-3 border-top">
                            <a href="{{ route('fees.index') }}" class="btn btn-light border px-4 py-2 fw-bold text-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 py-2 text-dark shadow-sm">
                                <i class="fa-solid fa-credit-card me-2"></i> Proceed Payment & Print Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection