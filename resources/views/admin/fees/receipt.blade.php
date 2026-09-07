<!-- resources/views/admin/fees/receipt.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipt #{{ $fee->receipt_no }} - LOGIX CMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --logix-navy-dark: #050E1A;
            --logix-navy: #0B2545;
            --logix-gold: #D4AF37;
            --logix-gold-hover: #E5C158;
            --logix-card-bg: #FFFFFF;
            --logix-border: rgba(212, 175, 55, 0.3);
        }
        body { 
            background: #050E1A; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
        }
        .receipt-container {
            max-width: 900px;
            margin: 30px auto;
        }
        .single-receipt {
            background: var(--logix-card-bg);
            border: 1px solid var(--logix-border);
            border-radius: 16px;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .copy-tag {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--logix-navy);
            color: var(--logix-gold);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 6px 18px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 15px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-left: 1px solid var(--logix-gold);
            border-bottom: 1px solid var(--logix-gold);
        }
        .header-title { 
            color: var(--logix-navy); 
            font-weight: 800; 
            letter-spacing: -0.5px;
        }
        .receipt-table th {
            background-color: var(--logix-navy) !important;
            color: var(--logix-gold) !important;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .cut-line {
            border-top: 2px dashed rgba(212, 175, 55, 0.4);
            margin: 35px 0;
            position: relative;
            text-align: center;
        }
        .cut-line i {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #050E1A;
            padding: 0 12px;
            color: var(--logix-gold);
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; color: #000 !important; }
            .receipt-container { margin: 0; max-width: 100%; }
            .single-receipt { border: 1px solid #000; box-shadow: none; padding: 20px; page-break-inside: avoid; }
            .cut-line i { background: #fff; color: #000; }
            .copy-tag { background: #000 !important; color: #fff !important; }
        }
    </style>
</head>
<body>

<div class="receipt-container">

    <div class="d-flex justify-content-between align-items-center mb-4 no-print bg-white p-3 rounded-4 border shadow-sm">
        <a href="{{ route('fees.index') }}" class="btn btn-outline-dark fw-bold rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Fees List
        </a>
        <button onclick="window.print()" class="btn fw-bold px-4 rounded-3" style="background-color: var(--logix-navy); color: var(--logix-gold); border: 1px solid var(--logix-gold);">
            <i class="fa-solid fa-print me-2"></i> Print Fee Receipt
        </button>
    </div>

    <!-- Student Copy -->
    <div class="single-receipt mb-4">
        <div class="copy-tag">Student Copy</div>
        
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <div>
                <h3 class="header-title mb-0"><i class="fa-solid fa-graduation-cap text-warning me-2"></i>LOGIX CMS</h3>
                <small class="text-muted fw-bold">Official Student Fee Payment Voucher</small>
            </div>
            <div class="text-end me-4">
                <h5 class="fw-bold text-danger mb-0 font-monospace">#{{ $fee->receipt_no }}</h5>
                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i>Date: {{ \Carbon\Carbon::parse($fee->payment_date)->format('d M, Y') }}</small>
            </div>
        </div>

        <div class="row g-3 my-2 fs-7">
            <div class="col-6">
                <p class="mb-1"><strong>Student Name:</strong> <span class="text-dark fw-bold">{{ $fee->admission->student_name }}</span></p>
                <p class="mb-1"><strong>Reg No:</strong> <span class="badge bg-dark font-monospace">{{ $fee->admission->registration_no }}</span></p>
                <p class="mb-1"><strong>Course:</strong> {{ $fee->admission->course->course_name ?? 'N/A' }}</p>
            </div>
            <div class="col-6 text-end">
                <p class="mb-1"><strong>Father Name:</strong> {{ $fee->admission->father_name }}</p>
                <p class="mb-1"><strong>Batch:</strong> {{ $fee->admission->batch->batch_number ?? $fee->admission->batch->batch_code ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Payment Mode:</strong> <span class="badge bg-light text-dark border">{{ $fee->payment_method }}</span></p>
            </div>
        </div>

        <table class="table table-bordered receipt-table my-3">
            <thead>
                <tr>
                    <th>Payment Breakdown / Fee Heads</th>
                    <th class="text-end">Amount (PKR)</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($fee->allocation) && $fee->allocation->items->count() > 0)
                    @foreach($fee->allocation->items as $item)
                    <tr>
                        <td>{{ $item->head->name ?? 'Fee Head' }} ({{ $item->frequency }})</td>
                        <td class="text-end font-monospace">Rs. {{ number_format($item->amount) }}</td>
                    </tr>
                    @endforeach
                    @if($fee->allocation->discount_amount > 0)
                    <tr class="text-danger">
                        <td>Concession / Scholarship ({{ $fee->allocation->discount_reason ?? 'Approved' }})</td>
                        <td class="text-end font-monospace">- Rs. {{ number_format($fee->allocation->discount_amount) }}</td>
                    </tr>
                    @endif
                @else
                    <tr>
                        <td class="fw-semibold">Total Net Agreed Fee</td>
                        <td class="text-end font-monospace">Rs. {{ number_format($totalAgreed) }}</td>
                    </tr>
                @endif
                <tr class="table-success fw-bold">
                    <td>Amount Received (This Receipt)</td>
                    <td class="text-end font-monospace text-success fs-6">Rs. {{ number_format($fee->amount_paid) }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Total Paid Till Date</td>
                    <td class="text-end font-monospace">Rs. {{ number_format($totalPaidTillNow) }}</td>
                </tr>
                <tr class="{{ $balance > 0 ? 'table-warning' : 'table-light' }} fw-bold">
                    <td>Remaining Balance Due</td>
                    <td class="text-end font-monospace {{ $balance > 0 ? 'text-danger' : 'text-success' }}">Rs. {{ number_format($balance) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-end mt-4 pt-3 border-top">
            <div>
                <small class="text-muted d-block">Issued By: <strong>{{ $fee->received_by ?? Auth::user()->name }}</strong></small>
                <small class="text-muted fs-8">Computer generated receipt. Valid with official stamp.</small>
            </div>
            <div class="text-center" style="width: 180px;">
                <div class="border-bottom border-dark mb-1"></div>
                <small class="fw-bold text-dark">Authorized Signature</small>
            </div>
        </div>
    </div>

    <div class="cut-line no-print">
        <i class="fa-solid fa-scissors"></i>
    </div>

    <!-- Office Copy -->
    <div class="single-receipt">
        <div class="copy-tag" style="background-color: #334155;">Office Copy</div>
        
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <div>
                <h3 class="header-title mb-0"><i class="fa-solid fa-graduation-cap text-warning me-2"></i>LOGIX CMS</h3>
                <small class="text-muted fw-bold">Official Fee Payment Voucher (Accounts Copy)</small>
            </div>
            <div class="text-end me-4">
                <h5 class="fw-bold text-danger mb-0 font-monospace">#{{ $fee->receipt_no }}</h5>
                <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i>Date: {{ \Carbon\Carbon::parse($fee->payment_date)->format('d M, Y') }}</small>
            </div>
        </div>

        <div class="row g-3 my-2 fs-7">
            <div class="col-6">
                <p class="mb-1"><strong>Student Name:</strong> <span class="text-dark fw-bold">{{ $fee->admission->student_name }}</span></p>
                <p class="mb-1"><strong>Reg No:</strong> <span class="badge bg-dark font-monospace">{{ $fee->admission->registration_no }}</span></p>
                <p class="mb-1"><strong>Course:</strong> {{ $fee->admission->course->course_name ?? 'N/A' }}</p>
            </div>
            <div class="col-6 text-end">
                <p class="mb-1"><strong>Father Name:</strong> {{ $fee->admission->father_name }}</p>
                <p class="mb-1"><strong>Batch:</strong> {{ $fee->admission->batch->batch_number ?? $fee->admission->batch->batch_code ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Payment Mode:</strong> <span class="badge bg-light text-dark border">{{ $fee->payment_method }}</span></p>
            </div>
        </div>

        <table class="table table-bordered receipt-table my-3">
            <thead>
                <tr>
                    <th>Payment Breakdown / Fee Heads</th>
                    <th class="text-end">Amount (PKR)</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($fee->allocation) && $fee->allocation->items->count() > 0)
                    @foreach($fee->allocation->items as $item)
                    <tr>
                        <td>{{ $item->head->name ?? 'Fee Head' }} ({{ $item->frequency }})</td>
                        <td class="text-end font-monospace">Rs. {{ number_format($item->amount) }}</td>
                    </tr>
                    @endforeach
                    @if($fee->allocation->discount_amount > 0)
                    <tr class="text-danger">
                        <td>Concession / Scholarship ({{ $fee->allocation->discount_reason ?? 'Approved' }})</td>
                        <td class="text-end font-monospace">- Rs. {{ number_format($fee->allocation->discount_amount) }}</td>
                    </tr>
                    @endif
                @else
                    <tr>
                        <td class="fw-semibold">Total Net Agreed Fee</td>
                        <td class="text-end font-monospace">Rs. {{ number_format($totalAgreed) }}</td>
                    </tr>
                @endif
                <tr class="table-success fw-bold">
                    <td>Amount Received (This Receipt)</td>
                    <td class="text-end font-monospace text-success fs-6">Rs. {{ number_format($fee->amount_paid) }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Total Paid Till Date</td>
                    <td class="text-end font-monospace">Rs. {{ number_format($totalPaidTillNow) }}</td>
                </tr>
                <tr class="{{ $balance > 0 ? 'table-warning' : 'table-light' }} fw-bold">
                    <td>Remaining Balance Due</td>
                    <td class="text-end font-monospace {{ $balance > 0 ? 'text-danger' : 'text-success' }}">Rs. {{ number_format($balance) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-end mt-4 pt-3 border-top">
            <div>
                <small class="text-muted d-block">Received By: <strong>{{ $fee->received_by ?? Auth::user()->name }}</strong></small>
            </div>
            <div class="text-center" style="width: 180px;">
                <div class="border-bottom border-dark mb-1"></div>
                <small class="fw-bold text-dark">Cashier Signature</small>
            </div>
        </div>
    </div>

</div>

</body>
</html>