@extends('layouts.app')

@section('page_title', 'Allot Custom Fee Structure')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-dark text-white p-4">
            <h5 class="mb-0 text-white"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i> Fee Structure Allotment</h5>
        </div>
        <div class="card-body p-4 p-md-5">
            
            <!-- 1. Student Info Summary Card -->
            <div class="bg-light p-4 rounded-4 border mb-4">
                <div class="row g-4">
                    <div class="col-md-3">
                        <span class="text-muted fw-bold d-block fs-8 text-uppercase mb-1">Student Name</span>
                        <span class="fs-6 fw-bold text-dark">{{ $admission->student_name }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted fw-bold d-block fs-8 text-uppercase mb-1">Reg / Roll No</span>
                        <span class="badge bg-dark font-monospace px-2 py-1">{{ $admission->registration_no }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted fw-bold d-block fs-8 text-uppercase mb-1">Course / Class</span>
                        <span class="fw-semibold text-dark">{{ $admission->course->course_name ?? $admission->course->title ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted fw-bold d-block fs-8 text-uppercase mb-1">Guardian & Contact</span>
                        <span class="text-dark">{{ $admission->father_name }} <span class="text-muted font-monospace small">({{ $admission->mobile_number ?? $admission->mobile_contact ?? 'N/A' }})</span></span>
                    </div>
                </div>
            </div>

            @if($feeHeads->isEmpty())
                <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-warning"></i>
                        <div>
                            <strong>No Fee Heads Found!</strong> Please create fee heads first (e.g., Tuition Fee, Admission Fee) under Fee Settings before configuring allocations.
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('fees.allot.store') }}" method="POST" id="feeAllotForm">
                @csrf
                <input type="hidden" name="admission_id" value="{{ $admission->id }}">

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Academic Session / Year <span class="text-danger">*</span></label>
                        <select name="academic_session" class="form-select shadow-none" required>
                            @forelse($sessions ?? [] as $session)
                                <option value="{{ $session->title }}">{{ $session->title }}</option>
                            @empty
                                <option value="2026-2027" selected>2026-2027</option>
                                <option value="2025-2026">2025-2026</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Default Installment Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="default_due_date" class="form-control shadow-none" value="{{ date('Y-m-10', strtotime('+1 month')) }}" required>
                    </div>
                </div>

                <!-- 2. Fee Heads Breakdown -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check me-2 text-warning"></i> Custom Fee Heads & Amounts</h6>
                </div>
                
                <div class="table-responsive border rounded-4 mb-4 bg-white">
                    <table class="table table-hover align-middle mb-0" id="feeHeadsTable">
                        <thead class="table-dark text-uppercase fs-8">
                            <tr>
                                <th class="py-3 ps-3">Fee Head</th>
                                <th class="py-3">Frequency</th>
                                <th class="py-3">Amount (PKR)</th>
                                <th class="py-3">Due Date</th>
                                <th class="py-3 text-center" style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="feeHeadRows">
                            <tr>
                                <td class="ps-3">
                                    <select name="fee_heads[0][head_id]" class="form-select shadow-none" required {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                                        <option value="">-- Select Fee Head --</option>
                                        @foreach($feeHeads as $head)
                                            <option value="{{ $head->id }}">{{ $head->name ?? $head->head_name }} ({{ $head->type ?? 'General' }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="fee_heads[0][frequency]" class="form-select shadow-none">
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
                                    <input type="number" name="fee_heads[0][amount]" class="form-control head-amount shadow-none" placeholder="0.00" oninput="calculateGrandTotal()" required>
                                </td>
                                <td>
                                    <input type="date" name="fee_heads[0][due_date]" class="form-control shadow-none" value="{{ date('Y-m-10', strtotime('+1 month')) }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-row border-0"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-dark fw-bold px-3" id="addHeadBtn" {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa-solid fa-plus me-1 text-primary"></i> Add Custom Fee Head
                    </button>
                </div>

                <!-- 3. Scholarship & Concessions -->
                <div class="row g-4 bg-light p-4 rounded-4 border mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary">Discount / Concession Amount (PKR)</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control shadow-none" value="0" oninput="calculateGrandTotal()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary">Concession Reason / Scholarship</label>
                        <select name="discount_reason" class="form-select shadow-none">
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
                        <label class="form-label fw-bold text-secondary">Approved By</label>
                        <input type="text" name="discount_approved_by" class="form-control shadow-none" value="{{ Auth::user()->name ?? 'Principal' }}">
                    </div>
                </div>

                <!-- 4. Grand Total Summary Card -->
                <div class="card bg-warning text-dark border-0 mb-4 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h6 class="mb-1 fw-bold text-uppercase">Total Agreed Net Allotment:</h6>
                            <small class="text-dark opacity-75">Net payable amount evaluated dynamically after fee heads and applied concessions.</small>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark font-monospace" id="grandTotalDisplay">PKR 0.00</h2>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center gap-3 pt-3 border-top">
                    <a href="{{ route('fees.index') }}" class="btn btn-light border px-4 py-2 fw-bold text-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm" {{ $feeHeads->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa-solid fa-check-circle me-2"></i> Confirm & Save Allotment
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
        <td class="ps-3">
            <select name="fee_heads[${rowIndex}][head_id]" class="form-select shadow-none" required>
                <option value="">-- Select Fee Head --</option>
                @foreach($feeHeads as $head)
                    <option value="{{ $head->id }}">{{ $head->name ?? $head->head_name }} ({{ $head->type ?? 'General' }})</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="fee_heads[${rowIndex}][frequency]" class="form-select shadow-none">
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
            <input type="number" name="fee_heads[${rowIndex}][amount]" class="form-control head-amount shadow-none" placeholder="0.00" oninput="calculateGrandTotal()" required>
        </td>
        <td>
            <input type="date" name="fee_heads[${rowIndex}][due_date]" class="form-control shadow-none" value="{{ date('Y-m-10', strtotime('+1 month')) }}">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-row border-0"><i class="fa-solid fa-trash"></i></button>
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