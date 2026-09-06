@extends('layouts.app')

@section('page_title', 'Manage Header Settings')

@section('content')
<div class="container-fluid py-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-3" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-dark text-white p-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-sliders me-2 text-warning"></i> Header & Navigation Management</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.header_settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Top Notification Bar -->
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-circle-info me-1"></i> Top Notification Bar Info</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Campus Address</label>
                        <input type="text" name="top_address" class="form-control" value="{{ $settings['top_address'] ?? 'Main Campus, Club Road, Sargodha' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="top_phone" class="form-control" value="{{ $settings['top_phone'] ?? '+92 48 3220901' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">WhatsApp Number</label>
                        <input type="text" name="top_whatsapp" class="form-control" value="{{ $settings['top_whatsapp'] ?? '0346-8667400' }}">
                    </div>
                </div>

                <!-- Branding Logo -->
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-image me-1"></i> Branding & Logo</h6>
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Upload Header Logo</label>
                        <input type="file" name="site_logo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        @if(!empty($settings['site_logo']))
                            <div class="p-2 border bg-light rounded d-inline-block">
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" height="40" alt="Logo">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Navigation Menu Items (Text & Custom Links) -->
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-compass me-1"></i> Main Navigation Menu Items</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Nav Item 1</label>
                            <input type="text" name="nav1_text" class="form-control mb-2" value="{{ $settings['nav1_text'] ?? 'HOME' }}" placeholder="Label">
                            <input type="text" name="nav1_link" class="form-control" value="{{ $settings['nav1_link'] ?? '/' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Nav Item 2</label>
                            <input type="text" name="nav2_text" class="form-control mb-2" value="{{ $settings['nav2_text'] ?? 'ABOUT US' }}" placeholder="Label">
                            <input type="text" name="nav2_link" class="form-control" value="{{ $settings['nav2_link'] ?? 'about.details' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Nav Item 3</label>
                            <input type="text" name="nav3_text" class="form-control mb-2" value="{{ $settings['nav3_text'] ?? 'ACADEMIC PROGRAMS' }}" placeholder="Label">
                            <input type="text" name="nav3_link" class="form-control" value="{{ $settings['nav3_link'] ?? 'courses.all' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Nav Item 4</label>
                            <input type="text" name="nav4_text" class="form-control mb-2" value="{{ $settings['nav4_text'] ?? 'E-CAMPUS' }}" placeholder="Label">
                            <input type="text" name="nav4_link" class="form-control" value="{{ $settings['nav4_link'] ?? '#' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Nav Item 5</label>
                            <input type="text" name="nav5_text" class="form-control mb-2" value="{{ $settings['nav5_text'] ?? 'CONTACT' }}" placeholder="Label">
                            <input type="text" name="nav5_link" class="form-control" value="{{ $settings['nav5_link'] ?? '#' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                </div>

                <!-- Top Bar Action Buttons Labels & Links -->
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fa-solid fa-link me-1"></i> Top Action Buttons Labels & Links</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Button 1 (Course Finder)</label>
                            <input type="text" name="btn1_text" class="form-control mb-2" value="{{ $settings['btn1_text'] ?? 'COURSE FINDER' }}" placeholder="Label">
                            <input type="text" name="btn1_link" class="form-control" value="{{ $settings['btn1_link'] ?? '#' }}" placeholder="Use # for Modal or URL">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Button 2 (Forms/Downloads)</label>
                            <input type="text" name="btn2_text" class="form-control mb-2" value="{{ $settings['btn2_text'] ?? 'FORMS' }}" placeholder="Label">
                            <input type="text" name="btn2_link" class="form-control" value="{{ $settings['btn2_link'] ?? 'downloads.index' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Button 3 (Login / Portal)</label>
                            <input type="text" name="btn3_text" class="form-control mb-2" value="{{ $settings['btn3_text'] ?? 'STUDENT LOGIN' }}" placeholder="Label">
                            <input type="text" name="btn3_link" class="form-control" value="{{ $settings['btn3_link'] ?? 'student.login' }}" placeholder="URL or Route Name">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark btn-lg px-4 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection