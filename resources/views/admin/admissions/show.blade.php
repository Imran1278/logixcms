@extends('layouts.app')

@section('page_title', 'Student Profile Details')

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
    }

    .profile-card {
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        background: var(--card-bg);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .profile-card-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 16px 20px;
        font-weight: 700;
        border-bottom: 2px solid var(--color-gold);
    }

    .avatar-lg {
        width: 72px;
        height: 72px;
        min-width: 72px;
        min-height: 72px;
        background-color: var(--color-navy);
        color: #FFFFFF;
        font-size: 24px;
    }

    .btn-gold {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 8px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.35);
    }

    .table-custom {
        color: var(--text-primary);
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--box-subtle-bg);
        border-bottom: 1px solid var(--panel-border);
    }

    .table-custom thead th {
        color: var(--text-muted);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid var(--panel-border);
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .text-theme-primary { color: var(--text-primary) !important; }
    .text-theme-muted { color: var(--text-muted) !important; }
    .box-subtle { background-color: var(--box-subtle-bg); border: 1px solid var(--panel-border); }

    @media print {
        body { 
            background: #ffffff !important; 
            color: #000000 !important;
        }
        .no-print { display: none !important; }
        .profile-card { 
            border: 1px solid #ccc !important; 
            box-shadow: none !important; 
            break-inside: avoid;
        }
        .profile-card-header {
            background: #0A2D5A !important;
            color: #ffffff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    @php
        $userObj = $admission->user ?? (isset($admission->role) ? $admission : null);
        $displayName = (!empty($admission->student_name) && $admission->student_name !== 'Pending Entry')
            ? $admission->student_name 
            : ($userObj->name ?? 'Pending Profile Completion');
            
        $rawPicture = $userObj->picture ?? $admission->picture ?? null;
        $picturePath = null;
        if (!empty($rawPicture)) {
            $picturePath = str_starts_with($rawPicture, 'http') 
                ? $rawPicture 
                : asset('storage/' . ltrim($rawPicture, '/'));
        }
        
        $initial = strtoupper(substr(trim($displayName), 0, 1));
    @endphp

    <!-- Top Action Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 no-print">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admissions.index') }}" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="d-flex align-items-center gap-3">
                @if(!empty($picturePath))
                    <img src="{{ $picturePath }}" 
                         class="rounded-circle border object-fit-cover shadow-sm avatar-lg" 
                         alt="Candidate Picture"
                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.setProperty('display', 'flex', 'important');">
                    
                    <div class="rounded-circle text-white align-items-center justify-content-center fw-bold shadow-sm avatar-lg" 
                         style="display: none !important;">
                        {{ $initial ?? 'S' }}
                    </div>
                @else
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm avatar-lg">
                        {{ $initial ?? 'S' }}
                    </div>
                @endif
                <div>
                    <h4 class="fw-bold mb-0 text-theme-primary">{{ $displayName }}</h4>
                    <small class="text-theme-muted">Registration ID: <strong class="text-theme-primary font-monospace">{{ $admission->registration_no ?? 'N/A' }}</strong></small>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark fw-bold px-3">
                <i class="fa-solid fa-print me-1"></i> Print Profile
            </button>
            <a href="{{ route('admissions.index') }}" class="btn btn-gold px-3">
                <i class="fa-solid fa-list me-1"></i> Directory
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <!-- Left Column: Personal Data -->
        <div class="col-lg-8">
            <div class="profile-card h-100 overflow-hidden">
                <div class="profile-card-header d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-id-card me-2 text-warning"></i> Comprehensive Candidate Record</span>
                    <span class="badge bg-success px-3 py-2 fs-8">{{ $admission->status ?? 'Active' }}</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Student Name</small>
                            <span class="fs-6 fw-bold text-theme-primary">{{ $displayName }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Father Name</small>
                            <span class="fs-6 fw-bold text-theme-primary">{{ $admission->father_name ?? $userObj->father_name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">CNIC / B-Form</small>
                            <span class="fw-semibold text-theme-primary font-monospace">{{ $admission->cnic_bform ?? $admission->cnic ?? $userObj->cnic ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Gender & DOB</small>
                            <span class="fw-semibold text-theme-primary">{{ $admission->gender ?? $userObj->gender ?? 'N/A' }} {{ !empty($admission->dob ?? $userObj->dob) ? '| ' . ($admission->dob ?? $userObj->dob) : '' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Blood Group</small>
                            <span class="badge bg-danger-subtle text-danger px-2 py-1">{{ $admission->blood_group ?? $userObj->blood_group ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Mobile Contact</small>
                            <span class="fw-semibold text-theme-primary"><i class="fa-solid fa-phone text-success me-1"></i> {{ $admission->mobile_contact ?? $admission->mobile_number ?? $userObj->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">WhatsApp Contact</small>
                            <span class="fw-semibold text-theme-primary"><i class="fa-brands fa-whatsapp text-success me-1"></i> {{ $admission->whatsapp_contact ?? $admission->whatsapp_number ?? $userObj->whatsapp_number ?? $userObj->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Guardian Name & Relation</small>
                            <span class="fw-semibold text-theme-primary">{{ $admission->guardian_name ?? $userObj->guardian_name ?? 'N/A' }} {{ !empty($admission->guardian_relation ?? $userObj->guardian_relation) ? '('.($admission->guardian_relation ?? $userObj->guardian_relation).')' : '' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Guardian Contact</small>
                            <span class="fw-semibold text-theme-primary">{{ $admission->guardian_contact ?? $admission->guardian_mobile ?? $admission->guardian_phone ?? $admission->guardian_number ?? $userObj->guardian_phone ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Last Qualification</small>
                            <span class="fw-semibold text-theme-primary">{{ $admission->last_qualification ?? $admission->qualification ?? $userObj->qualification ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Preferred Shift</small>
                            <span class="badge bg-secondary-subtle text-secondary border">{{ $admission->preferred_shift ?? $admission->shift ?? $userObj->shift ?? 'Morning' }}</span>
                        </div>
                        <div class="col-12">
                            <small class="text-uppercase text-theme-muted fw-bold fs-8 d-block mb-1">Residential Address</small>
                            <span class="fw-semibold text-theme-primary">{{ $admission->residential_address ?? $admission->home_address ?? $userObj->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Academic Program & Financials -->
        <div class="col-lg-4">
            <div class="profile-card overflow-hidden mb-4">
                <div class="profile-card-header">
                    <i class="fa-solid fa-book-bookmark text-warning me-2"></i> Academic Program
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-theme-muted fw-bold fs-8 text-uppercase">ENROLLED COURSE</small>
                        <h6 class="fw-bold text-primary mb-0 mt-1">{{ $admission->course->title ?? $admission->course->course_name ?? $admission->course->course_code ?? 'Not Allocated Yet' }}</h6>
                    </div>
                    <div>
                        <small class="text-theme-muted fw-bold fs-8 text-uppercase">ASSIGNED BATCH</small>
                        <h6 class="fw-bold text-theme-primary mb-0 mt-1">{{ $admission->batch->batch_name ?? $admission->batch->batch_number ?? 'Pending Batch Allocation' }}</h6>
                    </div>
                </div>
            </div>

            <div class="profile-card overflow-hidden">
                <div class="profile-card-header">
                    <i class="fa-solid fa-wallet text-success me-2"></i> Financial Summary
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-theme-muted">Total Agreed Fee:</span>
                        <strong class="text-theme-primary">Rs. {{ number_format($admission->total_agreed_fee ?? 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-theme-muted">Concession / Discount:</span>
                        <strong class="text-danger">Rs. {{ number_format($admission->discount_amount ?? 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-theme-muted">Paid Amount:</span>
                        <strong class="text-success">Rs. {{ number_format($admission->paid_fee ?? 0) }}</strong>
                    </div>
                    <hr class="my-3 border-secondary-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-theme-primary">Remaining Balance:</span>
                        <strong class="fs-5 text-danger">
                            Rs. {{ number_format($admission->due_fee ?? (($admission->total_agreed_fee ?? 0) - ($admission->discount_amount ?? 0) - ($admission->paid_fee ?? 0))) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic & Experience Details Section -->
    <div class="row g-4 mb-4">
        <!-- Education Details Table -->
        <div class="col-lg-7">
            <div class="profile-card overflow-hidden h-100">
                <div class="profile-card-header">
                    <i class="fa-solid fa-graduation-cap text-warning me-2"></i> Academic Qualification Breakdown
                </div>
                <div class="card-body p-0">
                    @php
                        $educationList = is_string($admission->education_details ?? null) 
                            ? json_decode($admission->education_details, true) 
                            : ($admission->education_details ?? []);
                    @endphp
                    @if(!empty($educationList) && count($educationList) > 0)
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="ps-4 py-3">Degree / Certificate</th>
                                        <th>Institute / Board</th>
                                        <th class="text-center">Marks</th>
                                        <th class="pe-4 text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($educationList as $edu)
                                        <tr>
                                            <td class="ps-4 fw-bold text-theme-primary">{{ $edu['degree_name'] ?? 'N/A' }}</td>
                                            <td class="small text-theme-muted">{{ $edu['institute'] ?? 'N/A' }}</td>
                                            <td class="text-center small text-theme-primary">{{ $edu['obtained_marks'] ?? '0' }} / {{ $edu['total_marks'] ?? '0' }}</td>
                                            <td class="pe-4 text-end"><span class="badge bg-primary-subtle text-primary fw-bold">{{ $edu['percentage'] ?? 'N/A' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-theme-muted">No detailed academic records submitted.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Work Experience Table -->
        <div class="col-lg-5">
            <div class="profile-card overflow-hidden h-100">
                <div class="profile-card-header">
                    <i class="fa-solid fa-briefcase text-success me-2"></i> Work Experience History
                </div>
                <div class="card-body p-0">
                    @php
                        $experienceList = is_string($admission->experience_details ?? null) 
                            ? json_decode($admission->experience_details, true) 
                            : ($admission->experience_details ?? []);
                    @endphp
                    @if(!empty($experienceList) && count($experienceList) > 0)
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="ps-4 py-3">Designation</th>
                                        <th>Company</th>
                                        <th class="pe-4 text-end">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($experienceList as $exp)
                                        <tr>
                                            <td class="ps-4 fw-bold text-theme-primary">{{ $exp['title'] ?? 'N/A' }}</td>
                                            <td class="small text-theme-muted">{{ $exp['company'] ?? 'N/A' }}</td>
                                            <td class="pe-4 text-end small text-theme-muted">
                                                {{ $exp['start_date'] ?? '' }} {{ !empty($exp['end_date']) ? 'to '.$exp['end_date'] : '(Present)' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-theme-muted">No work experience record provided.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Performance -->
    <div class="profile-card overflow-hidden">
        <div class="profile-card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-chart-pie text-info me-2"></i> Attendance Performance Record</span>
            <a href="{{ route('attendance.index', ['batch_id' => $admission->batch_id ?? '']) }}" class="btn btn-sm btn-outline-light border fw-bold no-print">
                <i class="fa-solid fa-clipboard-user me-1"></i> Open Sheet
            </a>
        </div>
        <div class="card-body p-4">
            @php
                $attendances = $admission->attendances ?? collect();
                $totalDays = $attendances->count();
                $presents = $attendances->where('status', 'Present')->count();
                $absents = $attendances->where('status', 'Absent')->count();
                $lates = $attendances->where('status', 'Late')->count();
                $leaves = $attendances->where('status', 'Leave')->count();
                $percentage = $totalDays > 0 ? round(($presents / $totalDays) * 100, 1) : 0;
            @endphp

            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="box-subtle rounded-3 p-3 text-center" style="min-width: 120px;">
                            <small class="text-theme-muted d-block fw-bold fs-8 text-uppercase">TOTAL CLASSES</small>
                            <span class="fs-4 fw-bold text-theme-primary">{{ $totalDays }}</span>
                        </div>
                        <div class="border border-success rounded-3 p-3 text-center bg-success-subtle" style="min-width: 120px;">
                            <small class="text-success d-block fw-bold fs-8 text-uppercase">PRESENT</small>
                            <span class="fs-4 fw-bold text-success">{{ $presents }}</span>
                        </div>
                        <div class="border border-danger rounded-3 p-3 text-center bg-danger-subtle" style="min-width: 120px;">
                            <small class="text-danger d-block fw-bold fs-8 text-uppercase">ABSENT</small>
                            <span class="fs-4 fw-bold text-danger">{{ $absents }}</span>
                        </div>
                        <div class="border border-warning rounded-3 p-3 text-center bg-warning-subtle" style="min-width: 120px;">
                            <small class="text-warning-emphasis d-block fw-bold fs-8 text-uppercase">LATE / LEAVE</small>
                            <span class="fs-4 fw-bold text-warning-emphasis">{{ $lates + $leaves }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-block text-center p-3 rounded-3 border {{ $percentage >= 75 ? 'border-success bg-success-subtle' : 'border-danger bg-danger-subtle' }}">
                        <small class="text-theme-muted fw-bold d-block mb-1 fs-8 text-uppercase">ATTENDANCE RATIO</small>
                        <span class="badge {{ $percentage >= 75 ? 'bg-success' : 'bg-danger' }} fs-5 px-3 py-2">
                            {{ $percentage }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection