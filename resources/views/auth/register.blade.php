<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup - LOGIX CMS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-dark: #0b2545;
            --navy-light: #13315c;
            --gold-accent: #d4af37;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
        }

        .auth-header {
            background: #ffffff;
            padding: 35px 30px 15px 30px;
            text-align: center;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: var(--navy-dark);
            color: var(--gold-accent);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 15px;
            box-shadow: 0 8px 16px rgba(11, 37, 69, 0.2);
        }

        .auth-body {
            padding: 15px 30px 35px 30px;
        }

        .form-label {
            font-size: 0.825rem;
            font-weight: 700;
            color: #475569;
            text-uppercase: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #64748b;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .form-control {
            border-left: none;
            background-color: #f8fafc;
            padding: 12px 15px;
            font-size: 0.95rem;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
            border-color: #cbd5e1;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--navy-dark);
            background-color: #ffffff;
        }

        .btn-admin-submit {
            background-color: var(--navy-dark);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 13px;
            border-radius: 10px;
            transition: all 0.25s ease;
            width: 100%;
        }

        .btn-admin-submit:hover {
            background-color: #051427;
            color: var(--gold-accent);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <div class="brand-logo">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <h4 class="fw-bold text-dark m-0">Initial System Setup</h4>
        <p class="text-muted small mt-1">Configure primary administrator credentials</p>
    </div>

    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 small p-3 mb-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="System Administrator" required value="{{ old('name') }}" autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@logix.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-admin-submit">
                Create Admin Credentials <i class="fa-solid fa-circle-check ms-2"></i>
            </button>
        </form>

        <div class="text-center mt-3 pt-2">
            <a href="{{ route('login') }}" class="small text-muted text-decoration-none fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </div>
</div>

</body>
</html>