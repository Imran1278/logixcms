@extends('layouts.app')

@section('page_title', 'Admin Portal')


@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        --color-red: #B91C1C;
        --color-white: #FFFFFF;
        --color-black: #000000;
        
        --dash-card-bg: #FFFFFF;
        --dash-card-border: #E2E8F0;
        --dash-panel-header: #FAFCFF;
        --dash-text-main: #0A2D5A;
        --dash-text-sub: #1E293B;
        --dash-table-head: #F8FAFC;
    }

    [data-bs-theme="dark"] {
        --dash-card-bg: #0F1B2D;
        --dash-card-border: #1E293B;
        --dash-panel-header: #14243B;
        --dash-text-main: #F1F5F9;
        --dash-text-sub: #94A3B8;
        --dash-table-head: #162842;
    }

    /* Custom Sleek Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--color-ice);
        border-radius: 10px;
    }

    /* Executive Hero Banner */
    .dashboard-hero {
        background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%);
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(10, 45, 90, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(207, 174, 78, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* KPI Glassmorphic Stat Cards */
    .stat-card-executive {
        background: var(--dash-card-bg);
        border: 1px solid var(--dash-card-border);
        border-radius: 18px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .stat-card-executive:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(10, 45, 90, 0.12);
        border-color: var(--color-ice);
    }

    .stat-card-executive .indicator-strip {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .dash-stat-value {
        color: var(--dash-text-main) !important;
    }

    /* Modern Table Cards */
    .dash-panel {
        background: var(--dash-card-bg);
        border: 1px solid var(--dash-card-border);
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .dash-panel-header {
        background: var(--dash-panel-header);
        border-bottom: 1px solid var(--dash-card-border);
        padding: 18px 24px;
        font-weight: 700;
        color: var(--dash-text-main);
    }

    .dash-table-head {
        background-color: var(--dash-table-head) !important;
    }

    .dash-table-head th {
        background-color: transparent !important;
        color: var(--dash-text-sub) !important;
    }

    .dash-item-title {
        color: var(--dash-text-main) !important;
    }

    /* Styled Executive Buttons */
    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 10px;
        border: none;
        padding: 10px 22px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
    }

    .btn-gold-action:hover {
        background-color: #B8993E;
        color: var(--color-black);
        transform: translateY(-1px);
    }

    .btn-ghost-action {
        background: rgba(255, 255, 255, 0.12);
        color: var(--color-white);
        font-weight: 600;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 10px 22px;
        backdrop-filter: blur(4px);
        transition: all 0.25s ease;
    }

    .btn-ghost-action:hover {
        background: rgba(255, 255, 255, 0.25);
        color: var(--color-white);
    }

    .badge-gold {
        background-color: rgba(207, 174, 78, 0.15);
        color: #CFAE4E;
        border: 1px solid rgba(207, 174, 78, 0.3);
    }

    .badge-navy {
        background-color: rgba(10, 45, 90, 0.2);
        color: var(--color-ice);
        border: 1px solid rgba(139, 180, 227, 0.3);
    }

    .badge-crimson {
        background-color: rgba(185, 28, 28, 0.15);
        color: #F87171;
        border: 1px solid rgba(185, 28, 28, 0.3);
    }

    .badge-blue {
        background-color: rgba(46, 95, 163, 0.2);
        color: var(--color-ice);
        border: 1px solid rgba(46, 95, 163, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <!-- Hero Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-hero p-4 text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="z-1">
                    <span class="badge badge-gold fw-bold mb-2 text-uppercase tracking-wider px-3 py-2" style="font-size: 0.72rem; border-radius: 6px;">
                        <i class="fa-solid fa-crown me-1"></i> LOGIX Executive Hub
                    </span>
                    <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px;">Welcome back, {{ Auth::user()->name ?? 'Administrator' }}</h2>
                    <p class="mb-0 text-white-50 small">Here is your real-time operational breakdown and financial metrics for today.</p>
                </div>
                <div class="d-flex align-items-center gap-2 z-1">
                    <a href="{{ route('admissions.create') }}" class="btn btn-gold-action">
                        <i class="fa-solid fa-user-plus me-1"></i> New Admission
                    </a>
                    <a href="{{ route('inquiries.index') }}" class="btn btn-ghost-action">
                        <i class="fa-solid fa-headset me-1"></i> Add Inquiry
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Metrics Grid -->
    <div class="row g-3 mb-4">
        
        <!-- Total Active Courses -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-executive h-100">
                <div class="indicator-strip" style="background-color: var(--color-blue);"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-uppercase fs-8 fw-bold text-muted tracking-wider">Active Programs</span>
                        <h2 class="fw-bold my-2 dash-stat-value">{{ $totalCourses ?? 0 }}</h2>
                        <span class="badge badge-blue fw-semibold fs-8">
                            <i class="fa-solid fa-book-open me-1"></i> Offered Courses
                        </span>
                    </div>
                    <div class="stat-icon-box text-white shadow-sm" style="background-color: var(--color-blue);">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admissions -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-executive h-100">
                <div class="indicator-strip" style="background-color: var(--color-navy);"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-uppercase fs-8 fw-bold text-muted tracking-wider">Total Enrolments</span>
                        <h2 class="fw-bold my-2 dash-stat-value">{{ $totalAdmissions ?? 0 }}</h2>
                        <span class="badge badge-navy fw-semibold fs-8">
                            <i class="fa-solid fa-user-graduate me-1"></i> Active Students
                        </span>
                    </div>
                    <div class="stat-icon-box text-white shadow-sm" style="background-color: var(--color-navy);">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-executive h-100">
                <div class="indicator-strip" style="background-color: var(--color-red);"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-uppercase fs-8 fw-bold text-muted tracking-wider">Today's Attendance</span>
                        <h2 class="fw-bold my-2 dash-stat-value">{{ $todayAttendance ?? 0 }}</h2>
                        <span class="badge badge-crimson fw-semibold fs-8">
                            <i class="fa-solid fa-clipboard-check me-1"></i> Present Today
                        </span>
                    </div>
                    <div class="stat-icon-box text-white shadow-sm" style="background-color: var(--color-red);">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Collected -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-executive h-100">
                <div class="indicator-strip" style="background-color: var(--color-gold);"></div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-uppercase fs-8 fw-bold text-muted tracking-wider">Fee Collection</span>
                        <h2 class="fw-bold my-2 dash-stat-value">Rs. {{ number_format($totalCollectedFee ?? 0) }}</h2>
                        <span class="badge badge-gold fw-semibold fs-8">
                            <i class="fa-solid fa-wallet me-1"></i> Total Revenue
                        </span>
                    </div>
                    <div class="stat-icon-box text-white shadow-sm" style="background-color: var(--color-gold);">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Real-time Data Analytics Tables -->
    <div class="row g-4">
        
        <!-- Recent CRM Inquiries -->
        <div class="col-lg-6">
            <div class="dash-panel h-100">
                <div class="dash-panel-header d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-headset" style="color: var(--color-blue);"></i> Recent CRM Inquiries
                    </span>
                    <a href="{{ route('inquiries.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold px-3" style="border-radius: 8px;">
                        View All <i class="fa-solid fa-arrow-right fs-8 ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-uppercase fs-8 dash-table-head">
                                    <th class="ps-4">Applicant Name</th>
                                    <th>Contact No</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInquiries ?? [] as $inquiry)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold dash-item-title">{{ $inquiry->student_name }}</div>
                                    </td>
                                    <td>
                                        <span class="small font-monospace text-muted"><i class="fa-solid fa-phone me-1 fs-8" style="color: var(--color-ice);"></i>{{ $inquiry->mobile_number }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($inquiry->status == 'Converted')
                                            <span class="badge badge-navy px-2 py-1"><i class="fa-solid fa-check-circle me-1"></i>Converted</span>
                                        @elseif($inquiry->status == 'Contacted')
                                            <span class="badge badge-gold px-2 py-1"><i class="fa-solid fa-clock me-1"></i>Contacted</span>
                                        @else
                                            <span class="badge badge-blue px-2 py-1"><i class="fa-solid fa-dot-circle me-1"></i>New</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No recent inquiries recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Financial Collections -->
        <div class="col-lg-6">
            <div class="dash-panel h-100">
                <div class="dash-panel-header d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar" style="color: var(--color-gold);"></i> Recent Collections
                    </span>
                    <a href="{{ route('fees.index') }}" class="btn btn-sm btn-outline-secondary fw-semibold px-3" style="border-radius: 8px;">
                        Fee Ledger <i class="fa-solid fa-arrow-right fs-8 ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-uppercase fs-8 dash-table-head">
                                    <th class="ps-4">Receipt</th>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th class="text-end pe-4">Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments ?? [] as $payment)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="badge font-monospace text-white" style="background-color: var(--color-navy);">#{{ $payment->receipt_no }}</span>
                                    </td>
                                    <td class="fw-bold dash-item-title">{{ $payment->admission->student_name ?? 'N/A' }}</td>
                                    <td class="fw-bold" style="color: var(--color-blue);">Rs. {{ number_format($payment->amount_paid) }}</td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-body-tertiary text-body border px-2 py-1">{{ $payment->payment_method }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent fee collections logged.</td>
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