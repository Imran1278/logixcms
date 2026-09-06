@extends('layouts.app')

@section('page_title', 'Create New Academic Batch')

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

    .batch-card {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .batch-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 18px 24px;
        border-bottom: 2px solid var(--color-gold);
    }

    .section-title {
        color: var(--text-primary);
        font-weight: 700;
        border-bottom: 2px solid var(--panel-border);
        padding-bottom: 8px;
    }

    .subtle-box {
        background-color: var(--box-subtle-bg);
        border: 1px solid var(--panel-border);
        border-radius: 12px;
    }

    .form-control, .form-select {
        background-color: var(--input-bg);
        border-color: var(--input-border);
        color: var(--input-text);
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--input-bg);
        color: var(--input-text);
        border-color: var(--color-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.25);
    }

    .form-control[readonly] {
        background-color: var(--box-subtle-bg);
        color: var(--text-primary);
    }

    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 12px;
        padding: 12px 24px;
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
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card batch-card border-0 mb-4">
                <div class="card-header batch-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-layer-group text-warning fs-5"></i>
                        <h5 class="mb-0 fw-bold text-white">Auto-Batch Generator & Academic Setup</h5>
                    </div>
                    <a href="{{ route('batches.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Directory
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('batches.store') }}" method="POST">
                        @csrf
                        
                        <!-- 1. Program Selection -->
                        <h6 class="section-title mb-3"><i class="fa-solid fa-book text-warning me-2"></i> 1. Academic Program Selection</h6>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-theme-muted">Select Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="">-- Choose Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            data-code="{{ $course->course_code ?? $course->code ?? 'COURSE' }}"
                                            data-duration="{{ $course->duration ?? 3 }}"
                                            data-duration-type="{{ $course->duration_type ?? 'Months' }}">
                                        {{ $course->course_name ?? $course->title }} ({{ $course->course_code ?? $course->code ?? 'CODE' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Batch Numbering & Auto Generation -->
                        <div class="row mb-4 subtle-box p-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-theme-muted">Batch Sequence Number <span class="text-danger">*</span></label>
                                <input type="number" name="batch_sequence_no" id="batch_sequence_no" class="form-control shadow-sm" placeholder="e.g. 01" value="1" min="1" required>
                                <small class="text-theme-muted">Auto-generated sequence number for this batch.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-theme-muted">Generated Batch Code</label>
                                <input type="text" name="batch_code" id="generated_batch_code" class="form-control fw-bold text-primary shadow-sm" readonly placeholder="Select course first">
                            </div>
                        </div>

                        <!-- 3. Academic Requirements Checklist -->
                        <h6 class="section-title mb-3 mt-4"><i class="fa-solid fa-shield-check text-warning me-2"></i> 2. Academic & Administrative Verification</h6>
                        <div class="row g-3 mb-4 p-3 subtle-box">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hec_noc" checked required>
                                    <label class="form-check-label fw-semibold text-theme-primary" for="hec_noc">
                                        HEC / NOC Approval & Program Accreditation Verified
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="faculty_allocated" checked required>
                                    <label class="form-check-label fw-semibold text-theme-primary" for="faculty_allocated">
                                        Faculty, Syllabus & Lab Space Allocated
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Schedule, Timings & Capacity -->
                        <h6 class="section-title mb-3 mt-4"><i class="fa-regular fa-clock text-warning me-2"></i> 3. Schedule & Capacity</h6>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-theme-muted">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-theme-muted">Auto Calculated End Date</label>
                                <input type="date" name="end_date" id="end_date_preview" class="form-control shadow-sm" readonly>
                            </div>
                        </div>

                        <!-- Timing Slots UI -->
                        <div class="mb-3">
                            <label class="form-label fw-bold d-block text-theme-muted">Available Timing Slots</label>
                            <div class="p-3 subtle-box">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Morning (08:00 AM - 11:00 AM)" id="slot1">
                                    <label class="form-check-label small text-theme-primary" for="slot1">Morning (08:00 - 11:00 AM)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Afternoon (11:30 AM - 02:30 PM)" id="slot2">
                                    <label class="form-check-label small text-theme-primary" for="slot2">Afternoon (11:30 - 02:30 PM)</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="timing_slots[]" value="Evening (03:00 PM - 06:00 PM)" id="slot3">
                                    <label class="form-check-label small text-theme-primary" for="slot3">Evening (03:00 - 06:00 PM)</label>
                                </div>
                                <div class="mt-2">
                                    <input type="text" name="custom_timing" class="form-control form-control-sm" placeholder="Or custom timing (e.g. Sat-Sun 10 AM - 2 PM)">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-theme-muted">Assigned Lab / Room</label>
                                <input type="text" name="assigned_lab" class="form-control shadow-sm" placeholder="e.g. Lab 2 / Hall A">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-theme-muted">Student Capacity Seat Limit <span class="text-danger">*</span></label>
                                <input type="number" name="capacity" class="form-control shadow-sm" value="30" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gold-action w-100 fs-5 mt-2 shadow-sm">
                            <i class="fa-solid fa-circle-check me-2"></i> Authorize & Create Batch
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let courseDuration = 3;
    let durationType = 'Months';

    function generateBatchCode() {
        let selectedOption = $('#course_id').find('option:selected');
        let courseCode = selectedOption.data('code');
        let seqNo = $('#batch_sequence_no').val();

        if (courseCode && seqNo) {
            let paddedSeq = String(seqNo).padStart(2, '0');
            let generatedCode = courseCode.toUpperCase() + '-B' + paddedSeq;
            $('#generated_batch_code').val(generatedCode);
        } else {
            $('#generated_batch_code').val('');
        }
    }

    $('#course_id').change(function() {
        let courseId = $(this).val();
        let selectedOption = $(this).find('option:selected');

        if (courseId) {
            courseDuration = selectedOption.data('duration') || 3;
            durationType = selectedOption.data('duration-type') || 'Months';
            
            $.ajax({
                url: '/batches/get-next-number/' + courseId,
                type: 'GET',
                success: function(response) {
                    if (response.next_sequence) {
                        $('#batch_sequence_no').val(response.next_sequence);
                    }
                    if (response.suggested_batch_number) {
                        $('#generated_batch_code').val(response.suggested_batch_number);
                    } else {
                        generateBatchCode();
                    }
                    calculateEndDate();
                },
                error: function() {
                    generateBatchCode();
                    calculateEndDate();
                }
            });
        } else {
            $('#generated_batch_code').val('');
        }
    });

    $('#batch_sequence_no').on('input keyup change', function() {
        generateBatchCode();
    });

    $('#start_date').change(function() {
        calculateEndDate();
    });

    function calculateEndDate() {
        let startVal = $('#start_date').val();
        if (!startVal) return;

        let start = new Date(startVal);
        let duration = parseInt(courseDuration) || 1;

        if (durationType === 'Days') {
            start.setDate(start.getDate() + duration);
        } else if (durationType === 'Weeks') {
            start.setDate(start.getDate() + (duration * 7));
        } else if (durationType === 'Years') {
            start.setFullYear(start.getFullYear() + duration);
        } else { // Months
            start.setMonth(start.getMonth() + duration);
        }

        let day = ("0" + start.getDate()).slice(-2);
        let month = ("0" + (start.getMonth() + 1)).slice(-2);
        let endFormatted = start.getFullYear() + "-" + month + "-" + day;
        
        $('#end_date_preview').val(endFormatted);
    }

    if($('#start_date').val()) {
        calculateEndDate();
    }
});
</script>
@endpush