<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About LOGIX College - Vision, Mission & Faculty</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root { 
            --logix-navy-dark: #050d17;
            --logix-navy: #0b1a2e;
            --logix-gold: #d4af37; 
            --logix-gold-light: #fef08a;
            --logix-teal: #00d2c4;
            --slate-border: #e2e8f0;
            --slate-body: #f8fafc;
        }

        body { 
            background-color: var(--slate-body); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #334155; 
            overflow-x: hidden;
        }

        /* Top Executive Navigation Bar */
        .public-navbar { 
            background-color: var(--logix-navy-dark); 
            padding: 14px 0; 
            border-bottom: 2px solid rgba(212, 175, 55, 0.3); 
            backdrop-filter: blur(10px);
        }

        .brand-text-lg {
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.5px;
        }

        /* Header Hero Banner */
        .about-header-banner { 
            background: linear-gradient(180deg, var(--logix-navy-dark) 0%, var(--logix-navy) 100%); 
            color: #ffffff; 
            padding: 80px 0 70px 0; 
            position: relative;
            overflow: hidden;
        }

        .about-header-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 210, 196, 0.12) 0%, rgba(0,0,0,0) 70%);
            pointer-events: none;
        }

        .about-header-banner::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, rgba(0,0,0,0) 70%);
            pointer-events: none;
        }

        .badge-executive {
            background: rgba(212, 175, 55, 0.15);
            color: var(--logix-gold);
            border: 1px solid rgba(212, 175, 55, 0.3);
            font-size: 0.75rem;
            letter-spacing: 1.5px;
        }

        /* Modernized Feature Box */
        .feature-box { 
            background: #ffffff; 
            border-radius: 20px; 
            border: 1px solid var(--slate-border); 
            padding: 30px; 
            height: 100%; 
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1); 
            position: relative;
        }

        .feature-box:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.08); 
            border-color: #cbd5e1; 
        }

        .icon-circle-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Tutor / Faculty Modern Cards */
        .tutor-card { 
            background: #ffffff; 
            border-radius: 20px; 
            border: 1px solid var(--slate-border); 
            padding: 28px 24px; 
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1); 
            position: relative;
        }

        .tutor-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px -15px rgba(11, 26, 46, 0.12);
            border-color: var(--logix-gold); 
        }

        .tutor-img-wrapper {
            position: relative;
            display: inline-block;
        }

        .tutor-img { 
            width: 110px; 
            height: 110px; 
            object-fit: cover; 
            border-radius: 50%; 
            border: 3px solid #ffffff; 
            box-shadow: 0 0 0 3px var(--logix-gold);
        }

        .social-link-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .social-link-btn:hover {
            background: var(--logix-navy);
            color: var(--logix-gold);
            transform: translateY(-2px);
        }

        /* Expandable Text Styles */
        .expandable-text.short-view {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .expandable-text.full-view {
            display: block;
            overflow: visible;
        }

        .see-more-btn {
            color: var(--logix-navy) !important;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0;
            transition: color 0.2s ease;
        }

        .see-more-btn:hover {
            color: var(--logix-gold) !important;
        }

        /* Custom Card Light Box */
        .info-glass-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--slate-border);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.04);
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="public-navbar sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="text-white text-decoration-none fw-extrabold fs-4 brand-text-lg">
                <i class="fa-solid fa-graduation-cap text-gold me-2"></i>LOGIX <span class="text-gold">COLLEGE</span>
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-semibold border-opacity-25 fs-7">
                <i class="fa-solid fa-arrow-left me-1.5"></i> Return Home
            </a>
        </div>
    </nav>

    <!-- Header Banner -->
    <div class="about-header-banner text-center">
        <div class="container position-relative z-1">
            <span class="badge badge-executive px-3 py-2 rounded-pill fw-bold text-uppercase mb-3">
                Official Institutional Profile
            </span>
            <h1 class="fw-extrabold display-5 text-white mb-2 brand-text-lg">{{ $about->home_title ?? 'About LOGIX College' }}</h1>
            <p class="text-slate-300 mb-0 mx-auto fs-6" style="max-width: 650px; color: #cbd5e1;">
                Empowering the future through academic excellence, innovation, practical training, and industry-leading faculty.
            </p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container py-5">

        <!-- Our Vision Section -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="feature-box border-start border-4 border-warning shadow-sm">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="icon-circle-wrapper bg-warning-subtle text-warning-emphasis">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">Our Vision</h4>
                    </div>
                    <div class="expandable-container">
                        <p class="text-secondary leading-relaxed expandable-text short-view mb-2" style="font-size: 0.96rem; line-height: 1.7;">
                            {{ $about->our_vision ?? 'LOGIX College envisions becoming a premier technology institution delivering quality education, professional ethics, and future-ready IT infrastructure.' }}
                        </p>
                        <button class="btn btn-link text-decoration-none see-more-btn mt-1">
                            See More <i class="fa-solid fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why LOGIX College Section -->
        <div class="info-glass-card p-4 p-lg-5 mb-5">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="icon-circle-wrapper bg-primary-subtle text-primary fs-4">
                    <i class="{{ $about->why_logix_icon ?? 'fa-solid fa-graduation-cap' }}"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1">{{ $about->why_logix_title ?? 'Why Choose LOGIX College?' }}</h3>
                    <p class="text-muted small mb-0">Excellence in practical education & career transformation.</p>
                </div>
            </div>
            <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.98rem; line-height: 1.75;">
                {{ $about->why_logix_description ?? 'We offer cutting-edge labs, real-world project training, and direct industry mentorship.' }}
            </p>
        </div>

        <!-- Goals & Mission Grid -->
        <div class="row g-4 mb-5">
            <!-- Educational Goals -->
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle-wrapper bg-danger-subtle text-danger mb-3">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Educational Goals</h5>
                    <div class="expandable-container">
                        <p class="text-muted small expandable-text short-view mb-2" style="line-height: 1.6;">
                            {{ $about->educational_goals ?? 'Fostering practical technical skills and critical thinking.' }}
                        </p>
                        <button class="btn btn-link text-decoration-none see-more-btn">
                            See More <i class="fa-solid fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Our Mission -->
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle-wrapper bg-info-subtle text-info mb-3">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Our Mission</h5>
                    <div class="expandable-container">
                        <p class="text-muted small expandable-text short-view mb-2" style="line-height: 1.6;">
                            {{ $about->our_mission ?? 'To bridge the gap between academic education and industry standards.' }}
                        </p>
                        <button class="btn btn-link text-decoration-none see-more-btn">
                            See More <i class="fa-solid fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Specific Goals -->
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="icon-circle-wrapper bg-success-subtle text-success mb-3">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Specific Goals</h5>
                    <div class="expandable-container">
                        <p class="text-muted small expandable-text short-view mb-2" style="line-height: 1.6;">
                            {{ $about->specific_goals ?? 'Providing 100% practical lab experience and internship assistance.' }}
                        </p>
                        <button class="btn btn-link text-decoration-none see-more-btn">
                            See More <i class="fa-solid fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Industry Trained Professionals Section -->
        @if(!empty($about->industries) && count($about->industries) > 0)
            <div id="industry-sec" class="mb-5 pt-2">
                <div class="text-center mb-4">
                    <span class="text-uppercase text-gold fw-bold extra-small tracking-wider d-block mb-1">Collaboration</span>
                    <h3 class="fw-bold text-dark">Industry Partnerships</h3>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($about->industries as $ind)
                        <div class="col-lg-4 col-md-6">
                            <div class="info-glass-card p-4 text-center h-100 transition-all hover-top">
                                @if(!empty($ind['image']))
                                    <img src="{{ asset($ind['image']) }}" alt="{{ $ind['name'] }}" class="mx-auto my-2 rounded" style="max-height: 65px; object-fit: contain;">
                                @endif
                                <h5 class="fw-bold text-dark mb-1 mt-2">{{ $ind['name'] }}</h5>
                                <p class="text-secondary small mb-0">{{ $ind['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Awards Gallery Section -->
        @if(!empty($about->awards) && count($about->awards) > 0)
            <div id="certificates" class="mb-5 pt-2">
                <div class="text-center mb-4">
                    <span class="text-uppercase text-gold fw-bold extra-small tracking-wider d-block mb-1">Recognition</span>
                    <h3 class="fw-bold text-dark"><i class="fa-solid fa-trophy text-warning me-2"></i>Awards & Achievements</h3>
                </div>
                <div class="row g-3 justify-content-center">
                    @foreach($about->awards as $awardImg)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="info-glass-card overflow-hidden p-2">
                                <img src="{{ asset($awardImg) }}" alt="LOGIX Award" class="w-100 rounded-3" style="height: 180px; object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tutors / Faculty Section -->
        <div id="tutors" class="text-center mb-4 pt-3">
            <span class="badge bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                Expert Educators
            </span>
            <h2 class="fw-bold text-dark">Meet Our Faculty</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($allTutors as $tutor)
                <div class="col-lg-4 col-md-6">
                    <div class="tutor-card text-center h-100">
                        <div class="tutor-img-wrapper mb-3">
                            <img src="{{ asset($tutor->image) }}" alt="{{ $tutor->name }}" class="tutor-img">
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $tutor->name }}</h5>
                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill small mb-2 fw-semibold">{{ $tutor->rank }}</span>
                        <p class="text-secondary small mb-3" style="font-size: 0.85rem; line-height: 1.5;">{{ Str::limit($tutor->bio, 105) }}</p>

                        <div class="d-flex justify-content-center gap-2">
                            @if($tutor->twitter)<a href="{{ $tutor->twitter }}" target="_blank" class="social-link-btn" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>@endif
                            @if($tutor->linkedin)<a href="{{ $tutor->linkedin }}" target="_blank" class="social-link-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>@endif
                            @if($tutor->instagram)<a href="{{ $tutor->instagram }}" target="_blank" class="social-link-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                            @if($tutor->youtube)<a href="{{ $tutor->youtube }}" target="_blank" class="social-link-btn" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>@endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fa-solid fa-user-slash fs-2 d-block mb-2 text-slate-400"></i>
                    No faculty members listed at the moment.
                </div>
            @endforelse
        </div>

    </div>

    <!-- Bootstrap JS & Dynamic Expand/Collapse Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const seeMoreBtns = document.querySelectorAll('.see-more-btn');

            seeMoreBtns.forEach(btn => {
                const textElement = btn.previousElementSibling;

                if (textElement && textElement.scrollHeight <= textElement.clientHeight) {
                    btn.style.display = 'none';
                }

                btn.addEventListener('click', function () {
                    if (textElement.classList.contains('short-view')) {
                        textElement.classList.remove('short-view');
                        textElement.classList.add('full-view');
                        this.innerHTML = 'See Less <i class="fa-solid fa-chevron-up ms-1"></i>';
                    } else {
                        textElement.classList.remove('full-view');
                        textElement.classList.add('short-view');
                        this.innerHTML = 'See More <i class="fa-solid fa-chevron-down ms-1"></i>';
                    }
                });
            });
        });
    </script>
</body>
</html>