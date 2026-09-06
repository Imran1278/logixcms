@extends('layouts.app')

@section('page_title', 'CMS - Manage Tutors & Instructors')

@push('styles')
<style>
    :root {
        --admin-navy: #0b2545;
        --admin-gold: #d4af37;
    }

    .tutor-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .tutor-header-pill {
        background: linear-gradient(135deg, var(--admin-navy) 0%, #1e293b 100%);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 14px 20px;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .social-input-group {
        position: relative;
    }
    .social-input-group i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
    }
    .social-input-group input {
        padding-left: 35px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <!-- Header Banner -->
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-3 rounded-4 shadow-sm border">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 p-3 text-white" style="background: var(--admin-navy);">
                <i class="fa-solid fa-chalkboard-user fs-4 text-warning"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-0">Faculty & Tutors Management</h4>
                <p class="text-muted small mb-0">Configure instructor profiles and social handles displayed on the website.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Add Tutor Form Box -->
        <div class="col-lg-5">
            <div class="tutor-card overflow-hidden">
                <div class="tutor-header-pill">
                    <i class="fa-solid fa-user-plus text-warning me-2"></i>Add Instructor Profile
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.tutors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Tutor Full Name *</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Prof. Muhammad Ali">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Designation / Specialization *</label>
                            <input type="text" name="rank" class="form-control" required placeholder="e.g. Lead Web Architect">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Profile Picture *</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Brief Bio</label>
                            <textarea name="bio" class="form-control" rows="2" placeholder="Experience summary..."></textarea>
                        </div>
                        
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <h6 class="fw-bold text-secondary small mb-3">Social Handles (Optional)</h6>
                            <div class="social-input-group mb-2">
                                <i class="fa-brands fa-x-twitter text-dark"></i>
                                <input type="url" name="twitter" class="form-control form-control-sm" placeholder="Twitter URL">
                            </div>
                            <div class="social-input-group mb-2">
                                <i class="fa-brands fa-linkedin text-primary"></i>
                                <input type="url" name="linkedin" class="form-control form-control-sm" placeholder="LinkedIn URL">
                            </div>
                            <div class="social-input-group mb-2">
                                <i class="fa-brands fa-instagram text-danger"></i>
                                <input type="url" name="instagram" class="form-control form-control-sm" placeholder="Instagram URL">
                            </div>
                            <div class="social-input-group">
                                <i class="fa-brands fa-youtube text-danger"></i>
                                <input type="url" name="youtube" class="form-control form-control-sm" placeholder="YouTube URL">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-2 text-white" style="background: var(--admin-navy);">
                            <i class="fa-solid fa-floppy-disk text-warning me-1"></i> Save Instructor Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Active Tutors Listing -->
        <div class="col-lg-7">
            <div class="tutor-card overflow-hidden">
                <div class="tutor-header-pill d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-users text-teal me-2"></i>Active Instructors Directory</span>
                    <span class="badge bg-light text-dark fw-bold">{{ count($tutors) }} Profiles</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th class="ps-3" style="width: 70px;">Photo</th>
                                    <th>Instructor Info</th>
                                    <th>Connected Socials</th>
                                    <th class="text-center pe-3" style="width: 90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tutors as $tutor)
                                    <tr>
                                        <td class="ps-3">
                                            <img src="{{ asset($tutor->image) }}" width="48" height="48" class="rounded-circle border shadow-sm object-fit-cover">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $tutor->name }}</div>
                                            <small class="text-muted fw-semibold">{{ $tutor->rank }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 fs-6">
                                                @if($tutor->twitter)<a href="{{ $tutor->twitter }}" target="_blank" class="text-dark"><i class="fa-brands fa-x-twitter"></i></a>@endif
                                                @if($tutor->linkedin)<a href="{{ $tutor->linkedin }}" target="_blank" class="text-primary"><i class="fa-brands fa-linkedin"></i></a>@endif
                                                @if($tutor->instagram)<a href="{{ $tutor->instagram }}" target="_blank" class="text-danger"><i class="fa-brands fa-instagram"></i></a>@endif
                                                @if($tutor->youtube)<a href="{{ $tutor->youtube }}" target="_blank" class="text-danger"><i class="fa-brands fa-youtube"></i></a>@endif
                                                @if(!$tutor->twitter && !$tutor->linkedin && !$tutor->instagram && !$tutor->youtube)
                                                    <span class="text-muted fs-8">None</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center pe-3">
                                            <form action="{{ route('admin.tutors.destroy', $tutor->id) }}" method="POST" onsubmit="return confirm('Delete instructor profile?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">No instructors registered yet.</td>
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
@endsection