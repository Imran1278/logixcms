@extends('layouts.app')

@section('page_title', 'New Student Pre-Registration')

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
    }

    .admission-card {
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        background: var(--card-bg);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .admission-header-pill {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 22px 28px;
        border-bottom: 2px solid var(--color-gold);
    }

    .section-title {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid var(--panel-border);
        padding-bottom: 10px;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .btn-submit-gold {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 10px;
        border: none;
        padding: 14px;
        transition: all 0.25s ease;
    }

    .btn-submit-gold:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 14px rgba(207, 174, 78, 0.35);
    }

    .avatar-preview-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px dashed var(--input-border);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--box-subtle-bg);
        overflow: hidden;
    }

    .avatar-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-control {
        background-color: var(--input-bg);
        border-color: var(--input-border);
        color: var(--input-text);
    }

    .form-control:focus {
        background-color: var(--input-bg);
        color: var(--input-text);
        border-color: var(--color-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.25);
    }

    .text-theme-primary { color: var(--text-primary) !important; }
    .text-theme-muted { color: var(--text-muted) !important; }
    .box-subtle { background-color: var(--box-subtle-bg); border: 1px solid var(--panel-border); }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="admission-card overflow-hidden">
                <div class="admission-header-pill d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 bg-white bg-opacity-10 rounded-3 text-warning">
                            <i class="fa-solid fa-user-plus fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Initial Student Pre-Registration</h5>
                            <small class="text-white-50">Register student identity. Course, batch & detailed profile will be completed by student.</small>
                        </div>
                    </div>
                    <a href="{{ route('admissions.index') }}" class="btn btn-sm btn-outline-light rounded-2 px-3 fw-semibold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Directory
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admissions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="alert box-subtle rounded-3 py-3 mb-4 d-flex align-items-center gap-3">
                            <i class="fa-solid fa-circle-info fs-4 text-warning flex-shrink-0"></i>
                            <div>
                                <strong class="d-block text-theme-primary mb-1">Admin Pre-Registration Rules</strong>
                                <span class="small text-theme-muted">An automated invitation email will be dispatched to the student. The student can click the email link to configure login credentials, select assigned course/batch, and complete profile details.</span>
                            </div>
                        </div>

                        <div class="section-title d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark rounded-circle" style="width:22px; height:22px; line-height:14px;">1</span> Identity & Contact Credentials
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-theme-primary small">Student Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary"><i class="fa-solid fa-envelope text-secondary"></i></span>
                                    <input type="email" name="email" class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="student@example.com">
                                </div>
                                <small class="text-theme-muted fs-8">Used for account access and student portal updates.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-theme-primary small">CNIC / B-Form Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary"><i class="fa-solid fa-id-card text-secondary"></i></span>
                                    <input type="text" name="cnic" class="form-control form-control-lg fs-6 @error('cnic') is-invalid @enderror" value="{{ old('cnic') }}" required placeholder="38403-xxxxxxx-x">
                                </div>
                                <small class="text-theme-muted fs-8">Must match national identity document records.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-theme-primary small">Profile Picture</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-preview-box" id="avatarPreviewContainer">
                                        <i class="fa-solid fa-user-tie fs-3 text-secondary" id="avatarPlaceholderIcon"></i>
                                        <img id="avatarImage" src="#" alt="Preview" class="d-none">
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="picture" id="pictureInput" class="form-control @error('picture') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg">
                                        <small class="text-theme-muted fs-8 d-block mt-1">Accepted formats: JPG, PNG, JPEG. Max file size: 2MB.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-submit-gold w-100 fs-6 shadow-sm mt-3">
                            <i class="fa-solid fa-paper-plane me-2"></i> Register & Send Student Access Mail
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pictureInput = document.getElementById('pictureInput');
        const avatarImage = document.getElementById('avatarImage');
        const avatarPlaceholderIcon = document.getElementById('avatarPlaceholderIcon');

        if (pictureInput) {
            pictureInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        avatarImage.src = event.target.result;
                        avatarImage.classList.remove('d-none');
                        avatarPlaceholderIcon.classList.add('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush