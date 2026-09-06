@extends('layouts.app')

@section('page_title', 'Allot Custom Fee Structure')

@section('content')
<div class="container py-3">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-dark text-white p-3">
            <h5 class="mb-0 text-white"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i> Fee Structure Allotment</h5>
        </div>
        <div class="card-body p-4">
            
            <!-- 1. Student Info Summary Card -->
            <div class="bg-light p-3 rounded-3 border mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block">STUDENT NAME</small>
                        <span class="fs-6 fw-bold text-dark">{{ $admission->student_name }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block">REG / ROLL NO</small>
                        <span class="badge bg-dark font-monospace">{{ $admission->registration_no }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block">COURSE / CLASS</small>
                        <span class="fw-semibold text-dark">{{ $admission->course->course_name ?? $admission->course->title ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block">GUARDIAN & CONTACT</small>
                        <span class="text-dark">{{ $admission->father_name }} ({{ $admission->mobile_number ?? $admission->mobile_contact ?? 'N/A' }})</span>
                    </div>
                </div>
            </div>

            @if($feeHeads->isEmpty())
                <div class="alert alert-warning border-warning rounded-3 mb-4">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    <strong>No Fee Heads Found!</strong> Please create fee heads first (e.g. Tuition Fee, Admission Fee) in the Fee Settings before creating allocations.
                </div>
            @endif

            <form action="{{ route('fees.allot.store') }}" method="POST" id="feeAllotForm">
                @csrf
                <input type="hidden" name="admission_id" value="{{ $admission->id }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Academic Session / Year</label>
                        <select name="academic_session" class="form-select shadow-sm" required>
                            @forelse($sessions ?? [] as $session)
                                <option value="{{ $session->title }}">{{ $session->title }}</option>
                            @empty
                                <option value="2026-2027" selected>2026-2027</option>
                                <option value="2025-2026">2025-2026</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Default Installment Due Date</label>
                        <input type="date" name="default_due_date" class="form-control shadow-sm" value="{{ date('Y-m-10', strtotime('+1 month')) }}" required>
                    </div>
                </div>

                <!-- 2. Fee Heads Breakdown -->
                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-list-check me-1 text-warning"></i> Custom Fee Heads & Amounts</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle" id="feeHeadsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Fee Head</th>
                                <th>Frequency</th>
                                <th>Amount (PKR)</th>
                                <th>Due Date</th>
                                <th class="text-center" style="width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="feeHeadRows">
                            <tr>
                                <td>
                                    <select name="fee_heads[0][head_id]" class="form-select" required {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                                        <option value="">-- Select Fee Head --</option>
                                        @foreach($feeHeads as $head)
                                            <option value="{{ $head->id }}">{{ $head->name ?? $head->head_name }} ({{ $head->type ?? 'General' }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="fee_heads[0][frequency]" class="form-select">
                                        @forelse($frequencies ?? [] as $freq)
                                            <option value="{{ $freq->title }}">{{ $freq->title }}</option>
                                        @empty
                                            <option value="Monthly">Monthly</option>
                                            <option value="One-Time">One-Time</option>
                                            <option value="Quarterly">Quarterly</option>
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="fee_heads[0][amount]" class="form-control head-amount" placeholder="0.00" oninput="calculateGrandTotal()" required>
                                </td>
                                <td>
                                    <input type="date" name="fee_heads[0][due_date]" class="form-control" value="{{ date('Y-m-10', strtotime('+1 month')) }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-outline-dark fw-bold" id="addHeadBtn" {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa-solid fa-plus me-1 text-primary"></i> Add Custom Fee Head
                    </button>
                </div>

                <!-- 3. Scholarship & Concessions -->
                <div class="row bg-light p-3 rounded-3 border mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Discount / Concession Amount (PKR)</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control" value="0" oninput="calculateGrandTotal()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Concession Reason / Scholarship</label>
                        <select name="discount_reason" class="form-select">
                            <option value="">-- Choose Reason / Scholarship --</option>
                            @forelse($scholarshipReasons ?? [] as $reason)
                                <option value="{{ $reason->title }}">{{ $reason->title }}</option>
                            @empty
                                <option value="Kinship Scholarship">Kinship Scholarship</option>
                                <option value="Merit Scholarship">Merit Scholarship</option>
                                <option value="Need-Based Concession">Need-Based Concession</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Approved By</label>
                        <input type="text" name="discount_approved_by" class="form-control" value="{{ Auth::user()->name ?? 'Principal' }}">
                    </div>
                </div>

                <!-- 4. Grand Total Summary -->
                <div class="card bg-warning text-dark border-0 mb-4 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 fw-bold">TOTAL AGREED NET ALLOTMENT:</h6>
                            <small class="text-dark">Net payable after applying dynamic fee heads and discounts</small>
                        </div>
                        <h3 class="fw-bold mb-0" id="grandTotalDisplay">PKR 0.00</h3>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('fees.index') }}" class="btn btn-light border px-4 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2" {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa-solid fa-check-circle me-1"></i> Confirm & Save Allotment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let rowIndex = 1;

document.getElementById('addHeadBtn').addEventListener('click', function() {
    let tbody = document.getElementById('feeHeadRows');
    let row = document.createElement('tr');
    
    row.innerHTML = `
        <td>
            <select name="fee_heads[${rowIndex}][head_id]" class="form-select" required>
                <option value="">-- Select Fee Head --</option>
                @foreach($feeHeads as $head)
                    <option value="{{ $head->id }}">{{ $head->name ?? $head->head_name }} ({{ $head->type ?? 'General' }})</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="fee_heads[${rowIndex}][frequency]" class="form-select">
                @forelse($frequencies ?? [] as $freq)
                    <option value="{{ $freq->title }}">{{ $freq->title }}</option>
                @empty
                    <option value="Monthly">Monthly</option>
                    <option value="One-Time">One-Time</option>
                    <option value="Quarterly">Quarterly</option>
                @endforelse
            </select>
        </td>
        <td>
            <input type="number" name="fee_heads[${rowIndex}][amount]" class="form-control head-amount" placeholder="0.00" oninput="calculateGrandTotal()" required>
        </td>
        <td>
            <input type="date" name="fee_heads[${rowIndex}][due_date]" class="form-control" value="{{ date('Y-m-10', strtotime('+1 month')) }}">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></button>
        </td>
    `;
    tbody.appendChild(row);
    rowIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        let rows = document.querySelectorAll('#feeHeadRows tr');
        if(rows.length > 1) {
            e.target.closest('tr').remove();
            calculateGrandTotal();
        }
    }
});

function calculateGrandTotal() {
    let amounts = document.querySelectorAll('.head-amount');
    let total = 0;
    amounts.forEach(input => {
        let val = parseFloat(input.value) || 0;
        total += val;
    });
    
    let discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let grandTotal = Math.max(0, total - discount);
    
    document.getElementById('grandTotalDisplay').innerText = 'PKR ' + grandTotal.toLocaleString('en-PK', {minimumFractionDigits: 2});
}
</script>
@endsection