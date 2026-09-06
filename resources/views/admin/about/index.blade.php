@extends('layouts.app')

@section('page_title', 'About CMS Studio')

@push('styles')
<style>
    :root {
        --admin-navy: #0b2545;
        --admin-navy-light: #13315c;
        --admin-gold: #d4af37;
        --admin-card-border: #e2e8f0;
    }

    .cms-header-card {
        background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-light) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
    }

    /* Custom Navigation Tabs */
    .cms-tabs .nav-link {
        color: #64748b;
        font-weight: 600;
        padding: 0.85rem 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid transparent;
        transition: all 0.25s ease;
    }
    .cms-tabs .nav-link:hover {
        color: var(--admin-navy);
        background-color: #f1f5f9;
    }
    .cms-tabs .nav-link.active {
        color: var(--admin-navy);
        background-color: #ffffff;
        border-color: var(--admin-card-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .cms-tabs .nav-link.active i {
        color: var(--admin-gold) !important;
    }

    /* Form Inputs Modernization */
    .form-control:focus, .form-select:focus {
        border-color: var(--admin-gold);
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.18);
    }
    
    .cms-card {
        border: 1px solid var(--admin-card-border);
        border-radius: 1rem;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
    }

    .cms-section-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background: rgba(212, 175, 55, 0.15);
        color: var(--admin-gold);
    }

    /* Dynamic Row Styling */
    .industry-row {
        background: #f8fafc;
        border: 1px dashed #cbd5e1 !important;
        transition: all 0.2s ease;
    }
    .industry-row:hover {
        background: #ffffff;
        border-color: var(--admin-gold) !important;
        box-shadow: 0 6px 15px -3px rgba(0, 0, 0, 0.05);
    }

    /* Award Card Styling */
    .award-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .award-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-gold-action {
        background-color: var(--admin-gold);
        color: #0b2545;
        font-weight: 700;
        border-radius: 50px;
        border: none;
        padding: 10px 24px;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #c4a028;
        color: #000000;
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.35);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <!-- Header Banner -->
    <div class="cms-header-card p-4 mb-4 text-white shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="cms-section-icon fs-4">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1 text-white">About Page CMS Studio</h4>
                <p class="text-white-50 small mb-0">Configure home intro video, institutional mission, goals, and global partner badges.</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('about.details') }}" target="_blank" class="btn btn-gold-action shadow-sm">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Live Preview
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
                <span class="fw-bold">Form Submission Errors:</span>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Navigation Tabs -->
        <ul class="nav cms-tabs mb-4 p-1 bg-light rounded-4 border d-inline-flex gap-1" id="cmsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-sec-tab" data-bs-toggle="tab" data-bs-target="#home-sec" type="button" role="tab">
                    <i class="fa-solid fa-house-laptop me-2"></i>Home Intro Section
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="detailed-sec-tab" data-bs-toggle="tab" data-bs-target="#detailed-sec" type="button" role="tab">
                    <i class="fa-solid fa-layer-group me-2"></i>Vision & Mission
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="industry-sec-tab" data-bs-toggle="tab" data-bs-target="#industry-sec" type="button" role="tab">
                    <i class="fa-solid fa-industry me-2"></i>Partners & Companies
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="awards-sec-tab" data-bs-toggle="tab" data-bs-target="#awards-sec" type="button" role="tab">
                    <i class="fa-solid fa-trophy me-2"></i>Awards Gallery
                </button>
            </li>
        </ul>

        <!-- Tab Content Areas -->
        <div class="tab-content" id="cmsTabsContent">
            
            <!-- SECTION 1: HOME PAGE ABOUT SECTION -->
            <div class="tab-pane fade show active" id="home-sec" role="tabpanel">
                <div class="card cms-card border-0 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                            <div class="cms-section-icon">
                                <i class="fa-solid fa-circle-play"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Homepage Video & Brief Introduction</h5>
                                <small class="text-muted">Configures the summary box on the front homepage (`includes/about.blade.php`)</small>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Main Headline Title</label>
                                <input type="text" name="home_title" class="form-control form-control-lg rounded-3 fs-6" 
                                       placeholder="e.g. Empowering Future Tech Leaders & Innovators" 
                                       value="{{ old('home_title', $about->home_title ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Upload Video Asset (.mp4 / .webm)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-file-video text-warning"></i></span>
                                    <input type="file" name="home_video_file" class="form-control form-control-lg rounded-end-3 fs-6" accept="video/mp4,video/webm,video/mkv">
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">Maximum File Size Limit: 50MB</small>
                                    @if(!empty($about->home_video_url))
                                        <a href="{{ asset($about->home_video_url) }}" target="_blank" class="badge text-white p-2 text-decoration-none" style="background: var(--admin-navy);">
                                            <i class="fa-solid fa-circle-play text-warning me-1"></i> Preview Active Media
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">Brief Introduction Overview</label>
                                <textarea name="home_description" class="form-control rounded-3 p-3" rows="4" 
                                          placeholder="Enter brief introductory overview for main page display...">{{ old('home_description', $about->home_description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: ABOUT DETAILS CONTENT -->
            <div class="tab-pane fade" id="detailed-sec" role="tabpanel">
                <div class="card cms-card border-0 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                            <div class="cms-section-icon">
                                <i class="fa-solid fa-compass"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Detailed Strategy & Vision</h5>
                                <small class="text-muted">Manages full content displayed on `about_details.blade.php`</small>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">
                                    <i class="fa-solid fa-eye text-warning me-1"></i> Our Vision Statement
                                </label>
                                <textarea name="our_vision" class="form-control rounded-3 p-3" rows="4" 
                                          placeholder="Write detailed institutional vision statement...">{{ old('our_vision', $about->our_vision ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="p-4 bg-light rounded-4 mb-4 border">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fa-solid fa-shield-halved text-warning me-2"></i>Why Choose Us Section
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small">Section Title</label>
                                    <input type="text" name="why_logix_title" class="form-control rounded-3" 
                                           placeholder="e.g. Why Choose LOGIX College?" 
                                           value="{{ old('why_logix_title', $about->why_logix_title ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small">FontAwesome Icon Class</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa-solid fa-icons text-muted"></i></span>
                                        <input type="text" name="why_logix_icon" class="form-control" 
                                               placeholder="e.g. fa-solid fa-graduation-cap" 
                                               value="{{ old('why_logix_icon', $about->why_logix_icon ?? 'fa-solid fa-graduation-cap') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-secondary small">Description</label>
                                    <textarea name="why_logix_description" class="form-control rounded-3" rows="3" 
                                              placeholder="Detailed explanation on student benefits...">{{ old('why_logix_description', $about->why_logix_description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark small">Educational Goals</label>
                                <textarea name="educational_goals" class="form-control rounded-3 p-3" rows="4" 
                                          placeholder="Key academic milestones...">{{ old('educational_goals', $about->educational_goals ?? '') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark small">Institutional Mission</label>
                                <textarea name="our_mission" class="form-control rounded-3 p-3" rows="4" 
                                          placeholder="Core purpose and mission...">{{ old('our_mission', $about->our_mission ?? '') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark small">Specific Targets</label>
                                <textarea name="specific_goals" class="form-control rounded-3 p-3" rows="4" 
                                          placeholder="Measurable long term outcomes...">{{ old('specific_goals', $about->specific_goals ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: INDUSTRY PARTNERS -->
            <div class="tab-pane fade" id="industry-sec" role="tabpanel">
                <div class="card cms-card border-0 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="cms-section-icon">
                                    <i class="fa-solid fa-building-user"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Industry Training Partners</h5>
                                    <small class="text-muted">Add corporate partners and software houses collaborating with institute</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-dark text-warning btn-sm rounded-pill fw-bold px-3 shadow-sm" id="add-industry-btn">
                                <i class="fa-solid fa-plus me-1"></i> Add Partner Entity
                            </button>
                        </div>

                        <div id="industry-container">
                            @php $industries = old('industries', $about->industries ?? [['name'=>'', 'description'=>'', 'image'=>'']]); @endphp
                            @foreach($industries as $i => $ind)
                                <div class="rounded-4 p-3 mb-3 industry-row">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-dark mb-1">Company / Entity Name</label>
                                            <input type="text" name="industries[{{ $i }}][name]" class="form-control form-control-sm rounded-2" value="{{ $ind['name'] ?? '' }}" placeholder="e.g. Systems Ltd">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-dark mb-1">Partnership Description</label>
                                            <input type="text" name="industries[{{ $i }}][description]" class="form-control form-control-sm rounded-2" value="{{ $ind['description'] ?? '' }}" placeholder="Brief detail about training/collaboration">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold text-dark mb-1">Company Logo</label>
                                            <input type="file" name="industries[{{ $i }}][image]" class="form-control form-control-sm rounded-2" accept="image/*">
                                            @if(!empty($ind['image']))
                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                    <img src="{{ asset($ind['image']) }}" height="30" class="rounded border bg-white p-1">
                                                    <input type="hidden" name="industries[{{ $i }}][existing_image]" value="{{ $ind['image'] }}">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill remove-industry-btn mt-3">
                                                <i class="fa-solid fa-trash me-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: AWARDS & GALLERY -->
            <div class="tab-pane fade" id="awards-sec" role="tabpanel">
                <div class="card cms-card border-0 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                            <div class="cms-section-icon">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Awards & Excellence Gallery</h5>
                                <small class="text-muted">Manage certificates and achievements badges</small>
                            </div>
                        </div>

                        <div class="p-4 bg-light rounded-4 border text-center mb-4">
                            <i class="fa-solid fa-cloud-arrow-up fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold text-dark">Upload New Award Certificates</h6>
                            <p class="text-muted small mb-3">Choose multiple image files from your computer (.png, .jpg, .webp)</p>
                            <input type="file" name="awards[]" class="form-control rounded-3 w-50 mx-auto" multiple accept="image/*">
                        </div>

                        @if(!empty($about->awards))
                            <h6 class="fw-bold text-dark mb-3">Current Active Awards:</h6>
                            <div class="row g-3">
                                @foreach($about->awards as $index => $award)
                                    <div class="col-6 col-md-3 col-lg-2" id="award-box-{{ $index }}">
                                        <div class="award-card border position-relative bg-white p-2">
                                            <img src="{{ asset($award) }}" class="w-100 rounded-2" style="height: 110px; object-fit: cover;">
                                            <button type="button" onclick="deleteAward({{ $index }})" 
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle p-0 d-flex align-items-center justify-content-center shadow" 
                                                    style="width: 28px; height: 28px;" title="Delete Image">
                                                <i class="fa-solid fa-xmark fs-6"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Floating Bottom Action Bar -->
        <div class="card border-0 shadow-lg rounded-4 mt-4 text-white p-3" style="background: var(--admin-navy);">
            <div class="d-flex align-items-center justify-content-between">
                <span class="small text-white-50 ms-2 d-none d-md-inline">
                    <i class="fa-solid fa-circle-info text-warning me-1"></i> Make sure to review modifications before publishing.
                </span>
                <button type="submit" class="btn btn-gold-action ms-auto">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                </button>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
    // Dynamic Industry Rows Handling
    let industryIndex = {{ count($industries) }};
    document.getElementById('add-industry-btn').addEventListener('click', function() {
        const container = document.getElementById('industry-container');
        const html = `
            <div class="rounded-4 p-3 mb-3 industry-row">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-dark mb-1">Company / Entity Name</label>
                        <input type="text" name="industries[${industryIndex}][name]" class="form-control form-control-sm rounded-2" placeholder="e.g. Software House / Company">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-dark mb-1">Partnership Description</label>
                        <input type="text" name="industries[${industryIndex}][description]" class="form-control form-control-sm rounded-2" placeholder="Brief detail about training/collaboration">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-dark mb-1">Company Logo</label>
                        <input type="file" name="industries[${industryIndex}][image]" class="form-control form-control-sm rounded-2" accept="image/*">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill remove-industry-btn mt-3">
                            <i class="fa-solid fa-trash me-1"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        industryIndex++;
    });

    document.addEventListener('click', function(e) {
        if(e.target && e.target.closest('.remove-industry-btn')) {
            e.target.closest('.industry-row').remove();
        }
    });

    // Delete Award Image via AJAX
    function deleteAward(index) {
        if(confirm('Are you sure you want to delete this award image?')) {
            fetch("{{ route('admin.about.award.delete') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ index: index })
            }).then(res => res.json()).then(data => {
                if(data.status === 'success') {
                    document.getElementById(`award-box-${index}`).remove();
                }
            });
        }
    }
</script>
@endpush
@endsection