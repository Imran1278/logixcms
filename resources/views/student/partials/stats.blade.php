{{-- File Path: resources/views/student/partials/stats.blade.php --}}
@php
    $enrolledCount = count($coursesList ?? []);
    $messagesCount = count($userInquiries ?? []);
    $dueAmount     = $feeSummary['due_amount'] ?? 0;
@endphp

<style>
    .stat-card-modern {
        background: var(--box-bg, #ffffff);
        border: 1px solid var(--panel-border, #e2e8f0);
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        border-color: rgba(200, 162, 81, 0.4);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .stat-card-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(200, 162, 81, 0.18) 0%, rgba(200, 162, 81, 0.05) 100%);
        border: 1px solid rgba(200, 162, 81, 0.3);
        color: var(--color-gold, #c8a251);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-label-title {
        font-size: 0.74rem;
        font-weight: 800;
        color: var(--text-muted, #64748b);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
        display: block;
    }

    .stat-value-heading {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-main, #0f172a);
        line-height: 1.2;
    }
</style>

<!-- Quick Stats Cards Row -->
<div class="row g-3 mb-4">
    <!-- Courses Enrolled -->
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="stat-card-modern d-flex align-items-center gap-3">
            <div class="stat-card-icon-box">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <span class="stat-label-title">Courses Enrolled</span>
                <h3 class="stat-value-heading mb-0">{{ $enrolledCount > 0 ? $enrolledCount : 1 }}</h3>
            </div>
        </div>
    </div>

    <!-- Academic Status -->
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="stat-card-modern d-flex align-items-center gap-3">
            <div class="stat-card-icon-box">
                <i class="fa-solid fa-award"></i>
            </div>
            <div>
                <span class="stat-label-title">Academic Status</span>
                <h3 class="stat-value-heading text-success mb-0">Active</h3>
            </div>
        </div>
    </div>

    <!-- Pending Fees -->
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="stat-card-modern d-flex align-items-center gap-3">
            <div class="stat-card-icon-box">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div>
                <span class="stat-label-title">Pending Fees</span>
                <h3 class="stat-value-heading mb-0 {{ $dueAmount > 0 ? 'text-danger' : 'text-dark' }}">
                    Rs. {{ number_format($dueAmount) }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Messages / Inquiries -->
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="stat-card-modern d-flex align-items-center gap-3">
            <div class="stat-card-icon-box">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div>
                <span class="stat-label-title">Messages</span>
                <h3 class="stat-value-heading mb-0">{{ $messagesCount }}</h3>
            </div>
        </div>
    </div>
</div>