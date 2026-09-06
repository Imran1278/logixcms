{{-- File Path: resources/views/student/dashboard.blade.php --}}
@php
    $currentUser = $student ?? $user ?? auth()->user();
    
    $studentName = strtoupper($currentUser->name ?? 'STUDENT');
    $studentEmail = $currentUser->email ?? '';
    $studentCnic = $currentUser->cnic ?? 'N/A';
    
    // Dynamic Address Logic
    $studentAddress = $currentUser->residential_address 
        ?? $currentUser->home_address 
        ?? $currentUser->address 
        ?? $currentUser->admission->residential_address 
        ?? 'LOGIX College Sargodha';
    
    // Dynamic Avatar Logic
    $rawPic = $currentUser->picture ?? $currentUser->admission->picture ?? null;
    $studentPic = $avatarUrl ?? (
        (!empty($rawPic) && \Illuminate\Support\Facades\Storage::disk('public')->exists($rawPic))
            ? asset('storage/' . ltrim($rawPic, '/')) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser->name ?? 'Student') . '&background=0A2D5A&color=CFAE4E'
    );

    // Profile Completion Check
    $isProfileDone = (bool) (
        ($currentUser->profile_completed ?? 0) == 1 
        || ($currentUser->is_profile_complete ?? 0) == 1 
        || (!empty($currentUser->cnic) && !empty($currentUser->mobile_contact ?? $currentUser->phone) && !empty($currentUser->father_name))
        || !empty($currentUser->admission_id)
    );
    
    // Safety Fallbacks
    $coursesList = $coursesList ?? $courses ?? $availableCourses ?? collect();
    $batchesList = $batchesList ?? $batches ?? $availableBatches ?? collect();
    $is2faActive = !empty($currentUser->google2fa_secret) && ($currentUser->google2fa_enabled ?? $currentUser->is_2fa_enabled ?? false);
@endphp

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | LOGIX College</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/student-dashboard.css') }}">

    <style>
        /* Floating AI Chatbot Container Alignment */
        .student-floating-chatbot-wrapper {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 1050;
        }
    </style>
</head>
<body>

    @include('student.partials.sidebar')

    <main class="acad-main-wrapper">

        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3 p-3 react-card">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ $studentPic }}" alt="{{ $studentName }}" class="rounded-circle border border-warning shadow-sm" style="width: 55px; height: 55px; object-fit: cover;">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="fw-bold mb-0 text-theme-primary">WELCOME, {{ $studentName }}</h4>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill fs-8">Student</span>
                    </div>
                    <small class="text-theme-muted d-block mt-1">
                        <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $studentAddress }}
                    </small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-warning btn-sm fw-bold rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#courseFinderModal">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Course Finder
                </button>
                @include('course_finder.index')

                <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>

                @if(!$is2faActive)
                    <button class="btn btn-gold btn-sm fw-bold shadow-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#enable2faModal">
                        <i class="fa-solid fa-shield-halved me-1"></i> Setup 2FA
                    </button>
                @else
                    <button class="btn btn-success btn-sm fw-bold shadow-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#checkInModal">
                        <i class="fa-solid fa-clock me-1"></i> Daily Check-In
                    </button>
                @endif

                <div class="portal-badge d-flex align-items-center gap-2 px-3 py-2 box-subtle rounded-pill">
                    <span class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 22px; height: 22px; font-size: 0.65rem;">A</span>
                    <span class="fw-bold text-theme-primary fs-8">STUDENT PORTAL</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(!$isProfileDone)
            <div class="react-card mb-4" style="border-left: 5px solid var(--color-gold); background: var(--box-subtle-bg);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation fs-3 text-warning"></i>
                        <div>
                            <h6 class="fw-bold text-theme-primary mb-1">Profile Action Required</h6>
                            <p class="text-theme-muted small mb-0">Please complete your educational profile to enable complete portal features.</p>
                        </div>
                    </div>
                    <button onclick="switchTab('profile')" class="btn btn-gold btn-sm fw-bold px-3 py-2 rounded-3">
                        Complete Profile
                    </button>
                </div>
            </div>
        @endif

        <div id="section-dashboard" class="tab-section active-section">
            <div class="mb-4">
                <div class="fw-bold fs-7 text-uppercase text-theme-muted mb-2 letter-spacing-1"><i class="fa-solid fa-chart-simple me-1"></i> Quick Analytics</div>
                @include('student.partials.stats')
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="react-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1 fs-7">
                                <i class="fa-solid fa-book-open text-warning me-2"></i> My Enrolled & Assigned Courses
                            </h6>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-8">Admin Sync</span>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            @forelse($coursesList as $index => $cItem)
                                @php
                                    $courseTitle = $cItem->course_name ?? $cItem->title ?? $cItem->name ?? 'Course Title';
                                    $courseCode  = $cItem->course_code ?? $cItem->code ?? 'CRS-'.($index + 1);
                                    $duration    = $cItem->duration ?? '3';
                                    $durationType = $cItem->duration_type ?? 'Months';
                                @endphp
                                <div class="box-subtle rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span class="badge bg-dark text-warning fs-8 font-monospace mb-1">{{ $courseCode }}</span>
                                            <h6 class="fw-bold text-theme-primary mb-0">{{ $courseTitle }}</h6>
                                        </div>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle fs-8">Active Enrolled</span>
                                    </div>
                                    <div class="progress-bar-custom my-2">
                                        <div class="progress-bar-fill" style="width: {{ 50 + ($index * 15) % 45 }}%;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-theme-muted fw-semibold fs-8"><i class="fa-regular fa-clock me-1"></i> Duration: {{ $duration }} {{ $durationType }}</small>
                                        <small class="text-theme-primary fw-bold fs-8">Progress: {{ 50 + ($index * 15) % 45 }}%</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-theme-muted py-5 box-subtle rounded-3">
                                    <i class="fa-solid fa-graduation-cap fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    <span class="fs-8 fw-semibold">No enrolled courses assigned yet by Admin.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="react-card mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1 fs-7"><i class="fa-regular fa-calendar-days text-info me-2"></i> Academic Schedule</h6>
                                <span id="calendar-month-year" class="fw-semibold text-theme-muted fs-8">Loading...</span>
                            </div>
                            <div class="d-flex gap-1">
                                <button id="prev-month-btn" class="btn btn-sm btn-outline-secondary py-0 px-2">
                                    <i class="fa-solid fa-chevron-left fs-8"></i>
                                </button>
                                <button id="next-month-btn" class="btn btn-sm btn-outline-secondary py-0 px-2">
                                    <i class="fa-solid fa-chevron-right fs-8"></i>
                                </button>
                            </div>
                        </div>

                        <div class="calendar-wrapper">
                            <div class="schedule-grid text-center">
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Sun</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Mon</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Tue</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Wed</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Thu</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Fri</div></div>
                                <div><div class="schedule-day-header text-theme-muted fw-bold fs-8">Sat</div></div>
                            </div>
                            <div id="calendar-days-container" class="schedule-grid text-center mt-2"></div>
                        </div>
                    </div>

                    <div class="react-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1 fs-7">
                                <i class="fa-solid fa-bullhorn text-warning me-2"></i> Announcements & News
                            </h6>
                            <span class="badge badge-gold fs-8">Live</span>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            @php
                                $hasNews = !empty($latestNews) && count($latestNews) > 0;
                                $hasPress = !empty($pressReleases) && count($pressReleases) > 0;
                            @endphp

                            @if($hasNews)
                                @foreach($latestNews as $news)
                                    @php
                                        $newsTitle = is_array($news) ? ($news['title'] ?? '') : ($news->title ?? '');
                                        $newsDate  = is_array($news) ? ($news['news_date'] ?? $news['created_at'] ?? now()) : ($news->news_date ?? $news->created_at ?? now());
                                        $newsDesc  = is_array($news) ? ($news['description'] ?? 'No description available.') : ($news->description ?? 'No description available.');
                                        $newsId    = is_array($news) ? ($news['id'] ?? $loop->index) : ($news->id ?? $loop->index);
                                    @endphp
                                    <div class="d-flex align-items-start gap-2 border-bottom border-theme pb-2">
                                        <div class="rounded-circle bg-warning-subtle text-warning p-2 flex-shrink-0" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fa-solid fa-bullhorn fs-7"></i>
                                        </div>
                                        <div class="w-100">
                                            <div class="fw-bold text-theme-primary fs-8 d-flex justify-content-between align-items-center">
                                                <a href="javascript:void(0)" class="text-theme-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal{{ $newsId }}">
                                                    {{ Str::limit($newsTitle, 45) }}
                                                </a>
                                                <span class="badge bg-light text-secondary border fs-8">News</span>
                                            </div>
                                            <small class="text-theme-muted fs-8">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($newsDate)->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="newsModal{{ $newsId }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold text-theme-primary fs-6">{{ $newsTitle }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <small class="text-theme-muted d-block mb-2">
                                                        Published: {{ \Carbon\Carbon::parse($newsDate)->format('d M, Y') }}
                                                    </small>
                                                    <p class="text-theme-muted small lh-base mb-0">
                                                        {{ $newsDesc }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if($hasPress)
                                @foreach($pressReleases as $press)
                                    @php
                                        $pressTitle = is_array($press) ? ($press['title'] ?? '') : ($press->title ?? '');
                                        $pressDate  = is_array($press) ? ($press['created_at'] ?? now()) : ($press->created_at ?? now());
                                    @endphp
                                    <div class="d-flex align-items-start gap-2 border-bottom border-theme pb-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary p-2 flex-shrink-0" style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fa-solid fa-newspaper fs-7"></i>
                                        </div>
                                        <div class="w-100">
                                            <div class="fw-bold text-theme-primary fs-8 d-flex justify-content-between align-items-center">
                                                <span>{{ Str::limit($pressTitle, 45) }}</span>
                                                <span class="badge bg-light text-primary border fs-8">Press</span>
                                            </div>
                                            <small class="text-theme-muted fs-8">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($pressDate)->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if(!$hasNews && !$hasPress)
                                <div class="text-center text-theme-muted py-3">
                                    <i class="fa-solid fa-bell-slash fs-4 d-block mb-1 text-secondary"></i>
                                    <span class="fs-8">No recent announcements or news releases.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="react-card mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3 col-6">
                        <div class="footer-link-title text-theme-muted fw-bold fs-8 text-uppercase mb-2">QUICK LINKS</div>
                        <div class="footer-links d-flex flex-column gap-1 fs-8">
                            <a href="{{ Route::has('about.details') ? route('about.details') : '#' }}" class="text-theme-muted text-decoration-none">About Details</a>
                            <a href="{{ Route::has('student.downloads') ? route('student.downloads') : '#' }}" class="text-theme-muted text-decoration-none">Downloads</a>
                            <a href="{{ Route::has('contact.index') ? route('contact.index') : '#' }}" class="text-theme-muted text-decoration-none">Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="footer-link-title text-theme-muted fw-bold fs-8 text-uppercase mb-2">ACADEMICS</div>
                        <div class="footer-links d-flex flex-column gap-1 fs-8">
                            <a href="#" class="text-theme-muted text-decoration-none">New Learning</a>
                            <a href="#" class="text-theme-muted text-decoration-none">Team Services</a>
                            <a href="#" class="text-theme-muted text-decoration-none">Campus Portal</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="footer-link-title text-theme-muted fw-bold fs-8 text-uppercase mb-2">PORTAL SERVICES</div>
                        <div class="footer-links d-flex flex-column gap-1 fs-8">
                            <a href="#" class="text-theme-muted text-decoration-none">Virtual Library</a>
                            <a href="#" class="text-theme-muted text-decoration-none">Career Services</a>
                            <a href="#" class="text-theme-muted text-decoration-none">Support Desk</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 text-md-end text-center">
                        <div class="footer-link-title text-theme-muted fw-bold fs-8 text-uppercase mb-2">ACCREDITATIONS</div>
                        <div class="d-flex align-items-center justify-content-md-end justify-content-center gap-2 flex-wrap">
                            @forelse($accreditations ?? [] as $acc)
                                @if(!empty($acc['name']))
                                    <span class="badge bg-light text-dark border p-2 fs-8 d-inline-flex align-items-center gap-1 shadow-sm" title="{{ $acc['description'] ?? $acc['name'] }}">
                                        @if(!empty($acc['image']))
                                            <img src="{{ asset($acc['image']) }}" alt="{{ $acc['name'] }}" style="height: 16px; width: auto; max-width: 24px; object-fit: contain;">
                                        @else
                                            <i class="fa-solid fa-building-user text-primary me-1"></i>
                                        @endif
                                        <span>{{ $acc['name'] }}</span>
                                    </span>
                                @endif
                            @empty
                                <span class="badge box-subtle text-theme-primary border p-2 fs-8"><i class="fa-solid fa-globe text-primary me-1"></i> Global Ed</span>
                                <span class="badge box-subtle text-theme-primary border p-2 fs-8"><i class="fa-solid fa-microchip text-info me-1"></i> Tech Council</span>
                                <span class="badge bg-dark text-warning border p-2 fs-8"><i class="fa-solid fa-graduation-cap text-warning me-1"></i> LOGIX VU</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <hr class="my-3 border-theme">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 fs-8 text-theme-muted">
                    <div class="d-flex gap-3">
                        <span><a href="https://www.logix.edu.pk" target="_blank" class="text-decoration-none text-theme-muted"><i class="fa-solid fa-globe me-1"></i> www.logix.edu.pk</a></span>
                        <span><a href="mailto:info@logix.edu.pk" class="text-decoration-none text-theme-muted"><i class="fa-regular fa-envelope me-1"></i> info@logix.edu.pk</a></span>
                    </div>
                    <div class="fw-bold text-theme-primary px-3 py-1 box-subtle rounded-pill">SINCE-2002</div>
                    <div class="d-flex gap-2 fs-7">
                        <a href="https://www.facebook.com/LOGIXCollege/" target="_blank" class="text-theme-muted"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com/logix.college.2000" target="_blank" class="text-theme-muted"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/LogixCollege" target="_blank" class="text-theme-muted"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="https://twitter.com/logixcollege" target="_blank" class="text-theme-muted"><i class="fa-brands fa-x"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-downloads" class="tab-section" style="display: none;">
            <div class="container-fluid px-0">
        
                <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-4 rounded-4 shadow-sm border border-slate-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 text-white shadow-sm" style="background: linear-gradient(135deg, var(--admin-navy, #0A2D5A) 0%, #051329 100%); border: 1px solid rgba(207, 174, 78, 0.3);">
                            <i class="fa-solid fa-cloud-arrow-down fs-4" style="color: var(--admin-gold, #CFAE4E);"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Downloads & Official Documents</h4>
                            <p class="text-muted small mb-0">Access and download institutional forms, fee structures, notices, and study guidelines.</p>
                        </div>
                    </div>
                    <div class="badge bg-light text-dark border px-3 py-2.5 rounded-pill d-flex align-items-center gap-2 shadow-xs">
                        <span class="rounded-circle" style="width: 9px; height: 9px; background-color: #10B981;"></span>
                        <span class="fw-bold text-secondary">Categories Available: <strong class="text-dark">{{ count($downloads ?? []) }}</strong></span>
                    </div>
                </div>
        
                @if(isset($downloads) && count($downloads) > 0)
                    @foreach($downloads as $categoryName => $items)
                        <div class="border rounded-4 bg-white mb-4 shadow-sm overflow-hidden">
                            <div class="p-3 px-4 text-white d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #0A2D5A 0%, #051329 100%); border-bottom: 2px solid #CFAE4E;">
                                <span class="d-flex align-items-center gap-2 fw-bold">
                                    <i class="fa-solid fa-folder-tree" style="color: #CFAE4E;"></i> {{ $categoryName }}
                                </span>
                                <span class="badge bg-white text-dark fw-bold px-3 py-1 rounded-pill">{{ count($items) }} Files</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr class="text-uppercase fs-8 text-secondary">
                                                <th class="ps-4" style="width: 50px;">#</th>
                                                <th>Document Title & Description</th>
                                                <th>File Format</th>
                                                <th>Published Date</th>
                                                <th class="text-center pe-4" style="width: 180px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $file)
                                                <tr>
                                                    <td class="ps-4 font-monospace text-muted small">{{ $loop->iteration }}</td>
                                                    <td class="py-3">
                                                        <div class="fw-bold text-dark">{{ $file->title }}</div>
                                                        @if($file->description)
                                                            <div class="small text-muted">{{ $file->description }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $ext = strtolower($file->file_type ?? pathinfo($file->file_path, PATHINFO_EXTENSION));
                                                            $badgeClass = match($ext) {
                                                                'pdf' => 'bg-danger-subtle text-danger border-danger',
                                                                'doc', 'docx' => 'bg-primary-subtle text-primary border-primary',
                                                                'zip', 'rar' => 'bg-warning-subtle text-warning-emphasis border-warning',
                                                                default => 'bg-info-subtle text-info border-info'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} text-uppercase border fw-bold px-2.5 py-1">
                                                            {{ $ext ?: 'FILE' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="small text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ $file->created_at?->format('d M, Y') }}</span>
                                                    </td>
                                                    <td class="text-center pe-4">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Preview">
                                                                <i class="fa-solid fa-eye me-1"></i> View
                                                            </a>
                                                            <a href="{{ asset($file->file_path) }}" download class="btn btn-sm text-dark fw-bold rounded-pill px-3 shadow-xs" style="background-color: #CFAE4E; border: 1px solid #CFAE4E;" title="Download File">
                                                                <i class="fa-solid fa-download me-1"></i> Download
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="border rounded-4 bg-white text-center py-5 shadow-sm">
                        <i class="fa-solid fa-folder-open text-muted display-5 mb-3 opacity-50"></i>
                        <h5 class="fw-bold text-dark">No Documents Available</h5>
                        <p class="text-muted small mb-0">There are no downloadable resources uploaded by administration yet.</p>
                    </div>
                @endif
        
            </div>
        </div>

        <!-- TAB SECTIONS -->
        <div id="section-profile" class="tab-section">
            @include('student.partials.profile-form')
        </div>
        <div id="section-fees" class="tab-section">
            @include('student.partials.fee-details')
        </div>
        <div id="section-courses" class="tab-section">
            @include('student.partials.courses-list')
        </div>
        <div id="section-inquiries" class="tab-section">
            @include('student.partials.inquiries')
        </div>
        <div id="section-downloads" class="tab-section">
            @include('student.downloads')
        </div>
        <div id="section-attendances" class="tab-section">
            @include('student.partials.attendance')
        </div>

    </main>

    <!-- Include AI Chatbot Blade Partial (from resources/views/frontend/includes/chatbot.blade.php) -->
    <div class="student-floating-chatbot-wrapper">
        @include('frontend.includes.chatbot')
    </div>

    <!-- Modals & Scripts -->
    <div class="modal fade" id="enable2faModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-theme-primary fs-6"><i class="fa-solid fa-shield-halved text-warning me-2"></i>Setup 2FA Authentication</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('student.attendance.enable2fa') }}" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        <p class="text-theme-muted small mb-3">Scan this QR Code in <strong>Google Authenticator App</strong> and enter the 6-digit verification code below.</p>
                        <div class="d-inline-block border p-2 rounded box-subtle mb-3">
                            {!! $qrCodeSvg ?? '' !!}
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold text-theme-primary fs-7">6-Digit Authenticator Code</label>
                            <input type="text" name="one_time_password" class="form-control text-center fs-5 tracking-widest" placeholder="123456" maxlength="6" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light btn-sm fw-bold px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gold btn-sm fw-bold px-4">Verify & Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="checkInModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-theme-primary fs-6"><i class="fa-solid fa-clock text-success me-2"></i>Daily Check-In</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('student.attendance.checkin') }}" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        <p class="text-theme-muted small mb-2">Enter OTP from Google Authenticator App to mark today's attendance.</p>
                        <div class="mb-3 text-start">
                            <input type="text" name="otp_code" class="form-control text-center fs-5 tracking-widest" placeholder="6-Digit OTP" maxlength="6" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light btn-sm fw-bold px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm fw-bold px-4">Check In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/student-dashboard.js') }}"></script>

</body>
</html>