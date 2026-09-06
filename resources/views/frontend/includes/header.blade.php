@php
    use App\Models\HeaderSetting;
    use Illuminate\Support\Facades\Route;

    // Helper function to dynamically resolve route name or direct URL
    $resolveUrl = function ($value, $defaultRoute = '#') {
        if (empty($value) || $value === '#') {
            return $defaultRoute !== '#' && Route::has($defaultRoute) ? route($defaultRoute) : '#';
        }
        if (Route::has($value)) {
            return route($value);
        }
        return url($value);
    };

    // Header Basic Info
    $topAddress  = HeaderSetting::getByKey('top_address', 'Main Campus, Club Road, Sargodha');
    $topPhone    = HeaderSetting::getByKey('top_phone', '+92 48 3220901');
    $topWhatsapp = HeaderSetting::getByKey('top_whatsapp', '0346-8667400');
    $siteLogo    = HeaderSetting::getByKey('site_logo');

    // Navigation Menu Labels & Auto Resolved URLs
    $nav1Text = HeaderSetting::getByKey('nav1_text', 'HOME');
    $nav1Url  = $resolveUrl(HeaderSetting::getByKey('nav1_link', '/'), '/');

    $nav2Text = HeaderSetting::getByKey('nav2_text', 'ABOUT US');
    $nav2Url  = $resolveUrl(HeaderSetting::getByKey('nav2_link', 'about.details'), 'about.details');

    $nav3Text = HeaderSetting::getByKey('nav3_text', 'ACADEMIC PROGRAMS');
    $nav3Url  = $resolveUrl(HeaderSetting::getByKey('nav3_link', 'courses.all'), 'courses.all');

    $nav4Text = HeaderSetting::getByKey('nav4_text', 'E-CAMPUS');
    $nav4Url  = $resolveUrl(HeaderSetting::getByKey('nav4_link', '#'), '#');

    $nav5Text = HeaderSetting::getByKey('nav5_text', 'CONTACT');
    $nav5Url  = $resolveUrl(HeaderSetting::getByKey('nav5_link', '#'), '#');

    // Top Bar Action Buttons Labels & Auto Resolved URLs
    $btn1Text = HeaderSetting::getByKey('btn1_text', 'COURSE FINDER');
    $btn1Val  = HeaderSetting::getByKey('btn1_link', '#');
    $btn1Url  = $btn1Val === '#' ? '#' : $resolveUrl($btn1Val, '#');

    $btn2Text = HeaderSetting::getByKey('btn2_text', 'FORMS');
    $btn2Url  = $resolveUrl(HeaderSetting::getByKey('btn2_link', 'downloads.index'), 'downloads.index');

    $btn3Text = HeaderSetting::getByKey('btn3_text', 'STUDENT LOGIN');
    $btn3Url  = $resolveUrl(HeaderSetting::getByKey('btn3_link', 'student.login'), 'student.login');

    $dashUrl  = Route::has('student.dashboard') ? route('student.dashboard') : (Route::has('dashboard') ? route('dashboard') : '#');
@endphp

<!-- Google Fonts & FontAwesome -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --brand-primary: #0B3067;
        --brand-dark: #0F1E36;
        --brand-gold: #D4AF37;
        --brand-gold-hover: #C59B27;
        --brand-light: #EBF3FA;
        --brand-muted: #707070;
        --brand-white: #FFFFFF;
    }

    /* Top Bar Modern Design */
    .top-bar {
        background: linear-gradient(90deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
        padding: 8px 0;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
        border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        max-height: 50px;
    }

    .top-bar a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .top-bar a:hover {
        color: var(--brand-gold);
    }

    .top-bar .info-item {
        margin-right: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .top-bar .info-item i {
        color: var(--brand-gold);
    }

    /* Action Pill Buttons */
    .btn-header-action {
        background: rgba(212, 175, 55, 0.15);
        color: var(--brand-gold) !important;
        border: 1px solid var(--brand-gold);
        border-radius: 50px;
        padding: 5px 16px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-header-action:hover {
        background: var(--brand-gold);
        color: var(--brand-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .btn-header-action:hover i {
        color: var(--brand-dark) !important;
    }

    .btn-student-cta {
        background: var(--brand-gold);
        color: var(--brand-dark) !important;
        border-radius: 50px;
        padding: 7px 22px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-decoration: none;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 10px rgba(212, 175, 55, 0.25);
    }

    .btn-student-cta:hover {
        background: var(--brand-gold-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
    }

    .btn-student-logout {
        background: #dc3545;
        color: #ffffff !important;
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 11px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-student-logout:hover {
        background: #bb2d3b;
        transform: translateY(-1px);
    }

    /* Main Header & Navbar */
    .site-header {
        position: sticky;
        top: 0;
        z-index: 1050;
        width: 100%;
        background: var(--brand-white);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .site-header.is-sticky .top-bar {
        max-height: 0;
        padding: 0;
        opacity: 0;
        border: none;
    }

    .main-navbar {
        padding: 12px 0;
        background: var(--brand-white);
        transition: padding 0.3s ease;
    }

    .brand-logo-text {
        font-family: 'Montserrat', sans-serif;
        font-size: 26px;
        font-weight: 900;
        color: var(--brand-primary);
        letter-spacing: -0.5px;
    }

    .brand-logo-text span {
        color: var(--brand-gold);
    }

    .brand-subtext {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 2.5px;
        color: var(--brand-dark);
        display: block;
        margin-top: -4px;
    }

    /* Header Nav Links with Dynamic Animated Underline (Target Design Match) */
    .nav-link-custom {
        color: var(--brand-dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 10px 18px !important;
        text-decoration: none;
        position: relative;
        transition: color 0.3s ease;
    }

    .nav-link-custom::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        width: 0;
        height: 3px;
        background-color: var(--brand-gold);
        border-radius: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(-50%);
    }

    .nav-link-custom:hover {
        color: var(--brand-primary) !important;
    }

    .nav-link-custom:hover::after,
    .nav-link-custom.active::after {
        width: 60%;
    }

    .nav-link-custom.active {
        color: var(--brand-primary) !important;
    }
</style>

<header id="mainHeader" class="site-header">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container-fluid px-lg-5">
            <div class="row align-items-center">
                <!-- Left Info Items -->
                <div class="col-lg-7 col-12 d-flex align-items-center flex-wrap">
                    <span class="info-item">
                        <i class="fa-solid fa-location-dot"></i> {{ $topAddress }}
                    </span>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $topPhone) }}" class="info-item">
                        <i class="fa-solid fa-phone"></i> {{ $topPhone }}
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $topWhatsapp) }}" class="info-item" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i> {{ $topWhatsapp }}
                    </a>
                </div>

                <!-- Right Action Buttons -->
                <div class="col-lg-5 col-12 d-flex justify-content-lg-end justify-content-center align-items-center gap-2 mt-lg-0 mt-2">
                    @if($btn1Url === '#')
                        <button type="button" class="btn-header-action" data-bs-toggle="modal" data-bs-target="#courseFinderModal">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>{{ $btn1Text }}</span>
                        </button>
                    @else
                        <a href="{{ $btn1Url }}" class="btn-header-action">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>{{ $btn1Text }}</span>
                        </a>
                    @endif

                    <a href="{{ $btn2Url }}" class="btn-header-action">
                        <i class="fa-solid fa-file-arrow-down"></i> {{ $btn2Text }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container-fluid px-lg-5">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="LOGIX Logo" height="45" class="object-fit-contain">
                @else
                    <div>
                        <span class="brand-logo-text">LOGIX<span>.</span></span>
                        <span class="brand-subtext">COLLEGE</span>
                    </div>
                @endif
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                <i class="fa-solid fa-bars fs-3" style="color: var(--brand-primary);"></i>
            </button>

            <!-- Navigation Links + CTA Button -->
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link-custom {{ request()->is('/') ? 'active' : '' }}" href="{{ $nav1Url }}">{{ $nav1Text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom {{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ $nav2Url }}">{{ $nav2Text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ $nav3Url }}">{{ $nav3Text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ $nav4Url }}">{{ $nav4Text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ $nav5Url }}">{{ $nav5Text }}</a>
                    </li>
                </ul>

                <!-- High-Impact CTA Button (Target Design Style) -->
                <div class="d-flex align-items-center gap-2 ms-lg-3">
                    @auth
                        <a href="{{ $dashUrl }}" class="btn-student-cta d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-gauge-high"></i> DASHBOARD
                        </a>
                        <form action="{{ route('student.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-student-logout border-0">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> LOGOUT
                            </button>
                        </form>
                    @else
                        <a href="{{ $btn3Url }}" class="btn-student-cta d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-graduate"></i> {{ $btn3Text }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 80) {
                header.classList.add('is-sticky');
            } else {
                header.classList.remove('is-sticky');
            }
        }, { passive: true });
    });
</script>