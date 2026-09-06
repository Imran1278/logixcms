{{-- File Path: resources/views/student/partials/profile-form.blade.php --}}
@php
    $cList = $coursesList ?? $courses ?? $availableCourses ?? collect();
    $bList = $batchesList ?? $batches ?? $availableBatches ?? collect();
    
    // Logged in user & Admission record safety mapping
    $u = auth()->user();
    $adm = $admission ?? $u->admission ?? null;

    // CNIC priority logic (Admissions -> Users)
    $studentCnic = $studentCnic ?? $adm->cnic_bform ?? $u->cnic ?? 'N/A';
    $studentName = $studentName ?? $adm->student_name ?? $u->name ?? '';

    // Handle Education JSON safely
    $savedEdu = $savedEdu ?? $adm->education_details ?? $u->education_details ?? [];
    if (is_string($savedEdu)) { 
        $savedEdu = json_decode($savedEdu, true) ?? []; 
    }

    // Handle Experience JSON safely
    $savedExp = $savedExp ?? $adm->experience_details ?? $u->experience_details ?? [];
    if (is_string($savedExp)) { 
        $savedExp = json_decode($savedExp, true) ?? []; 
    }
@endphp

<style>
    /* Profile Partial Section Styling */
    .profile-card-header {
        border-bottom: 2px solid var(--panel-border, #f1f5f9);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .form-label-custom {
        font-size: 0.76rem;
        font-weight: 800;
        color: var(--text-muted, #64748b);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .form-control-acad, .form-select-acad {
        border: 1px solid var(--input-border, #cbd5e1);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--input-text, #1e293b);
        background-color: var(--input-bg, #ffffff);
        transition: all 0.2s ease;
    }

    .form-control-acad:focus, .form-select-acad:focus {
        border-color: var(--color-gold, #c8a251);
        box-shadow: 0 0 0 4px rgba(200, 162, 81, 0.18);
        outline: none;
        background-color: var(--input-bg, #ffffff);
        color: var(--input-text, #1e293b);
    }

    .form-control-acad:disabled, .form-control-acad[readonly] {
        background-color: var(--box-subtle-bg, #f8fafc);
        border-color: var(--panel-border, #e2e8f0);
        color: var(--text-muted, #64748b);
    }

    .dynamic-row-card {
        background: var(--box-subtle-bg, #f8fafc);
        border: 1px solid var(--panel-border, #e2e8f0);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }

    .dynamic-row-card:hover {
        border-color: rgba(200, 162, 81, 0.4);
    }

    .btn-gold-action {
        background: linear-gradient(135deg, var(--color-gold, #c8a251) 0%, #b38e3e 100%);
        color: #ffffff;
        font-weight: 800;
        border: none;
        border-radius: 12px;
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background: linear-gradient(135deg, #b38e3e 0%, #9a782e 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(200, 162, 81, 0.35);
    }

    .section-title-badge {
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
</style>

<div class="react-card mb-4" id="profile-section">
    <!-- Header Strip -->
    <div class="profile-card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h5 class="section-title-badge text-theme-primary mb-1">
                <i class="fa-solid fa-user-gear me-2 text-warning"></i>COMPLETE & UPDATE YOUR PROFILE
            </h5>
            <p class="text-theme-muted small mb-0">Ensure all details strictly match your official educational documents.</p>
        </div>
        <div class="badge bg-body-tertiary text-theme-primary border border-theme px-3 py-2 fw-bold fs-8 rounded-pill shadow-sm">
            <i class="fa-solid fa-id-card me-1 text-warning"></i> CNIC: {{ $studentCnic }}
        </div>
    </div>

    <!-- Main Update Form -->
    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            
            <!-- Personal Information -->
            <div class="col-md-6">
                <label class="form-label-custom">Student Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-control-acad" value="{{ old('name', $studentName) }}" required placeholder="Enter full name">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Father Name <span class="text-danger">*</span></label>
                <input type="text" name="father_name" class="form-control form-control-acad" value="{{ old('father_name', $adm->father_name ?? $u->father_name ?? '') }}" required placeholder="Enter Father Name">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">CNIC / B-Form Number</label>
                <input type="text" class="form-control form-control-acad" value="{{ $studentCnic }}" disabled readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Mobile Contact <span class="text-danger">*</span></label>
                <input type="text" name="mobile_contact" class="form-control form-control-acad" value="{{ old('mobile_contact', $adm->mobile_number ?? $u->phone ?? '') }}" required placeholder="03XXXXXXXXX">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">WhatsApp Contact</label>
                <input type="text" name="whatsapp_contact" class="form-control form-control-acad" value="{{ old('whatsapp_contact', $adm->whatsapp_number ?? '') }}" placeholder="03XXXXXXXXX">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Gender</label>
                <select name="gender" class="form-select form-select-acad">
                    <option value="Male" {{ old('gender', $adm->gender ?? $u->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $adm->gender ?? $u->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $adm->gender ?? $u->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Blood Group</label>
                <select name="blood_group" class="form-select form-select-acad">
                    <option value="">Select Blood Group</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                        <option value="{{ $bg }}" {{ old('blood_group', $adm->blood_group ?? $u->blood_group ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Guardian Name</label>
                <input type="text" name="guardian_name" class="form-control form-control-acad" value="{{ old('guardian_name', $adm->guardian_name ?? $u->guardian_name ?? '') }}" placeholder="e.g. Guardian Name">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Guardian Contact</label>
                <input type="text" name="guardian_contact" class="form-control form-control-acad" value="{{ old('guardian_contact', $adm->guardian_mobile ?? $u->guardian_contact ?? '') }}" placeholder="03XXXXXXXXX">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Last Qualification</label>
                <input type="text" name="last_qualification" class="form-control form-control-acad" value="{{ old('last_qualification', $adm->last_qualification ?? $u->qualification ?? '') }}" placeholder="e.g. Matric / Intermediate / BS">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Preferred Shift</label>
                <select name="preferred_shift" class="form-select form-select-acad">
                    <option value="Morning" {{ old('preferred_shift', $adm->preferred_shift ?? '') == 'Morning' ? 'selected' : '' }}>Morning</option>
                    <option value="Evening" {{ old('preferred_shift', $adm->preferred_shift ?? '') == 'Evening' ? 'selected' : '' }}>Evening</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Select Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select form-select-acad" required>
                    <option value="">-- Select Academic Course --</option>
                    
                    {{-- Priority 1: Controller's availableCourses, Priority 2: fallback --}}
                    @php
                        $allCourses = $availableCourses ?? $coursesList ?? $courses ?? collect();
                    @endphp
            
                    @foreach($allCourses as $course)
                        @php
                            // Handle Database Schema Columns (course_name & course_code)
                            $courseTitle = $course->course_name ?? $course->title ?? 'Course #'.$course->id;
                            $courseCode  = $course->course_code ?? $course->code ?? 'LC';
                            
                            // Active Selection
                            $selectedCourseId = old('course_id', $adm->course_id ?? $u->course_id ?? '');
                        @endphp
            
                        <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                            {{ $courseTitle }} ({{ $courseCode }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Select Preferred Batch <span class="text-danger">*</span></label>
                <select name="batch_id" class="form-select form-select-acad" required>
                    <option value="">-- Choose Active Batch --</option>
                    @foreach($bList as $batch)
                        <option value="{{ $batch->id }}" {{ old('batch_id', $adm->batch_id ?? $u->batch_id ?? '') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->batch_name ?? $batch->batch_number }} ({{ $batch->timing ?? 'Standard Timing' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Residential Address</label>
                <textarea name="residential_address" class="form-control form-control-acad" rows="2" placeholder="Enter complete residential address">{{ old('residential_address', $adm->home_address ?? $u->address ?? $u->residential_address ?? '') }}</textarea>
            </div>

            <!-- Dynamic Education Section -->
            <div class="col-12 mt-4 pt-3 border-top border-theme">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-graduation-cap me-2 text-warning"></i> Academic Record
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-theme fw-bold rounded-pill px-3" id="add-education-btn">
                        <i class="fa-solid fa-plus me-1 text-warning"></i> Add Degree
                    </button>
                </div>
                
                <div id="education-wrapper">
                    @forelse($savedEdu as $index => $edu)
                        @php
                            $deg = $edu['degree_name'] ?? $edu['degree'] ?? '';
                            $inst = $edu['institute'] ?? $edu['board'] ?? '';
                            $tot = $edu['total_marks'] ?? '';
                            $obt = $edu['obtained_marks'] ?? '';
                            $pct = $edu['percentage'] ?? (($tot > 0 && $obt >= 0) ? number_format(($obt / $tot) * 100, 2) . '%' : '');
                        @endphp
                        <div class="row g-3 edu-row dynamic-row-card position-relative">
                            <div class="col-md-3">
                                <label class="form-label-custom">Degree Name</label>
                                <input type="text" name="education[{{ $index }}][degree_name]" class="form-control form-control-acad" value="{{ $deg }}" required placeholder="e.g. Matric / BS">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Institute / Board</label>
                                <input type="text" name="education[{{ $index }}][institute]" class="form-control form-control-acad" value="{{ $inst }}" required placeholder="e.g. BISE / UOS">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-custom">Total Marks</label>
                                <input type="number" step="0.01" name="education[{{ $index }}][total_marks]" class="form-control form-control-acad total-marks" value="{{ $tot }}" required placeholder="1100">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-custom">Obtained</label>
                                <input type="number" step="0.01" name="education[{{ $index }}][obtained_marks]" class="form-control form-control-acad obtained-marks" value="{{ $obt }}" required placeholder="950">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-custom">Percentage</label>
                                <div class="d-flex gap-2">
                                    <input type="text" name="education[{{ $index }}][percentage]" class="form-control form-control-acad percentage-val fw-bold text-primary" value="{{ $pct }}" readonly placeholder="%">
                                    @if(!$loop->first)
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove"><i class="fa-solid fa-trash"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row g-3 edu-row dynamic-row-card position-relative">
                            <div class="col-md-3"><label class="form-label-custom">Degree Name</label><input type="text" name="education[0][degree_name]" class="form-control form-control-acad" placeholder="e.g. Matric / BS"></div>
                            <div class="col-md-3"><label class="form-label-custom">Institute / Board</label><input type="text" name="education[0][institute]" class="form-control form-control-acad" placeholder="e.g. BISE / UOS"></div>
                            <div class="col-md-2"><label class="form-label-custom">Total Marks</label><input type="number" step="0.01" name="education[0][total_marks]" class="form-control form-control-acad total-marks" placeholder="1100"></div>
                            <div class="col-md-2"><label class="form-label-custom">Obtained</label><input type="number" step="0.01" name="education[0][obtained_marks]" class="form-control form-control-acad obtained-marks" placeholder="950"></div>
                            <div class="col-md-2"><label class="form-label-custom">Percentage</label><input type="text" name="education[0][percentage]" class="form-control form-control-acad percentage-val fw-bold text-primary" placeholder="%" readonly></div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Dynamic Experience Section -->
            <div class="col-12 mt-4 pt-3 border-top border-theme">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-briefcase me-2 text-warning"></i> Work Experience (Optional)
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-theme fw-bold rounded-pill px-3" id="add-experience-btn">
                        <i class="fa-solid fa-plus me-1 text-warning"></i> Add Experience
                    </button>
                </div>
                
                <div id="experience-wrapper">
                    @forelse($savedExp as $index => $exp)
                        <div class="row g-3 exp-row dynamic-row-card align-items-end">
                            <div class="col-md-4"><label class="form-label-custom">Job Title</label><input type="text" name="experience[{{ $index }}][title]" class="form-control form-control-acad" value="{{ $exp['title'] ?? '' }}" placeholder="e.g. Web Developer"></div>
                            <div class="col-md-3"><label class="form-label-custom">Company</label><input type="text" name="experience[{{ $index }}][company]" class="form-control form-control-acad" value="{{ $exp['company'] ?? '' }}" placeholder="e.g. Tech Corp"></div>
                            <div class="col-md-2"><label class="form-label-custom">Start Date</label><input type="date" name="experience[{{ $index }}][start_date]" class="form-control form-control-acad" value="{{ $exp['start_date'] ?? '' }}"></div>
                            <div class="col-md-2"><label class="form-label-custom">End Date</label><input type="date" name="experience[{{ $index }}][end_date]" class="form-control form-control-acad" value="{{ $exp['end_date'] ?? '' }}"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-row w-100" title="Remove"><i class="fa-solid fa-trash"></i></button></div>
                        </div>
                    @empty
                        <div class="row g-3 exp-row dynamic-row-card align-items-end">
                            <div class="col-md-4"><label class="form-label-custom">Job Title</label><input type="text" name="experience[0][title]" class="form-control form-control-acad" placeholder="e.g. Web Developer"></div>
                            <div class="col-md-3"><label class="form-label-custom">Company</label><input type="text" name="experience[0][company]" class="form-control form-control-acad" placeholder="e.g. Tech Corp"></div>
                            <div class="col-md-2"><label class="form-label-custom">Start Date</label><input type="date" name="experience[0][start_date]" class="form-control form-control-acad"></div>
                            <div class="col-md-2"><label class="form-label-custom">End Date</label><input type="date" name="experience[0][end_date]" class="form-control form-control-acad"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-row w-100" title="Remove"><i class="fa-solid fa-trash"></i></button></div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Password & Security Section -->
            <div class="col-md-6 mt-4">
                <label class="form-label-custom">Set New Password</label>
                <input type="password" name="password" class="form-control form-control-acad" placeholder="Leave blank if unchanged">
            </div>

            <div class="col-md-6 mt-4">
                <label class="form-label-custom">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-acad" placeholder="Re-enter password">
            </div>

            <div class="col-12 mt-3">
                <label class="form-label-custom">Update Profile Picture</label>
                <input type="file" name="picture" class="form-control form-control-acad" accept="image/*">
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-gold-action w-100 fs-6 py-3 shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> SAVE & UPDATE PROFILE
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Dynamic Rows & Percentage JS Engine -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let eduIndex = {{ count($savedEdu) > 0 ? count($savedEdu) : 1 }};
        let expIndex = {{ count($savedExp) > 0 ? count($savedExp) : 1 }};

        // Add Education Row
        document.getElementById('add-education-btn')?.addEventListener('click', function () {
            const wrapper = document.getElementById('education-wrapper');
            const newRow = document.createElement('div');
            newRow.className = 'row g-3 edu-row dynamic-row-card position-relative';
            newRow.innerHTML = `
                <div class="col-md-3"><label class="form-label-custom">Degree Name</label><input type="text" name="education[${eduIndex}][degree_name]" class="form-control form-control-acad" placeholder="e.g. Matric / BS" required></div>
                <div class="col-md-3"><label class="form-label-custom">Institute / Board</label><input type="text" name="education[${eduIndex}][institute]" class="form-control form-control-acad" placeholder="e.g. BISE / UOS" required></div>
                <div class="col-md-2"><label class="form-label-custom">Total Marks</label><input type="number" step="0.01" name="education[${eduIndex}][total_marks]" class="form-control form-control-acad total-marks" placeholder="1100" required></div>
                <div class="col-md-2"><label class="form-label-custom">Obtained</label><input type="number" step="0.01" name="education[${eduIndex}][obtained_marks]" class="form-control form-control-acad obtained-marks" placeholder="950" required></div>
                <div class="col-md-2">
                    <label class="form-label-custom">Percentage</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="education[${eduIndex}][percentage]" class="form-control form-control-acad percentage-val fw-bold text-primary" placeholder="%" readonly>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
            wrapper.appendChild(newRow);
            eduIndex++;
        });

        // Add Experience Row
        document.getElementById('add-experience-btn')?.addEventListener('click', function () {
            const wrapper = document.getElementById('experience-wrapper');
            const newRow = document.createElement('div');
            newRow.className = 'row g-3 exp-row dynamic-row-card align-items-end';
            newRow.innerHTML = `
                <div class="col-md-4"><label class="form-label-custom">Job Title</label><input type="text" name="experience[${expIndex}][title]" class="form-control form-control-acad" placeholder="e.g. Web Developer"></div>
                <div class="col-md-3"><label class="form-label-custom">Company</label><input type="text" name="experience[${expIndex}][company]" class="form-control form-control-acad" placeholder="e.g. Tech Corp"></div>
                <div class="col-md-2"><label class="form-label-custom">Start Date</label><input type="date" name="experience[${expIndex}][start_date]" class="form-control form-control-acad"></div>
                <div class="col-md-2"><label class="form-label-custom">End Date</label><input type="date" name="experience[${expIndex}][end_date]" class="form-control form-control-acad"></div>
                <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-row w-100" title="Remove"><i class="fa-solid fa-trash"></i></button></div>
            `;
            wrapper.appendChild(newRow);
            expIndex++;
        });

        // Dynamic Calculation and Row Removal Delegation
        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('total-marks') || e.target.classList.contains('obtained-marks')) {
                const row = e.target.closest('.edu-row');
                if (!row) return;

                const total = parseFloat(row.querySelector('.total-marks')?.value) || 0;
                const obtained = parseFloat(row.querySelector('.obtained-marks')?.value) || 0;
                const percentInput = row.querySelector('.percentage-val');

                if (percentInput) {
                    if (total > 0 && obtained >= 0) {
                        const calc = ((obtained / total) * 100).toFixed(2);
                        percentInput.value = calc + '%';
                    } else {
                        percentInput.value = '';
                    }
                }
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-row')) {
                const rowCard = e.target.closest('.dynamic-row-card');
                if (rowCard) {
                    rowCard.remove();
                }
            }
        });
    });
</script>