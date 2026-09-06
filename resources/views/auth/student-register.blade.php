<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | LOGIX College</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --student-navy: #0b2545;
            --student-teal: #00d2c4;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(11, 37, 69, 0.08);
            border: 1px solid rgba(11, 37, 69, 0.08);
            overflow: hidden;
        }

        .auth-header-icon {
            width: 64px;
            height: 64px;
            background: rgba(0, 210, 196, 0.12);
            color: var(--student-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 16px;
        }

        .form-control-custom {
            border: 1.5px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--student-teal);
            box-shadow: 0 0 0 4px rgba(0, 210, 196, 0.15);
        }

        .btn-student-submit {
            background: var(--student-navy);
            color: #ffffff;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-student-submit:hover {
            background: var(--student-teal);
            color: var(--student-navy);
            box-shadow: 0 8px 20px rgba(0, 210, 196, 0.3);
        }
    </style>
</head>
<body>

<div class="auth-card p-4 p-sm-5">
    <div class="text-center mb-4">
        <div class="auth-header-icon">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <h3 class="fw-bold text-dark mb-1">Student Registration</h3>
        <p class="text-muted small">Create your official student profile to proceed</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 small p-3 mb-4 shadow-sm">
            <div class="d-flex align-items-center mb-1">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <strong class="small">Please correct the following errors:</strong>
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.register.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Full Name <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-regular fa-user text-muted"></i></span>
                <input type="text" name="name" class="form-control form-control-custom border-start-0 rounded-end-3" value="{{ old('name') }}" required placeholder="e.g. Ali Raza">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Email Address <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-regular fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control form-control-custom border-start-0 rounded-end-3" value="{{ old('email') }}" required placeholder="e.g. ali@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Mobile / WhatsApp Number <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-phone text-muted"></i></span>
                <input type="text" name="phone" class="form-control form-control-custom border-start-0 rounded-end-3" value="{{ old('phone') }}" required placeholder="e.g. 03001234567">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Password <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control form-control-custom border-start-0 rounded-end-3" required placeholder="At least 8 characters">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold text-dark small">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-shield-halved text-muted"></i></span>
                <input type="password" name="password_confirmation" class="form-control form-control-custom border-start-0 rounded-end-3" required placeholder="Re-enter password">
            </div>
        </div>

        <button type="submit" class="btn btn-student-submit d-flex align-items-center justify-content-center gap-2">
            <span>Register Account</span>
            <i class="fa-solid fa-arrow-right fs-6"></i>
        </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top">
        <span class="small text-muted">Already registered?</span>
        <a href="{{ route('student.login') }}" class="small fw-bold text-decoration-none ms-1" style="color: var(--student-navy);">
            Login Here <i class="fa-solid fa-angle-right ms-1"></i>
        </a>
    </div>
</div>

</body>
</html>