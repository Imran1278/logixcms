@extends('layouts.app')

@section('page_title', 'Lead CRM & Student Inquiries')

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
        --table-hover-bg: #F8FAFC;
        --subtle-badge-bg: #F1F5F9;
        --modal-bg: #FFFFFF;
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
        --table-hover-bg: #162842;
        --subtle-badge-bg: #162842;
        --modal-bg: #0F1B2D;
    }

    .crm-card {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .crm-card-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 18px 24px;
        border-bottom: 2px solid var(--color-gold);
    }

    .header-banner {
        background: var(--card-bg);
        border: 1px solid var(--panel-border);
    }

    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 50px;
        padding: 8px 18px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
    }

    .whatsapp-btn {
        background-color: rgba(37, 211, 102, 0.12);
        color: #25D366;
        border: 1px solid rgba(37, 211, 102, 0.3);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 3px 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .whatsapp-btn:hover {
        background-color: #25D366;
        color: #FFFFFF;
    }

    .source-badge {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 8px;
        border-radius: 6px;
        background-color: var(--subtle-badge-bg);
        color: var(--text-muted);
        border: 1px solid var(--panel-border);
    }

    .table-custom {
        color: var(--text-primary);
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--subtle-badge-bg);
        border-bottom: 1px solid var(--panel-border);
    }

    .table-custom thead th {
        color: var(--text-muted);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 16px;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid var(--panel-border);
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .modal-content {
        background-color: var(--modal-bg);
        border: 1px solid var(--panel-border);
    }

    .modal-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        border-bottom: 2px solid var(--color-gold);
    }

    .modal-footer {
        background-color: var(--box-subtle-bg);
        border-top: 1px solid var(--panel-border);
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

    .text-theme-primary {
        color: var(--text-primary) !important;
    }

    .text-theme-muted {
        color: var(--text-muted) !important;
    }

    .box-subtle {
        background-color: var(--box-subtle-bg);
        border: 1px solid var(--panel-border);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    <!-- Top Action Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 header-banner p-3 rounded-4 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 p-3 bg-dark text-warning border border-warning-subtle shadow-sm">
                <i class="fa-solid fa-headset fs-4"></i>
            </div>
            <div>
                <h4 class="fw-bold text-theme-primary mb-0">Lead CRM & Inquiries</h4>
                <p class="text-theme-muted small mb-0">Track prospect leads, manage student complaints, and send email replies directly.</p>
            </div>
        </div>
        <div>
            <button class="btn btn-gold-action shadow-sm" data-bs-toggle="modal" data-bs-target="#addInquiryModal">
                <i class="fa-solid fa-user-plus me-1"></i> Add New Inquiry
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="crm-card">
                <div class="crm-card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-6 d-flex align-items-center gap-2 text-white">
                        <i class="fa-solid fa-filter text-warning"></i> Inquiries & Student Complaints Pipeline
                    </span>
                    <span class="badge bg-warning text-dark font-monospace fw-bold px-3 py-2 rounded-3">
                        Total Leads: {{ count($inquiries ?? []) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="ps-4">Inquiry Date</th>
                                    <th>Student Info & Conversation</th>
                                    <th>Contact & WhatsApp</th>
                                    <th>Target Course</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inquiries as $inquiry)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-theme-primary">
                                                {{ !empty($inquiry->inquiry_date) ? \Carbon\Carbon::parse($inquiry->inquiry_date)->format('d M, Y') : (\Carbon\Carbon::parse($inquiry->created_at)->format('d M, Y')) }}
                                            </div>
                                            <span class="source-badge mt-1 d-inline-block">{{ $inquiry->source ?? 'Student Portal' }}</span>
                                        </td>
                                        <td style="max-width: 320px;">
                                            <div class="fw-bold text-theme-primary fs-6">
                                                {{ $inquiry->student_name ?? $inquiry->name ?? 'Student Inquiry' }}
                                            </div>
                                            @if(!empty($inquiry->email))
                                                <small class="text-theme-muted d-block"><i class="fa-regular fa-envelope me-1"></i>{{ $inquiry->email }}</small>
                                            @endif
                                            
                                            <!-- Student Message -->
                                            @if(!empty($inquiry->remarks))
                                                <div class="small text-theme-primary mt-1 p-2 rounded box-subtle">
                                                    <strong>Student:</strong> {{ $inquiry->remarks }}
                                                </div>
                                            @endif

                                            <!-- Admin Reply Display -->
                                            @if(!empty($inquiry->admin_reply))
                                                <div class="small text-primary mt-1 p-2 rounded border border-primary-subtle bg-primary-subtle">
                                                    <strong><i class="fa-solid fa-reply me-1"></i>Admin:</strong> {{ $inquiry->admin_reply }}
                                                </div>
                                            @endif

                                            <!-- Student Back Response -->
                                            @if(!empty($inquiry->student_reply))
                                                <div class="small text-warning-emphasis mt-1 p-2 rounded border border-warning-subtle bg-warning-subtle">
                                                    <strong><i class="fa-solid fa-comments me-1"></i>Student Reply:</strong> {{ $inquiry->student_reply }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-theme-primary"><i class="fa-solid fa-phone fs-8 text-theme-muted me-1"></i>{{ $inquiry->mobile_number ?? 'N/A' }}</div>
                                            @if(!empty($inquiry->mobile_number) || !empty($inquiry->whatsapp_number))
                                                @php
                                                    $rawNumber = !empty($inquiry->whatsapp_number) ? $inquiry->whatsapp_number : $inquiry->mobile_number;
                                                    $cleanWhatsApp = preg_replace('/[^0-9]/', '', $rawNumber);
                                                    if (str_starts_with($cleanWhatsApp, '0')) {
                                                        $cleanWhatsApp = '92' . substr($cleanWhatsApp, 1);
                                                    }
                                                @endphp
                                                <a href="https://wa.me/{{ $cleanWhatsApp }}?text=Hello%20{{ urlencode($inquiry->student_name ?? 'Student') }},%20we%20received%20your%20inquiry." 
                                                target="_blank" class="whatsapp-btn mt-1">
                                                    <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-theme-primary border px-2 py-1 fw-bold">
                                                {{ $inquiry->course->course_name ?? $inquiry->course->title ?? 'General Inquiry' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php $score = $inquiry->ai_lead_score ?? 'Warm'; @endphp
                                            @if($score == 'Hot')
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fa-solid fa-fire me-1"></i> Hot</span>
                                            @elseif($score == 'Warm')
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><i class="fa-solid fa-temperature-half me-1"></i> Warm</span>
                                            @else
                                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="fa-solid fa-snowflake me-1"></i> Cold</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if(in_array(strtolower($inquiry->status ?? 'new'), ['new', 'pending'])) bg-info-subtle text-info border
                                                @elseif(in_array(strtolower($inquiry->status ?? ''), ['interested', 'converted'])) bg-success-subtle text-success border
                                                @elseif(strtolower($inquiry->status ?? '') == 'follow-up required') bg-warning-subtle text-warning-emphasis border
                                                @else bg-danger-subtle text-danger border @endif px-2 py-1 fw-bold">
                                                {{ ucfirst($inquiry->status ?? 'New') }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary fw-semibold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $inquiry->id }}">
                                                    <i class="fa-solid fa-reply me-1"></i> Reply / Status
                                                </button>

                                                @if(($inquiry->status ?? '') != 'Converted')
                                                    @if(Route::has('admissions.create'))
                                                        <a href="{{ route('admissions.create', ['inquiry_id' => $inquiry->id]) }}" class="btn btn-sm btn-success fw-bold ms-1 rounded-pill px-3">
                                                            <i class="fa-solid fa-user-check me-1"></i> Convert
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="badge bg-success-subtle text-success border px-2 py-1 ms-2 rounded-pill"><i class="fa-solid fa-check me-1"></i> Admitted</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-theme-muted">
                                            <i class="fa-solid fa-headset fs-2 d-block mb-2 text-warning opacity-50"></i>
                                            No student inquiries recorded in system yet.
                                        </td>
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

<!-- Modal for Admin Reply & Update -->
@foreach($inquiries as $inquiry)
<div class="modal fade" id="editModal{{ $inquiry->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ Route::has('inquiries.update') ? route('inquiries.update', $inquiry->id) : (Route::has('inquiries.updateStatus') ? route('inquiries.updateStatus', $inquiry->id) : '#') }}" method="POST">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title fw-bold fs-6 text-white"><i class="fa-solid fa-reply text-warning me-2"></i>Respond to: {{ $inquiry->student_name ?? 'Student Inquiry' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3 p-3 box-subtle rounded">
                        <strong class="d-block text-theme-primary mb-1">Student's Initial Query:</strong>
                        <span class="text-theme-muted small">{{ $inquiry->remarks ?? 'No remarks provided.' }}</span>
                    </div>

                    @if(!empty($inquiry->student_reply))
                    <div class="mb-3 p-3 bg-warning-subtle rounded border border-warning">
                        <strong class="d-block text-dark mb-1"><i class="fa-solid fa-comments me-1"></i> Student's Follow-up Response:</strong>
                        <span class="text-dark small">{{ $inquiry->student_reply }}</span>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-theme-primary"><i class="fa-solid fa-paper-plane text-warning me-1"></i> Admin Answer / Email Reply</label>
                        <textarea name="admin_reply" class="form-control" rows="3" placeholder="Type your response here... This will be sent directly to student's email">{{ $inquiry->admin_reply }}</textarea>
                        <small class="text-theme-muted fs-8">Note: Leaving an answer here sends an instant email notification to {{ $inquiry->email ?? 'student email' }}.</small>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">Lead Status</label>
                            <select name="status" class="form-select">
                                <option value="New" {{ in_array(strtolower($inquiry->status ?? ''), ['new', 'pending']) ? 'selected' : '' }}>New</option>
                                <option value="Contacted" {{ $inquiry->status == 'Contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="Follow-up Required" {{ $inquiry->status == 'Follow-up Required' ? 'selected' : '' }}>Follow-up Required</option>
                                <option value="Interested" {{ $inquiry->status == 'Interested' ? 'selected' : '' }}>Interested</option>
                                <option value="Converted" {{ $inquiry->status == 'Converted' ? 'selected' : '' }}>Converted</option>
                                <option value="Not Interested" {{ $inquiry->status == 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">Priority</label>
                            @php $currentScore = $inquiry->ai_lead_score ?? 'Warm'; @endphp
                            <select name="lead_score" class="form-select">
                                <option value="Hot" {{ $currentScore == 'Hot' ? 'selected' : '' }}>🔥 Hot</option>
                                <option value="Warm" {{ $currentScore == 'Warm' ? 'selected' : '' }}>☀️ Warm</option>
                                <option value="Cold" {{ $currentScore == 'Cold' ? 'selected' : '' }}>❄️ Cold</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold-action btn-sm px-4">Send Reply & Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal for New Inquiry -->
<div class="modal fade" id="addInquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('inquiries.store') }}" method="POST">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title fw-bold fs-6 text-white"><i class="fa-solid fa-user-plus text-warning me-2"></i> New Student Inquiry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-theme-primary">Student Name *</label>
                        <input type="text" name="student_name" class="form-control" required placeholder="e.g. Ali Khan">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">Mobile Number *</label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="03001234567" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" class="form-control" placeholder="03001234567">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-theme-primary">Email Address (Optional)</label>
                        <input type="email" name="email" class="form-control" placeholder="ali@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-theme-primary">Interested Course *</label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- Choose Course --</option>
                            @if(isset($courses) && count($courses) > 0)
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name ?? $course->title }} ({{ $course->course_code ?? 'ID: '.$course->id }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">Lead Source</label>
                            <select name="source" class="form-select">
                                <option value="Walk-in">Walk-in</option>
                                <option value="Facebook">Facebook</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Website">Website</option>
                                <option value="Referral">Referral</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-theme-primary">Initial Priority</label>
                            <select name="lead_score" class="form-select">
                                <option value="Hot">🔥 Hot</option>
                                <option value="Warm" selected>☀️ Warm</option>
                                <option value="Cold">❄️ Cold</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-theme-primary">Initial Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="e.g. Inquired about evening batch timings"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-gold-action w-100 py-2">Save Prospect Inquiry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection