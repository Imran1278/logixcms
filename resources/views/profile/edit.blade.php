@extends('layouts.app')

@section('page_title', 'Admin Profile Settings')

@push('styles')
<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .profile-card-header {
        background: #0b2545;
        color: #ffffff;
        border-radius: 16px 16px 0 0 !important;
        padding: 16px 20px;
        font-weight: 700;
    }
    .btn-navy {
        background-color: #0b2545;
        color: #ffffff;
        border-radius: 10px;
        transition: all 0.25s ease;
    }
    .btn-navy:hover {
        background-color: #13315c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(11, 37, 69, 0.25);
    }
    .btn-gold {
        background-color: #d4af37;
        color: #0b2545;
        font-weight: 700;
        border-radius: 10px;
        transition: all 0.25s ease;
    }
    .btn-gold:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">
    <div class="row g-4">
        
        <!-- Profile Info Update -->
        <div class="col-md-6">
            <div class="card profile-card border-0 h-100">
                <div class="card-header profile-card-header d-flex align-items-center">
                    <i class="fa-solid fa-user-gear text-warning me-2 fs-5"></i> Update Profile Credentials
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Admin Name</label>
                            <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control shadow-sm @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-navy fw-bold px-4 py-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Password Change -->
        <div class="col-md-6">
            <div class="card profile-card border-0 h-100">
                <div class="card-header profile-card-header d-flex align-items-center">
                    <i class="fa-solid fa-key text-warning me-2 fs-5"></i> Security & Password
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Current Password</label>
                            <input type="password" name="current_password" class="form-control shadow-sm @error('current_password') is-invalid @enderror" required>
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">New Password</label>
                            <input type="password" name="password" class="form-control shadow-sm @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control shadow-sm" required>
                        </div>

                        <button type="submit" class="btn btn-gold px-4 py-2">
                            <i class="fa-solid fa-lock me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection