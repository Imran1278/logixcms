@extends('layouts.app')

@section('page_title', $course->course_name . ' - Program Details')

@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        
        --panel-bg: #FFFFFF;
        --panel-border: #E2E8F0;
        --panel-header-bg: #0A2D5A;
        --panel-header-text: #FFFFFF;
        --input-bg: #FFFFFF;
        --input-border: #CBD5E1;
        --input-text: #0F172A;
        --text-primary: #0F172A;
        --text-muted: #64748B;
        --card-bg: #FFFFFF;
        --box-subtle-bg: #F8FAFC;
    }

    [data-bs-theme="dark"] {
        --panel-bg: #0F1B2D;
        --panel-border: #1E293B;
        --panel-header-bg: #06152B;
        --panel-header-text: #F1F5F9;
        --input-bg: #162842;
        --input-border: #334155;
        --input-text: #F8FAFC;
        --text-primary: #F8FAFC;
        --text-muted: #94A3B8;
        --card-bg: #0F1B2D;
        --box-subtle-bg: #162842;
    }

    .course-header-banner {
        background: linear-gradient(135deg, rgba(6, 21, 43, 0.95) 0%, rgba(10, 45, 90, 0.90) 100%);
        color: #ffffff;
        padding: 35px 24px;
        border-radius: 18px;
        border: 1px solid var(--panel-border);
        margin-bottom: 24px;
    }

    .course-card-details, .sidebar-card, .join-card {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--panel-border);
    }

    .join-card {
        border: 2px solid var(--color-gold);
        overflow: hidden;
    }

    .join-card .card-header {
        background-color: var(--color-navy);
        color: #ffffff;
        padding: 16px 20px;
        border-bottom: 2px solid var(--color-gold);
    }

    .join-card .form-control,
    .join-card .form-select {
        background-color: var(--input-bg);
        border-color: var(--input-border);
        color: var(--input-text);
    }

    .join-card .form-control:focus,
    .join-card .form-select:focus {
        border-color: var(--color-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.25);
    }

    .subtle-box {
        background-color: var(--box-subtle-bg);
        border: 1px solid var(--panel-border);
    }

    .content-box {
        background-color: var(--card-bg);
        border-left: 4px solid var(--color-gold);
        border-radius: 8px;
    }

    .rich-text-content {
        color: var(--text-primary);
        line-height: 1.7;
    }

    .rich-text-content ul, .rich-text-content ol {
        padding-left: 20px;
        margin-bottom: 1rem;
    }

    .rich-text-content li {
        margin-bottom: 6px;
    }

    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 50px;
        padding: 10px 24px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
    }

    .text-theme-primary {
        color: var(--text-primary) !important;
    }

    .text-theme-muted {
        color: var(--text-muted) !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <!-- Header Banner -->
    <div class="course-header-banner">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-2">
                    Code: {{ $course->course_code }}
                </span>
                <h2 class="fw-bold mb-0 text-white">{{ $course->course_name }}</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('courses.index') }}" class="btn btn-outline-light rounded-pill px-3 fw-bold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Courses
                </a>
                <a href="#join-now-form" class="btn btn-gold-action shadow-sm">
                    <i class="fa-solid fa-paper-plane me-1"></i> Enroll / Register Student
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- Main Course Details -->
        <div class="col-lg-8">
            <div class="course-card-details p-4">
                
                @if($course->image)
                <img src="{{ Storage::url($course->image) }}" class="img-fluid rounded-4 mb-4" style="max-height: 100%; object-fit: cover; width: 100%;">
                @else
                    <div class="bg-dark text-white text-center py-5 rounded-4 mb-4 fs-4 fw-bold">
                        <i class="fa-solid fa-graduation-cap display-3 d-block mb-2 text-warning opacity-75"></i>
                        {{ $course->course_name }}
                    </div>
                @endif

                <div class="d-flex flex-wrap gap-2 my-3">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6 px-3 py-2 rounded-pill">
                        <i class="fa-regular fa-clock me-1"></i> Duration: {{ $course->duration }} {{ $course->duration_type }}
                    </span>
                    
                    @if($course->seats)
                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fs-6 px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-chair me-1"></i> Seats: {{ $course->seats }}
                        </span>
                    @endif

                    @if($course->has_installments)
                        <span class="badge bg-success-subtle text-success border border-success-subtle fs-6 px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-wallet me-1"></i> Installments Available
                        </span>
                    @endif
                </div>

                <!-- Financial Details Box -->
                <div class="card subtle-box rounded-4 p-3 my-4 border-0">
                    <h6 class="fw-bold text-theme-primary mb-3"><i class="fa-solid fa-money-check-dollar text-warning me-2"></i>Fee & Financial Details</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-uppercase text-theme-muted fw-bold d-block" style="font-size: 11px;">Fee Plan</small>
                            <span class="fw-bold text-theme-primary fs-6">{{ $course->fee_type ?? 'Total Standard Fee' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-uppercase text-theme-muted fw-bold d-block" style="font-size: 11px;">Standard Fee</small>
                            <span class="fw-bold text-primary fs-5">PKR {{ number_format($course->standard_fee) }}</span>
                        </div>
                        @if($course->registration_fee)
                            <div class="col-md-4">
                                <small class="text-uppercase text-theme-muted fw-bold d-block" style="font-size: 11px;">Registration Fee</small>
                                <span class="fw-bold text-theme-muted fs-6">PKR {{ number_format($course->registration_fee) }}</span>
                            </div>
                        @endif
                    </div>

                    @if($course->has_installments && $course->no_of_installments)
                        <hr class="my-3">
                        <div class="p-2 rounded-3 border subtle-box">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-dark me-2">{{ $course->no_of_installments }} Easy Installments</span>
                                    <small class="text-theme-muted fw-semibold">Pay in flexible monthly installments</small>
                                </div>
                                @if($course->installment_amount)
                                    <div class="text-end">
                                        <small class="d-block text-theme-muted" style="font-size: 10px;">Per Installment:</small>
                                        <span class="fw-bold text-success">PKR {{ number_format($course->installment_amount) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Class Timing Slots -->
                @if(!empty($course->timing_slots) || $course->timing || $course->custom_timing)
                    <div class="mb-4">
                        <h6 class="fw-bold text-theme-primary mb-2"><i class="fa-regular fa-clock text-info me-2"></i>Available Class Timing Slots</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if(is_array($course->timing_slots))
                                @foreach($course->timing_slots as $slot)
                                    <span class="badge subtle-box text-theme-primary border shadow-sm px-3 py-2 rounded-3"><i class="fa-solid fa-sun text-warning me-1"></i> {{ $slot }}</span>
                                @endforeach
                            @elseif($course->timing)
                                <span class="badge subtle-box text-theme-primary border shadow-sm px-3 py-2 rounded-3">{{ $course->timing }}</span>
                            @endif

                            @if($course->custom_timing)
                                <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2 rounded-3">{{ $course->custom_timing }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                <hr class="my-4">

                <!-- Overview -->
                @if(!empty($course->description))
                    <div class="mb-4">
                        <h5 class="fw-bold text-theme-primary mb-2"><i class="fa-solid fa-circle-info text-primary me-2"></i>Overview</h5>
                        <div class="rich-text-content text-theme-muted fs-6 leading-relaxed">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Curriculum & Objectives -->
                @if(!empty($course->objectives))
                    <div class="mb-4">
                        <h5 class="fw-bold text-theme-primary mb-3"><i class="fa-solid fa-bullseye text-warning me-2"></i>Objectives & Curriculum</h5>
                        <div class="content-box p-3 shadow-sm border">
                            <div class="rich-text-content">
                                {!! $course->objectives !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Eligibility Criteria -->
                @if(!empty($course->eligibility))
                    <div class="mb-4">
                        <h5 class="fw-bold text-theme-primary mb-2"><i class="fa-solid fa-user-check text-success me-2"></i>Eligibility Criteria</h5>
                        <div class="alert subtle-box border text-theme-primary rounded-3 shadow-sm">
                            <div class="rich-text-content">
                                {!! $course->eligibility !!}
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Sidebar / Registration Form -->
        <div class="col-lg-4">
            
            <div class="join-card mb-4" id="join-now-form">
                <div class="card-header">
                    <h5 class="fw-bold mb-0 text-warning d-flex align-items-center">
                        <i class="fa-solid fa-user-plus me-2"></i> Join Now / Registration
                    </h5>
                    <small class="text-light opacity-75">Submit details to reserve student seat</small>
                </div>
                <div class="p-4">
                    <form action="{{ route('inquiries.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text subtle-box text-theme-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Ali Raza" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Phone / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text subtle-box text-theme-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" name="phone" class="form-control" placeholder="0300 1234567" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text subtle-box text-theme-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="ali@example.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Selected Course <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text subtle-box text-theme-muted"><i class="fa-solid fa-book"></i></span>
                                <input type="text" class="form-control subtle-box fw-bold text-theme-primary" value="{{ $course->course_name }}" readonly>
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                            </div>
                        </div>

                        @if(is_array($course->timing_slots) && count($course->timing_slots) > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold text-theme-primary small mb-1">Preferred Slot</label>
                                <select name="preferred_timing" class="form-select">
                                    @foreach($course->timing_slots as $slot)
                                        <option value="{{ $slot }}">{{ $slot }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Place / City <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text subtle-box text-theme-muted"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text" name="place" class="form-control" placeholder="e.g. Sargodha, Lahore" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-theme-primary small mb-1">Any Question? (Optional)</label>
                            <textarea name="message" class="form-control" rows="2" placeholder="Write any query here..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-gold-action w-100 py-2 shadow-sm">
                            <i class="fa-solid fa-paper-plane me-1"></i> Submit Registration
                        </button>
                    </form>
                </div>
            </div>

            <div class="sidebar-card p-4">
                <h5 class="fw-bold text-theme-primary mb-3 border-bottom pb-2">Other Available Programs</h5>
                
                <div class="d-flex flex-column gap-3">
                    @forelse($otherCourses as $other)
                        <div class="d-flex gap-3 align-items-center">
                            @if($other->image)
                                <img src="{{ asset($other->image) }}" width="60" height="60" class="rounded-3 object-fit-cover">
                            @else
                                <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 60px; height: 60px; font-size: 11px;">
                                    {{ $other->course_code }}
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1" style="font-size: 14px;">
                                    <a href="{{ route('courses.show', $other->id) }}" class="text-decoration-none text-theme-primary">{{ $other->course_name }}</a>
                                </h6>
                                <small class="text-theme-muted d-block" style="font-size: 11px;"><i class="fa-regular fa-clock me-1"></i> {{ $other->duration }} {{ $other->duration_type }}</small>
                                <small class="text-success fw-bold" style="font-size: 12px;">PKR {{ number_format($other->standard_fee) }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-theme-muted small mb-0">No other courses available.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection