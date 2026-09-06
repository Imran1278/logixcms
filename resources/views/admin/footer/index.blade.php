@extends('layouts.app')

@section('page_title', 'Footer CMS Settings')

@push('styles')
<style>
    :root {
        --admin-navy: #0b2545;
        --admin-navy-light: #13315c;
        --admin-gold: #d4af37;
    }

    /* Page Header Banner */
    .cms-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    /* Card Panels */
    .cms-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .cms-card-header {
        background: var(--admin-navy);
        color: #ffffff;
        padding: 16px 20px;
        font-weight: 700;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cms-card-header i {
        color: var(--admin-gold);
    }

    /* Input Focus Styling */
    .form-control:focus {
        border-color: var(--admin-navy-light);
        box-shadow: 0 0 0 0.25rem rgba(19, 49, 92, 0.15);
    }

    /* Action Buttons */
    .btn-gold-save {
        background-color: var(--admin-gold);
        color: #0b2545;
        font-weight: 700;
        border-radius: 10px;
        border: none;
        padding: 12px 36px;
        transition: all 0.25s ease;
    }

    .btn-gold-save:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.35);
    }

    .img-preview-box {
        background: #0b2545;
        border-radius: 10px;
        border: 1px dashed rgba(212, 175, 55, 0.4);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">

    <!-- Page Title Header -->
    <div class="cms-header-card p-4 mb-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="p-3 bg-light text-warning rounded-3 fs-3 border">
                <i class="fa-solid fa-sliders text-warning"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1">Footer Content Management</h4>
                <p class="text-muted small mb-0">Customize global footer text, working hours, flexible learning map, and social media links.</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form action="{{ route('admin.footer.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <!-- COLUMN 1: ABOUT DETAILS -->
            <div class="col-lg-6">
                <div class="cms-card h-100">
                    <div class="cms-card-header d-flex align-items-center">
                        <i class="fa-solid fa-circle-info me-2"></i> Column 1: About Details
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">About Paragraph Text</label>
                            <textarea name="about_description" class="form-control" rows="4" placeholder="Enter short about text...">{{ old('about_description', $footer->about_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $footer->phone_number ?? '') }}" placeholder="+44 300 303 0266">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Working Hours</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-clock"></i></span>
                                <input type="text" name="working_hours" class="form-control" value="{{ old('working_hours', $footer->working_hours ?? '') }}" placeholder="Mon - Sat 8.00 - 18.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMN 4: FLEXIBLE LEARNING GRAPHIC -->
            <div class="col-lg-6">
                <div class="cms-card h-100">
                    <div class="cms-card-header d-flex align-items-center">
                        <i class="fa-solid fa-earth-americas me-2"></i> Column 4: Flexible Learning Graphic
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Column Header Title</label>
                            <input type="text" name="learning_title" class="form-control" value="{{ old('learning_title', $footer->learning_title ?? 'Flexible Learning') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Upload World Map / Image (PNG, SVG, JPG)</label>
                            <input type="file" name="map_image" class="form-control" accept="image/*">
                            
                            @if(!empty($footer->map_image))
                                <div class="mt-3 p-3 img-preview-box text-center">
                                    <span class="text-white-50 small d-block mb-2">Current Map Graphic Preview:</span>
                                    <img src="{{ asset($footer->map_image) }}" class="img-fluid" style="max-height: 100px; object-fit: contain;" alt="Map Graphic">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTTOM BAR & SOCIAL LINKS -->
            <div class="col-12">
                <div class="cms-card">
                    <div class="cms-card-header d-flex align-items-center">
                        <i class="fa-solid fa-share-nodes me-2"></i> Bottom Bar & Social Links
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">Copyright Text</label>
                                <input type="text" name="copyright_text" class="form-control" value="{{ old('copyright_text', $footer->copyright_text ?? '© 2026 Logix College, All Rights Reserved') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">Bottom Bar Contact Phone</label>
                                <input type="text" name="bottom_phone" class="form-control" value="{{ old('bottom_phone', $footer->bottom_phone ?? '+44 300 303 0266') }}">
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-secondary small"><i class="fa-brands fa-x-twitter me-1 text-dark"></i> Twitter / X URL</label>
                                <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $footer->twitter_url ?? '') }}" placeholder="https://twitter.com/...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-secondary small"><i class="fa-brands fa-instagram me-1 text-danger"></i> Instagram URL</label>
                                <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $footer->instagram_url ?? '') }}" placeholder="https://instagram.com/...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-secondary small"><i class="fa-brands fa-facebook me-1 text-primary"></i> Facebook URL</label>
                                <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $footer->facebook_url ?? '') }}" placeholder="https://facebook.com/...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-secondary small"><i class="fa-brands fa-linkedin me-1 text-info"></i> Linkedin URL</label>
                                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $footer->linkedin_url ?? '') }}" placeholder="https://linkedin.com/...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12 text-end mb-4">
                <button type="submit" class="btn btn-gold-save shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Footer Settings
                </button>
            </div>

        </div>
    </form>
</div>
@endsection