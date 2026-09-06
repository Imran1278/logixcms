<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | LOGIX College</title>
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
            max-width: 440px;
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
            border: none;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-student-submit:hover {
            background: var(--student-teal);
            color: var(--student-navy);
            box-shadow: 0 8px 20px rgba(0, 210, 196, 0.3);
        }

        .btn-back-home {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back-home:hover {
            color: var(--student-navy);
            transform: translateX(-3px);
        }
    </style>
</head>
<body>

<div class="auth-card p-4 p-sm-5">
    <div class="text-center mb-4">
        <div class="auth-header-icon">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <h3 class="fw-bold text-dark mb-1">Student Portal Login</h3>
        <p class="text-muted small">Enter registered email and password to access dashboard</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 rounded-3 small p-3 mb-4 shadow-sm">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 small p-3 mb-4 shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.login.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-regular fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control form-control-custom border-start-0 rounded-end-3" value="{{ old('email') }}" required placeholder="e.g. student@example.com">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold text-dark small">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control form-control-custom border-start-0 rounded-end-3" required placeholder="Enter password">
            </div>
        </div>

        <button type="submit" class="btn btn-student-submit d-flex align-items-center justify-content-center gap-2 mb-4">
            <span>Login to Portal</span>
            <i class="fa-solid fa-arrow-right fs-6"></i>
        </button>
    </form>

    <!-- Back to Home Button -->
    <div class="text-center border-top pt-3">
        <a href="{{ url('/') }}" class="btn-back-home">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>
    </div>
</div>

</body>
</html>