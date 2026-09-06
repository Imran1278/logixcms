{{-- File Path: resources/views/student/attendance/setup_2fa.blade.php --}}
<style>
    .setup-2fa-card {
        background: var(--box-bg, #ffffff);
        border: 1px solid var(--panel-border, #e2e8f0);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(10, 37, 64, 0.05);
        overflow: hidden;
    }

    .setup-2fa-header {
        background: linear-gradient(135deg, #09223d 0%, #041324 100%);
        color: #ffffff;
        padding: 1.25rem 1.5rem;
        text-align: center;
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

    .qr-container {
        background: #ffffff;
        border: 2px dashed var(--panel-border, #cbd5e1);
        border-radius: 14px;
        padding: 1rem;
        display: inline-block;
    }

    .step-badge {
        width: 24px;
        height: 24px;
        background: var(--color-gold, #c8a251);
        color: #ffffff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
        margin-right: 6px;
    }
</style>

<div class="row justify-content-center py-3">
    <div class="col-md-8 col-lg-6">
        <div class="setup-2fa-card">
            <!-- Header -->
            <div class="setup-2fa-header">
                <h5 class="mb-0 fw-bold fs-6 text-uppercase letter-spacing-1">
                    <i class="fa-solid fa-shield-halved me-2 text-warning"></i> Setup Authenticator App
                </h5>
            </div>

            <div class="card-body p-4 text-center">
                <p class="text-theme-muted small mb-3">
                    <span class="step-badge">1</span> Attendance system security setup ke liye <strong>Google Authenticator</strong> ya <strong>Authy</strong> app se ye QR code scan karein:
                </p>

                <!-- QR Code Box -->
                @if(!empty($qrCodeSvg))
                    <div class="qr-container mb-3 shadow-sm">
                        {!! $qrCodeSvg !!}
                    </div>
                @else
                    <div class="alert alert-warning border-0 rounded-3 small my-3">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> QR code load nahi ho saka. Kripya page refresh karein.
                    </div>
                @endif

                <!-- Flash Notifications -->
                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 small py-2 mb-3 text-start">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 small py-2 mb-3 text-start">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Verification Form -->
                <form action="{{ route('student.attendance.enable2fa') }}" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label-custom">
                            <span class="step-badge">2</span> Enter 6-Digit Code from App:
                        </label>
                        <input type="text" name="one_time_password" 
                               class="form-control form-control-acad form-control-lg text-center font-monospace fs-4 fw-bold tracking-wider" 
                               placeholder="123456" maxlength="6" required autocomplete="off">
                    </div>
                    
                    <button type="submit" class="btn btn-gold-action w-100 fw-bold py-2 shadow-sm fs-7">
                        <i class="fa-solid fa-link me-1"></i> Verify & Link Authenticator
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>