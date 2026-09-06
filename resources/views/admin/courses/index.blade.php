@extends('layouts.app')

@section('page_title', 'Course & Program Management')

@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        --color-red: #B91C1C;
        
        --panel-bg: #FFFFFF;
        --panel-border: #E2E8F0;
        --panel-header-bg: #0A2D5A;
        --panel-header-text: #FFFFFF;
        --input-bg: #FFFFFF;
        --input-border: #CBD5E1;
        --input-text: #0F172A;
        --table-head-bg: #F8FAFC;
        --table-text-main: #0A2D5A;
        --box-subtle-bg: rgba(207, 174, 78, 0.08);
    }

    [data-bs-theme="dark"] {
        --panel-bg: #0F1B2D;
        --panel-border: #1E293B;
        --panel-header-bg: #06152B;
        --panel-header-text: #F1F5F9;
        --input-bg: #162842;
        --input-border: #334155;
        --input-text: #F8FAFC;
        --table-head-bg: #162842;
        --table-text-main: #F1F5F9;
        --box-subtle-bg: rgba(207, 174, 78, 0.12);
    }

    .panel-card {
        background: var(--panel-bg);
        border: 1px solid var(--panel-border);
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .panel-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        border-radius: 17px 17px 0 0 !important;
        padding: 18px 24px;
        border-bottom: 1px solid var(--panel-border);
    }

    .panel-card .form-control,
    .panel-card .form-select {
        background-color: var(--input-bg);
        border-color: var(--input-border);
        color: var(--input-text);
    }

    .panel-card .form-control:focus,
    .panel-card .form-select:focus {
        border-color: var(--color-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.25);
    }

    .panel-card .form-control[readonly] {
        background-color: var(--panel-border);
        opacity: 0.8;
    }

    .subtle-box {
        background-color: var(--box-subtle-bg);
        border: 1px solid rgba(207, 174, 78, 0.25);
    }

    .table-head-theme {
        background-color: var(--table-head-bg) !important;
    }

    .table-head-theme th {
        background-color: transparent !important;
        color: var(--input-text) !important;
    }

    .course-title-text {
        color: var(--table-text-main) !important;
    }

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
        color: #000000;
    }

    .badge-gold {
        background-color: rgba(207, 174, 78, 0.15);
        color: var(--color-gold);
        border: 1px solid rgba(207, 174, 78, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="row g-4">
        
        <!-- Add Course Form -->
        <div class="col-lg-6">
            <div class="card panel-card border-0 mb-4">
                <div class="card-header panel-header">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-warning"></i> Add New Academic Program
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="courseForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <label class="form-label fw-bold text-body-secondary">Course Name <span class="text-danger">*</span></label>
                                <input type="text" id="course_name" name="course_name" class="form-control shadow-sm" placeholder="e.g. BS Computer Science" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-body-secondary">Course Code <span class="text-danger">*</span></label>
                                <input type="text" id="course_code" name="course_code" class="form-control fw-bold shadow-sm" placeholder="e.g. BSCS" required style="text-transform:uppercase;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label class="form-label fw-bold text-body-secondary">Total Seats</label>
                                <input type="number" name="seats" class="form-control shadow-sm" value="30" required>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label class="form-label fw-bold text-body-secondary">Duration</label>
                                <input type="number" name="duration" class="form-control shadow-sm" value="4" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-body-secondary">Duration Unit</label>
                                <select name="duration_type" class="form-select shadow-sm">
                                    <option value="Days">Days</option>
                                    <option value="Weeks">Weeks</option>
                                    <option value="Months" selected>Months</option>
                                    <option value="Years">Years</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold d-block text-body-secondary">Available Timing Slots</label>
                            <div class="p-3 border rounded-3 bg-body-tertiary">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Morning (08:00 AM - 11:00 AM)" id="slot1">
                                    <label class="form-check-label small" for="slot1">Morning (08:00 - 11:00 AM)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Afternoon (11:30 AM - 02:30 PM)" id="slot2">
                                    <label class="form-check-label small" for="slot2">Afternoon (11:30 - 02:30 PM)</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Evening (03:00 PM - 06:00 PM)" id="slot3">
                                    <label class="form-check-label small" for="slot3">Evening (03:00 - 06:00 PM)</label>
                                </div>
                                <div class="mt-2">
                                    <input type="text" name="custom_timing" class="form-control form-control-sm" placeholder="Or custom timing (e.g. Sat-Sun 10 AM - 2 PM)">
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 subtle-box rounded-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--color-gold);">
                                    <i class="fa-solid fa-calculator"></i> Fee Structure & Discounts
                                </h6>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2 mb-md-0">
                                        <label class="form-label fw-bold text-body-secondary">Fee Payment Type</label>
                                        <select name="fee_type" id="fee_type" class="form-select shadow-sm">
                                            <option value="Total Fee">Total Full Course Fee</option>
                                            <option value="Per Semester">Per Semester Fee</option>
                                            <option value="Per Month">Per Month Fee</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-body-secondary">Standard Fee (PKR)</label>
                                        <input type="number" id="standard_fee" name="standard_fee" class="form-control shadow-sm" placeholder="e.g. 50000" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="has_installments" name="has_installments" value="1">
                                        <label class="form-check-label fw-bold text-body" for="has_installments">Enable Installment Plan</label>
                                    </div>
                                </div>

                                <div id="installment_box" class="row mb-3 d-none p-2 rounded border bg-body">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-body-secondary">No. of Installments</label>
                                        <input type="number" id="no_of_installments" name="no_of_installments" class="form-control form-control-sm" value="3" min="2">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-body-secondary">Per Installment (PKR)</label>
                                        <input type="number" id="installment_amount" name="installment_amount" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label fw-bold text-body-secondary">Reg. Fee</label>
                                        <input type="number" name="registration_fee" class="form-control shadow-sm" value="1000">
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="form-label fw-bold text-body-secondary">Max Disc. (%)</label>
                                        <input type="number" id="discount_percentage" name="discount_percentage" class="form-control shadow-sm" placeholder="e.g. 10" min="0" max="100">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-body-secondary">Final Fee</label>
                                        <input type="number" id="final_fee" name="final_fee" class="form-control fw-bold text-success shadow-sm" readonly placeholder="Auto">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-body-secondary">Course Banner / Thumbnail</label>
                            <input type="file" name="image" class="form-control shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-body-secondary">Course Description</label>
                            <textarea name="description" id="description" class="form-control shadow-sm" rows="3" placeholder="Short summary of course..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-body-secondary">Objectives & Curriculum (Rich Text)</label>
                            <textarea name="objectives" id="objectivesEditor" class="form-control shadow-sm" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-body-secondary">Eligibility Criteria</label>
                            <textarea name="eligibility" id="eligibility" class="form-control shadow-sm" rows="2" placeholder="e.g. Intermediate / Matriculation..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-gold-action w-100 fw-bold py-2 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Academic Course
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Active Courses Table -->
        <div class="col-lg-6">
            <div class="card panel-card border-0">
                <div class="card-header panel-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-list text-warning"></i> Active Courses List
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive rounded-bottom-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-uppercase fs-8 table-head-theme">
                                    <th class="ps-3">Code</th>
                                    <th>Title</th>
                                    <th>Duration</th>
                                    <th>Fee Details</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge badge-gold font-monospace">{{ $course->course_code }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold course-title-text">{{ $course->course_name }}</div>
                                        @if($course->has_installments)
                                            <span class="badge bg-info-subtle text-info border fs-8">Installments Available</span>
                                        @endif
                                    </td>
                                    <td class="small text-body-secondary">{{ $course->duration }} {{ $course->duration_type }}</td>
                                    <td>
                                        <div class="fw-bold text-success">Rs. {{ number_format($course->standard_fee) }}</div>
                                        <small class="text-body-secondary d-block fs-8">{{ $course->fee_type ?? 'Total Fee' }}</small>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-outline-primary fw-bold px-3" style="border-radius: 8px;">
                                            <i class="fa-solid fa-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No academic courses created yet.</td>
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

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    if (document.getElementById('objectivesEditor')) {
        CKEDITOR.replace('objectivesEditor');
    }

    // Auto Sync CKEditor data before Form Submission
    document.getElementById('courseForm').addEventListener('submit', function() {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    });

    // Auto Generate Course Code from Name
    document.getElementById('course_name').addEventListener('keyup', function() {
        let name = this.value.trim();
        if(name.length > 0) {
            let words = name.split(' ');
            let code = '';
            if(words.length === 1) {
                code = words[0].substring(0, 4).toUpperCase();
            } else {
                words.forEach(word => {
                    if(word.length > 0) code += word[0].toUpperCase();
                });
            }
            document.getElementById('course_code').value = code;
        } else {
            document.getElementById('course_code').value = '';
        }
    });

    // Installments Toggle & Fee Calculation
    const hasInstallments = document.getElementById('has_installments');
    const installmentBox = document.getElementById('installment_box');
    const standardFeeInput = document.getElementById('standard_fee');
    const noOfInstallmentsInput = document.getElementById('no_of_installments');
    const installmentAmountInput = document.getElementById('installment_amount');
    const discountPercentageInput = document.getElementById('discount_percentage');
    const finalFeeInput = document.getElementById('final_fee');

    if(hasInstallments) {
        hasInstallments.addEventListener('change', function() {
            if(this.checked) {
                installmentBox.classList.remove('d-none');
                calculateFee();
            } else {
                installmentBox.classList.add('d-none');
            }
        });
    }

    function calculateFee() {
        let fee = parseFloat(standardFeeInput.value) || 0;
        let discount = parseFloat(discountPercentageInput.value) || 0;

        let finalFee = fee - (fee * (discount / 100));
        finalFeeInput.value = Math.round(finalFee);

        if(hasInstallments && hasInstallments.checked) {
            let installments = parseInt(noOfInstallmentsInput.value) || 1;
            let perInstallment = finalFee / installments;
            installmentAmountInput.value = Math.round(perInstallment);
        }
    }

    if(standardFeeInput) standardFeeInput.addEventListener('input', calculateFee);
    if(discountPercentageInput) discountPercentageInput.addEventListener('input', calculateFee);
    if(noOfInstallmentsInput) noOfInstallmentsInput.addEventListener('input', calculateFee);
</script>
@endsection