{{-- File Path: resources/views/student/partials/fee-details.blade.php --}}
@php
    $fSummary = $feeSummary ?? [
        'is_allocated' => false,
        'total_agreed' => 0,
        'discount'     => 0,
        'paid_amount'  => 0,
        'due_amount'   => 0,
        'discount_reason' => ''
    ];
    $items       = $feeItems ?? collect();
    $collections = $feeCollections ?? collect();
@endphp

<style>
    .fee-card-header {
        border-bottom: 2px solid var(--panel-border, #f1f5f9);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .fee-stat-card-modern {
        background: var(--box-bg, #ffffff);
        border: 1px solid var(--panel-border, #e2e8f0);
        border-radius: 14px;
        padding: 16px;
        transition: all 0.3s ease;
    }

    .fee-stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .fee-stat-label-title {
        font-size: 0.68rem;
        font-weight: 800;
        color: var(--text-muted, #64748b);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }

    .fee-stat-value-heading {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--text-main, #0a2540);
        margin-top: 4px;
        margin-bottom: 0;
    }

    .table-acad-fee {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-acad-fee thead th {
        background-color: var(--navy-primary, #0a2540);
        color: #ffffff;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border: none;
    }

    .table-acad-fee tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--panel-border, #f1f5f9);
        font-size: 0.85rem;
    }

    .btn-gold-pay {
        background: linear-gradient(135deg, var(--color-gold, #c8a251) 0%, #b38e3e 100%);
        color: #ffffff;
        font-weight: 800;
        border: none;
        border-radius: 10px;
        transition: all 0.25s ease;
    }

    .btn-gold-pay:hover {
        background: linear-gradient(135deg, #b38e3e 0%, #9a782e 100%);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(200, 162, 81, 0.35);
    }

    .modal-navy-header {
        background: linear-gradient(135deg, #09223d 0%, #041324 100%);
        color: #ffffff;
    }
</style>

<div class="react-card mb-4">
    <!-- Header Title & Status Badge -->
    <div class="fee-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h5 class="section-title-badge text-theme-primary mb-1">
                <i class="fa-solid fa-file-invoice-dollar text-warning me-2"></i>FEE & PAYMENT LEDGER
            </h5>
            <small class="text-theme-muted">Track your allotted fee structure, scholarships, due balances, and payment receipts.</small>
        </div>
        <div>
            @if(!($fSummary['is_allocated'] ?? false))
                <span class="badge bg-body-tertiary text-secondary border border-secondary px-3 py-2 rounded-pill fw-bold fs-8">
                    <i class="fa-solid fa-clock me-1"></i> Fee Allotment Pending
                </span>
            @elseif(($fSummary['due_amount'] ?? 0) > 0)
                <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill fw-bold fs-8">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Balance Due: Rs. {{ number_format($fSummary['due_amount']) }}
                </span>
            @else
                <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill fw-bold fs-8">
                    <i class="fa-solid fa-circle-check me-1"></i> All Fees Cleared
                </span>
            @endif
        </div>
    </div>

    <!-- Quick Stats Metric Boxes -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="fee-stat-card-modern">
                <span class="fee-stat-label-title">Total Agreed Fee</span>
                <h5 class="fee-stat-value-heading">Rs. {{ number_format($fSummary['total_agreed'] ?? 0) }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="fee-stat-card-modern">
                <span class="fee-stat-label-title">Discount Concession</span>
                <h5 class="fee-stat-value-heading text-primary">Rs. {{ number_format($fSummary['discount'] ?? 0) }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="fee-stat-card-modern">
                <span class="fee-stat-label-title">Total Paid</span>
                <h5 class="fee-stat-value-heading text-success">Rs. {{ number_format($fSummary['paid_amount'] ?? 0) }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="fee-stat-card-modern">
                <span class="fee-stat-label-title">Remaining Due</span>
                <h5 class="fee-stat-value-heading text-danger">Rs. {{ number_format($fSummary['due_amount'] ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <!-- Discount Reason Banner -->
    @if(($fSummary['discount'] ?? 0) > 0 && !empty($fSummary['discount_reason']))
        <div class="alert alert-light border rounded-3 p-3 mb-4 d-flex align-items-center gap-2" style="background: #fbf7ee; border-color: #fef08a !important;">
            <i class="fa-solid fa-award fs-5 text-warning"></i>
            <div class="small text-dark">
                <strong>Concession / Scholarship Applied:</strong> {{ $fSummary['discount_reason'] }}
            </div>
        </div>
    @endif

    <!-- Allotted Fee Breakdown -->
    @if(($fSummary['is_allocated'] ?? false) && count($items) > 0)
        <h6 class="fw-bold text-theme-primary mb-3 fs-7 text-uppercase letter-spacing-1">
            <i class="fa-solid fa-list-check me-2 text-warning"></i> Allotted Fee Breakdown
        </h6>
        <div class="table-responsive rounded-3 overflow-hidden mb-4 border border-theme">
            <table class="table table-acad-fee align-middle mb-0">
                <thead>
                    <tr>
                        <th>Fee Head</th>
                        <th>Frequency</th>
                        <th>Due Date</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="fw-bold text-theme-primary">
                                {{ $item->head->name ?? $item->head->head_name ?? $item->feeHead->name ?? $item->feeHead->head_name ?? 'General Fee Head' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-body-tertiary text-theme-primary border border-theme fs-8">{{ $item->frequency ?? 'Monthly' }}</span>
                        </td>
                        <td>
                            <span class="text-theme-muted small">
                                {{ $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format('d M, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="text-end fw-bold text-theme-primary">
                            Rs. {{ number_format($item->amount ?? 0) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-light border rounded-3 p-3 text-theme-muted mb-4 small">
            <i class="fa-solid fa-circle-info text-primary me-2"></i> Custom fee heads are not allotted yet by administration. Official payable structure will appear here once configured.
        </div>
    @endif

    <!-- Payment Receipts Header & Action -->
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h6 class="fw-bold text-theme-primary mb-0 fs-7 text-uppercase letter-spacing-1">
            <i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i> Payment History & Receipts
        </h6>
        
        @if(($fSummary['due_amount'] ?? 0) > 0)
            <button class="btn btn-sm btn-gold-pay px-3 py-2 shadow-sm fs-8" data-bs-toggle="modal" data-bs-target="#studentPayModal">
                <i class="fa-solid fa-credit-card me-1"></i> PAY FEE NOW
            </button>
        @endif
    </div>

    <!-- Payment Receipts Table -->
    <div class="table-responsive rounded-3 overflow-hidden border border-theme">
        <table class="table table-acad-fee align-middle mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Transaction Ref / Remarks</th>
                    <th class="text-end">Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collections as $collection)
                <tr>
                    <td class="text-theme-primary fw-bold">
                        {{ \Carbon\Carbon::parse($collection->payment_date ?? $collection->created_at)->format('d M, Y') }}
                    </td>
                    <td>
                        <span class="badge bg-body-tertiary text-theme-primary border border-theme px-2 py-1 fs-8">
                            {{ $collection->payment_method ?? 'Online' }}
                        </span>
                    </td>
                    <td class="text-theme-muted small">
                        {{ $collection->remarks ?? $collection->transaction_id ?? 'N/A' }}
                    </td>
                    <td class="text-end fw-bold text-success fs-6">
                        Rs. {{ number_format($collection->amount_paid ?? $collection->amount ?? 0) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-theme-muted small">
                        No payment transactions recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Student Pay Fee Modal -->
@if(($fSummary['due_amount'] ?? 0) > 0)
<div class="modal fade" id="studentPayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('student.fees.pay') }}" method="POST">
                @csrf
                <div class="modal-header modal-navy-header">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fa-solid fa-wallet text-warning me-2"></i> Pay Remaining Fee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label-custom">Total Due Balance</label>
                        <input type="text" class="form-control form-control-acad fw-bold text-danger bg-light" value="Rs. {{ number_format($fSummary['due_amount']) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Paying Amount (PKR) <span class="text-danger">*</span></label>
                        <input type="number" name="amount_paid" class="form-control form-control-acad" value="{{ $fSummary['due_amount'] }}" max="{{ $fSummary['due_amount'] }}" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select form-select-acad" required>
                            <option value="Online / Card (Stripe)">Online Credit/Debit Card (Stripe)</option>
                            <option value="Easypaisa/Jazzcash">EasyPaisa / JazzCash Mobile Account</option>
                            <option value="Bank Deposit">Bank Transfer / Deposit Slip</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Transaction ID / Reference No</label>
                        <input type="text" name="remarks" class="form-control form-control-acad" placeholder="e.g. TID-98234112 / Bank Reference">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold-pay btn-sm px-4 py-2">Confirm & Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif