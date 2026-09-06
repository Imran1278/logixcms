{{-- File Path: resources/views/student/partials/attendance.blade.php --}}
<!-- FullCalendar CSS & Custom Styling -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<style>
    .fc-event-present { 
        background-color: #10b981 !important; 
        border-color: #059669 !important; 
        color: #ffffff !important; 
        font-weight: 700;
        border-radius: 6px;
        padding: 2px 4px;
    }
    .fc-event-absent  { 
        background-color: #ef4444 !important; 
        border-color: #dc2626 !important; 
        color: #ffffff !important; 
        font-weight: 700;
        border-radius: 6px;
        padding: 2px 4px;
    }
    .fc-event-late    { 
        background-color: #f59e0b !important; 
        border-color: #d97706 !important; 
        color: #ffffff !important; 
        font-weight: 700;
        border-radius: 6px;
        padding: 2px 4px;
    }
    .fc-event-leave   { 
        background-color: #06b6d4 !important; 
        border-color: #0891b2 !important; 
        color: #ffffff !important; 
        font-weight: 700;
        border-radius: 6px;
        padding: 2px 4px;
    }

    .fc-toolbar-title {
        font-size: 1.1rem !important;
        font-weight: 800 !important;
        color: var(--text-main, #0a2540) !important;
    }

    .fc .fc-button-primary {
        background-color: var(--navy-primary, #0a2540) !important;
        border-color: var(--navy-primary, #0a2540) !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        text-transform: capitalize !important;
    }

    .fc .fc-button-primary:hover {
        background-color: #041324 !important;
        border-color: #041324 !important;
    }

    .fc .fc-button-primary:disabled {
        background-color: #94a3b8 !important;
        border-color: #94a3b8 !important;
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

    .form-control-acad {
        border: 1px solid var(--panel-border, #cbd5e1);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.88rem;
        color: var(--text-main, #1e293b);
        background-color: var(--box-bg, #ffffff);
        transition: all 0.25s ease;
    }

    .form-control-acad:focus {
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
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background: linear-gradient(135deg, #b38e3e 0%, #9a782e 100%);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(200, 162, 81, 0.35);
    }
</style>

@php
    $studentUser = auth()->user();
    $is2faSetup  = !empty($studentUser->google2fa_secret) && ($studentUser->google2fa_enabled ?? false);
@endphp

@if(!$is2faSetup)
    <!-- Step 1: Render 2FA Setup view if not linked yet -->
    @include('student.attendance.setup_2fa')
@else
    <!-- Step 2: Render Main Attendance Calendar & OTP Check-In -->
    <div class="row g-4">
        <!-- Left Panel: Daily OTP Check-in & Leave Request Forms -->
        <div class="col-lg-4">
            <!-- Daily Check-in Card -->
            <div class="react-card mb-4">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h6 class="fw-bold text-theme-primary mb-0 fs-7 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i> Today's Check-In
                    </h6>
                    <span class="badge bg-success-subtle text-success border border-success fs-8 rounded-pill fw-bold">Live 2FA</span>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 small py-2 mb-3 align-items-center d-flex">
                        <i class="fa-solid fa-circle-check me-2 fs-6"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 small py-2 mb-3 align-items-center d-flex">
                        <i class="fa-solid fa-triangle-exclamation me-2 fs-6"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('student.attendance.checkin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label-custom">Enter Authenticator OTP</label>
                        <input type="text" name="otp_code" 
                               class="form-control form-control-acad text-center font-monospace fs-4 fw-bold tracking-wider" 
                               placeholder="000000" maxlength="6" required autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-gold-action w-100 py-2 shadow-sm fs-7">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Verify & Check In
                    </button>
                </form>
            </div>

            <!-- Leave Request Form -->
            <div class="react-card">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h6 class="fw-bold text-theme-primary mb-0 fs-7 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-file-signature me-2 text-warning"></i> Apply For Leave
                    </h6>
                    <span class="badge bg-body-tertiary text-theme-primary border border-theme fs-8 rounded-pill">Academic</span>
                </div>

                <form action="{{ route('student.leave.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label-custom">Leave Date</label>
                        <input type="date" name="leave_date" class="form-control form-control-acad" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Reason</label>
                        <textarea name="reason" rows="3" class="form-control form-control-acad" placeholder="Provide clear reason for leave..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-dark fw-bold w-100 py-2 rounded-3 shadow-sm fs-7">
                        <i class="fa-solid fa-paper-plane me-1"></i> Submit Leave Request
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Panel: FullCalendar View & Export Options -->
        <div class="col-lg-8">
            <div class="react-card">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h5 class="fw-bold text-theme-primary mb-0 fs-6 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-calendar-days me-2 text-warning"></i> Attendance Calendar
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('student.attendance.export.pdf') }}" class="btn btn-sm btn-outline-danger fw-bold rounded-3">
                            <i class="fa-solid fa-file-pdf me-1"></i> PDF
                        </a>
                        <a href="{{ route('student.attendance.export.excel') }}" class="btn btn-sm btn-outline-success fw-bold rounded-3">
                            <i class="fa-solid fa-file-excel me-1"></i> Excel
                        </a>
                    </div>
                </div>

                <div id="calendar" class="p-2 bg-body-tertiary rounded-3 border border-theme"></div>
            </div>
        </div>
    </div>
@endif

<!-- FullCalendar JS Script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            window.studentCalendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 520,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: [
                    @if(isset($attendances) && count($attendances) > 0)
                        @foreach($attendances as $att)
                        {
                            title: '{{ $att->status }} ({{ $att->check_in_time ? date("h:i A", strtotime($att->check_in_time)) : "Manual" }})',
                            start: '{{ $att->attendance_date }}',
                            className: 'fc-event-{{ strtolower($att->status) }}'
                        },
                        @endforeach
                    @endif
                    @if(isset($leaves) && count($leaves) > 0)
                        @foreach($leaves as $leave)
                        {
                            title: 'Leave: {{ ucfirst($leave->status) }}',
                            start: '{{ $leave->leave_date }}',
                            className: 'fc-event-leave'
                        },
                        @endforeach
                    @endif
                ]
            });
            window.studentCalendar.render();
        }
    });
</script>