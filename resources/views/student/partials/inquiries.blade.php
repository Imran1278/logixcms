{{-- File Path: resources/views/student/partials/inquiries.blade.php --}}
@php
    $currentUser    = auth()->user();
    $studentObj     = $student ?? ($currentUser->student ?? null);
    $studentMobile  = $studentObj->mobile_number ?? $studentObj->phone ?? $currentUser->phone ?? '';
    $studentWhatsapp= $studentObj->whatsapp_number ?? $studentMobile;
    $studentFather  = $studentObj->father_mobile ?? '';
    $studentCnicVal = $studentObj->cnic ?? $currentUser->cnic ?? '';
    $selectedCourse = old('course_id', $admission->course_id ?? '');
    
    // Fallback for courses list
    $cList = $coursesList ?? $courses ?? $availableCourses ?? collect();
    
    // Fetch user's submitted inquiries
    $userInquiries = $userInquiries ?? (\App\Models\Inquiry::with('course')
        ->where('email', $currentUser->email ?? '')
        ->orWhere('mobile_number', $studentMobile)
        ->orderBy('id', 'desc')
        ->get());
@endphp

<style>
    .inquiry-card-header {
        border-bottom: 2px solid var(--panel-border, #f1f5f9);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-label-custom {
        font-size: 0.76rem;
        font-weight: 800;
        color: var(--text-main, #0f172a);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }

    .input-group-acad .input-group-text {
        background-color: var(--box-subtle-bg, #f8fafc);
        border: 1px solid var(--panel-border, #cbd5e1);
        border-right: none;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: var(--color-gold, #c8a251);
    }

    .form-control-acad, .form-select-acad {
        border: 1px solid var(--panel-border, #cbd5e1);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.88rem;
        color: var(--text-main, #1e293b);
        background-color: var(--box-bg, #ffffff);
        transition: all 0.25s ease;
    }

    .input-group-acad .form-control-acad {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-control-acad:focus, .form-select-acad:focus {
        border-color: var(--color-gold, #c8a251);
        box-shadow: 0 0 0 3px rgba(200, 162, 81, 0.18);
        outline: none;
    }

    .btn-gold-action {
        background: linear-gradient(135deg, var(--color-gold, #c8a251) 0%, #b38e3e 100%);
        color: #ffffff;
        font-weight: 800;
        border: none;
        border-radius: 10px;
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background: linear-gradient(135deg, #b38e3e 0%, #9a782e 100%);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(200, 162, 81, 0.35);
    }

    .social-btn-pill {
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 10px;
        transition: transform 0.2s ease;
    }

    .social-btn-pill:hover {
        transform: translateY(-2px);
    }

    .table-acad {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-acad thead th {
        background-color: var(--navy-primary, #0a2540);
        color: #ffffff;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border: none;
    }

    .table-acad tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--panel-border, #f1f5f9);
        font-size: 0.85rem;
    }

    .section-title-badge {
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
    }

    .reply-box-admin {
        background: #f0f7ff;
        border: 1px solid #bae6fd !important;
        border-radius: 10px;
        padding: 10px 12px;
    }

    .reply-box-student {
        background: #fbf7ee;
        border: 1px solid #fef08a !important;
        border-radius: 10px;
        padding: 10px 12px;
    }
</style>

<!-- Submit Inquiry Form Card -->
<div class="react-card mb-4" id="inquiry-form-section">
    <div class="inquiry-card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h5 class="section-title-badge text-theme-primary mb-1">
                <i class="fa-solid fa-headset text-warning me-2"></i>SUBMIT INQUIRY / HELP DESK
            </h5>
            <p class="text-theme-muted small mb-0">Have an academic query or issue? Follow our channels and submit your request.</p>
        </div>
        <span class="badge bg-dark text-warning border border-warning px-3 py-2 fw-bold fs-8 rounded-pill shadow-sm">
            <i class="fa-solid fa-bolt me-1"></i> Quick Support
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('student.inquiries.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <!-- Mobile Number -->
            <div class="col-md-4">
                <label for="mobile_number" class="form-label-custom">
                    Mobile Number <span class="text-danger">*</span>
                </label>
                <div class="input-group input-group-acad">
                    <span class="input-group-text"><i class="fa-solid fa-mobile-screen"></i></span>
                    <input type="text" name="mobile_number" id="mobile_number" 
                           class="form-control form-control-acad @error('mobile_number') is-invalid @enderror" 
                           value="{{ old('mobile_number', $studentMobile) }}" 
                           placeholder="03001234567" required>
                </div>
                @error('mobile_number')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- WhatsApp Number -->
            <div class="col-md-4">
                <label for="whatsapp_number" class="form-label-custom">
                    WhatsApp Number
                </label>
                <div class="input-group input-group-acad">
                    <span class="input-group-text"><i class="fa-brands fa-whatsapp text-success"></i></span>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" 
                           class="form-control form-control-acad @error('whatsapp_number') is-invalid @enderror" 
                           value="{{ old('whatsapp_number', $studentWhatsapp) }}" 
                           placeholder="03001234567">
                </div>
                @error('whatsapp_number')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Guardian Mobile -->
            <div class="col-md-4">
                <label for="father_mobile" class="form-label-custom">
                    Guardian Mobile
                </label>
                <div class="input-group input-group-acad">
                    <span class="input-group-text"><i class="fa-solid fa-phone-volume"></i></span>
                    <input type="text" name="father_mobile" id="father_mobile" 
                           class="form-control form-control-acad @error('father_mobile') is-invalid @enderror" 
                           value="{{ old('father_mobile', $studentFather) }}" 
                           placeholder="03001234567">
                </div>
                @error('father_mobile')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- CNIC Number -->
            <div class="col-md-4">
                <label for="cnic" class="form-label-custom">
                    CNIC / B-Form Number
                </label>
                <div class="input-group input-group-acad">
                    <span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
                    <input type="text" name="cnic" id="cnic" 
                           class="form-control form-control-acad @error('cnic') is-invalid @enderror" 
                           value="{{ old('cnic', $studentCnicVal) }}" 
                           placeholder="38403-XXXXXXX-X">
                </div>
                @error('cnic')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Select Course -->
            <div class="col-md-4">
                <label for="course_id" class="form-label-custom">
                    Relevant Course (Optional)
                </label>
                <select name="course_id" id="course_id" class="form-select form-select-acad @error('course_id') is-invalid @enderror">
                    <option value="">-- Select Relevant Course --</option>
                    @foreach($cList as $courseItem)
                        @php
                            $cItemTitle = $courseItem->course_name ?? $courseItem->title ?? 'Course #'.$courseItem->id;
                            $cItemCode  = $courseItem->course_code ?? $courseItem->code ?? 'LC';
                        @endphp
                        <option value="{{ $courseItem->id }}" {{ $selectedCourse == $courseItem->id ? 'selected' : '' }}>
                            {{ $cItemTitle }} ({{ $cItemCode }})
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Social Media Mandatory Field -->
            <div class="col-md-4">
                <label for="followed_social_media" class="form-label-custom">
                    Followed Social Media? <span class="text-danger">*</span>
                </label>
                <select name="followed_social_media" id="followed_social_media" class="form-select form-select-acad @error('followed_social_media') is-invalid @enderror" required>
                    <option value="">-- Follow & Select Yes --</option>
                    <option value="1" selected>Yes, I Have Followed</option>
                </select>
                
                <div class="mt-2 d-flex align-items-center gap-1 flex-wrap">
                    <span class="fs-8 text-theme-muted fw-bold me-1">Links:</span>
                    <a href="https://www.facebook.com/LOGIXCollege/" target="_blank" class="btn btn-sm btn-outline-primary social-btn-pill"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/logix.college.2000" target="_blank" class="btn btn-sm btn-outline-danger social-btn-pill"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://twitter.com/logixcollege" target="_blank" class="btn btn-sm btn-outline-info social-btn-pill"><i class="fa-brands fa-x"></i></a>
                    <a href="https://www.linkedin.com/in/LogixCollege" target="_blank" class="btn btn-sm btn-outline-primary social-btn-pill"><i class="fa-brands fa-linkedin"></i></a>
                </div>
                @error('followed_social_media')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Message / Remarks -->
            <div class="col-12">
                <label for="remarks" class="form-label-custom">
                    Inquiry Details / Remarks <span class="text-danger">*</span>
                </label>
                <textarea name="remarks" id="remarks" rows="3" 
                          class="form-control form-control-acad @error('remarks') is-invalid @enderror" 
                          placeholder="Type your question, request, or issue details here..." required>{{ old('remarks') }}</textarea>
                @error('remarks')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="col-12 text-end pt-2">
                <button type="submit" class="btn btn-gold-action px-4 py-2 shadow-sm">
                    <i class="fa-solid fa-paper-plane me-1"></i> Submit Inquiry
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Live Student Inquiries History List Card -->
<div class="react-card p-0 overflow-hidden border-0 shadow-sm mt-4">
    <div class="d-flex align-items-center justify-content-between p-3" style="background: linear-gradient(135deg, #09223d 0%, #041324 100%); color: #ffffff;">
        <h6 class="fw-bold mb-0 fs-7 text-uppercase letter-spacing-1">
            <i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i> Submitted Inquiries History
        </h6>
        <span class="badge bg-warning text-dark fw-bold fs-8 rounded-pill">Total: {{ count($userInquiries) }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-acad align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-3">Date</th>
                    <th>Course</th>
                    <th>Conversation History</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userInquiries as $inq)
                    <tr>
                        <td class="ps-3 fw-bold small text-theme-primary align-top pt-3">
                            {{ \Carbon\Carbon::parse($inq->inquiry_date ?? $inq->created_at)->format('d M, Y') }}
                        </td>
                        <td class="align-top pt-3">
                            <span class="badge bg-body-tertiary text-theme-primary border border-theme fw-bold fs-8">
                                {{ $inq->course->course_name ?? $inq->course->title ?? 'General Inquiry' }}
                            </span>
                        </td>
                        <td class="align-top pt-3" style="min-width: 280px;">
                            <!-- Student Query -->
                            <div class="small fw-semibold text-theme-primary p-2 bg-body-tertiary rounded border border-theme mb-2">
                                <strong>My Query:</strong> {{ $inq->remarks ?? $inq->message }}
                            </div>

                            <!-- Admin Response Box -->
                            @if(!empty($inq->admin_reply))
                                <div class="reply-box-admin mb-2">
                                    <div class="small text-primary fw-bold mb-1">
                                        <i class="fa-solid fa-user-shield me-1"></i> Admin Response:
                                    </div>
                                    <div class="small text-dark">{{ $inq->admin_reply }}</div>
                                    @if(!empty($inq->replied_at))
                                        <small class="text-muted fs-8 d-block mt-1">
                                            <i class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse($inq->replied_at)->format('d M, Y h:i A') }}
                                        </small>
                                    @endif
                                </div>

                                <!-- Student Follow-up Reply Box or Form -->
                                @if(!empty($inq->student_reply))
                                    <div class="reply-box-student mb-2">
                                        <div class="small text-dark fw-bold mb-1"><i class="fa-solid fa-reply me-1 text-warning"></i> Your Reply:</div>
                                        <div class="small text-dark">{{ $inq->student_reply }}</div>
                                    </div>
                                @else
                                    <form action="{{ route('inquiries.studentReply', $inq->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="student_reply" class="form-control form-control-acad" placeholder="Write reply back to admin..." required>
                                            <button class="btn btn-gold-action px-3 fw-bold" type="submit">
                                                <i class="fa-solid fa-paper-plane me-1"></i> Reply
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 fs-8">
                                    <i class="fa-solid fa-hourglass-half me-1"></i> Awaiting Admin Reply
                                </span>
                            @endif
                        </td>
                        <td class="small align-top pt-3 text-theme-muted">
                            <i class="fa-solid fa-phone me-1 text-theme-muted"></i>{{ $inq->mobile_number }}
                        </td>
                        <td class="align-top pt-3">
                            <span class="badge 
                                @if(in_array(strtolower($inq->status ?? 'new'), ['new', 'pending'])) bg-info-subtle text-info border border-info
                                @elseif(in_array(strtolower($inq->status ?? ''), ['interested', 'converted'])) bg-success-subtle text-success border border-success
                                @else bg-warning-subtle text-warning border border-warning @endif px-2 py-1 fw-bold fs-8">
                                {{ ucfirst($inq->status ?? 'New') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-theme-muted small">No submitted inquiries recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>