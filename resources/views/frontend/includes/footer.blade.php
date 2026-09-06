@php
    $footerData = \App\Models\Footer::first();
    
    // Dynamic Courses: Fetch active courses added by Admin
    try {
        $popularCourses = \App\Models\Course::where('status', 1)->latest()->take(3)->get();
        if($popularCourses->isEmpty()) {
            $popularCourses = \App\Models\Course::latest()->take(3)->get();
        }
    } catch (\Exception $e) {
        $popularCourses = collect();
    }
@endphp

<!-- Dark Luxury Navy Footer Component (Exact Image Design Match) -->
<footer class="elite-navy-footer position-relative pt-5 pb-4">
    <div class="container py-lg-2">
        <div class="row g-4 pb-4">
            
            <!-- Column 1: Brand Logo, Address & Circular Social Icons -->
            <div class="col-lg-3 col-md-6">
                <!-- Brand Header -->
                <div class="footer-brand mb-3 d-flex align-items-center gap-2">
                    <div class="brand-shield-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="brand-title d-block fw-extrabold text-white">LOGIX</span>
                        <span class="brand-subtitle d-block text-gold">COLLEGE</span>
                    </div>
                </div>

                <!-- Address & About -->
                <p class="footer-desc-text mb-3">
                    {{ $footerData?->about_description ?? 'LOGIX College is working since 2000. ISO Certified educational institution.' }}
                </p>

                <div class="d-flex align-items-start gap-2 footer-location-text mb-4">
                    <i class="fa-solid fa-location-dot text-gold mt-1"></i>
                    <span>Sargodha, Punjab, Pakistan</span>
                </div>
                
                <!-- Circular Gold Social Icons (Exact Image Match) -->
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ $footerData?->phone_number ? 'tel:'.$footerData->phone_number : '#' }}" class="social-circle-btn" aria-label="Phone">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    <a href="{{ $footerData?->facebook_url ?? '#' }}" class="social-circle-btn" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{ $footerData?->instagram_url ?? '#' }}" class="social-circle-btn" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="{{ $footerData?->linkedin_url ?? '#' }}" class="social-circle-btn" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-lg-3 col-md-6 ps-lg-4">
                <h5 class="footer-col-title mb-3">Quick Links</h5>
                <ul class="list-unstyled footer-menu-links mb-0">
                    <li class="mb-2"><a href="#">Home</a></li>
                    <li class="mb-2"><a href="#">About</a></li>
                    <li class="mb-2">
                        <a href="{{ \Illuminate\Support\Facades\Route::has('courses.all') ? route('courses.all') : '#' }}">
                            Courses
                        </a>
                    </li>
                    <li class="mb-2"><a href="#">Press</a></li>
                    <li class="mb-2"><a href="#">Contact</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info / Popular Courses -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-col-title mb-3">Contact Info</h5>
                <ul class="list-unstyled footer-contact-links mb-3">
                    <li class="mb-2">
                        <span class="d-block text-slate-light small">Phone:</span>
                        <span class="fw-bold text-white small">{{ $footerData?->phone_number ?? '+92 48 3220901 / 0346-8667400' }}</span>
                    </li>
                    <li class="mb-2">
                        <span class="d-block text-slate-light small">Hours:</span>
                        <span class="fw-bold text-white small">{{ $footerData?->working_hours ?? 'MON to SAT (8 AM TO 6 PM)' }}</span>
                    </li>
                </ul>

                <!-- Popular Courses Subsection -->
                <div class="popular-courses-mini">
                    <span class="d-block text-gold extra-small fw-bold text-uppercase mb-2">Featured Programs</span>
                    @forelse($popularCourses as $course)
                        <a href="{{ \Illuminate\Support\Facades\Route::has('courses.show') ? route('courses.show', $course->id) : '#' }}" class="d-block text-decoration-none text-slate-light small mb-1 hover-gold">
                            • {{ $course->course_name ?? $course->title ?? $course->name ?? 'Course Title' }}
                        </a>
                    @empty
                        <span class="d-block text-slate-light small mb-1">• Software Development</span>
                        <span class="d-block text-slate-light small mb-1">• Web Technologies</span>
                    @endforelse
                </div>
            </div>

            <!-- Column 4: Newsletter Signup & Form (Exact Image Design Match) -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-col-title mb-2">Newsletter Signup</h5>
                <p class="footer-desc-text small mb-3">
                    Sign up to receive newsletter and new updates.
                </p>

               <!-- Student Quick Sign-In Form -->
                <form action="{{ route('student.quick.login') }}" method="GET" class="newsletter-gold-form">
                    <div class="mb-2">
                        <input type="email" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" class="form-control gold-newsletter-input shadow-none" placeholder="Enter Student Email" required>
                    </div>
                    <button class="btn btn-gold-solid-block w-100 fw-bold" type="submit">
                        SIGN IN
                    </button>
                </form>
            </div>

        </div>

        <!-- Footer Bottom Bar Divider & Copyright -->
        <div class="footer-thin-bottom border-top pt-4 mt-2 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <p class="copyright-slate-text mb-0">
                    {{ $footerData?->copyright_text ?? 'Copyright © ' . date('Y') . ' LOGIX COLLEGE. All Rights Reserved.' }}
                </p>

                @guest
                    <a href="{{ \Illuminate\Support\Facades\Route::has('login') ? route('login') : '#' }}" class="admin-stealth-link text-decoration-none">
                        <i class="fa-solid fa-user-gear me-1"></i> Admin
                    </a>
                @else
                    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.dashboard') ? route('admin.dashboard') : route('login') }}" class="admin-stealth-link text-decoration-none">
                        <i class="fa-solid fa-gauge me-1"></i> Dashboard
                    </a>
                @endguest
            </div>

            <div class="text-slate-muted extra-small">
                #LOGIX2026
            </div>
        </div>

    </div>
</footer>

<!-- Styling Matching Provided Image Aesthetics -->
<style>
    :root {
        --navy-bg-dark: #0B1623;
        --gold-primary: #D4AF37;
        --gold-btn-gradient: linear-gradient(180deg, #EAD074 0%, #C49A21 100%);
        --text-slate: #94A3B8;
        --text-slate-light: #CBD5E1;
    }

    .extra-small {
        font-size: 0.75rem;
    }

    .text-gold {
        color: var(--gold-primary) !important;
    }

    .text-slate-light {
        color: var(--text-slate-light) !important;
    }

    .elite-navy-footer {
        background-color: var(--navy-bg-dark);
        color: var(--text-slate);
        font-size: 0.88rem;
    }

    /* Brand Logo Shield Box */
    .brand-shield-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--gold-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-primary);
        font-size: 1.1rem;
    }

    .brand-title {
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .brand-subtitle {
        font-size: 0.65rem;
        letter-spacing: 1.5px;
        font-weight: 800;
    }

    .footer-col-title {
        color: #FFFFFF;
        font-weight: 700;
        font-size: 1rem;
    }

    .footer-desc-text {
        color: var(--text-slate);
        line-height: 1.5;
        font-size: 0.85rem;
    }

    .footer-location-text {
        color: var(--text-slate-light);
        font-size: 0.85rem;
    }

    /* Circular Gold Social Buttons */
    .social-circle-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid rgba(212, 175, 55, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-primary);
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-circle-btn:hover {
        background: var(--gold-primary);
        color: #0B1623;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    /* Quick Links Styling */
    .footer-menu-links a {
        color: var(--text-slate-light);
        text-decoration: none;
        transition: color 0.25s ease;
        font-size: 0.88rem;
    }

    .footer-menu-links a:hover,
    .hover-gold:hover {
        color: var(--gold-primary) !important;
    }

    /* Newsletter Controls (Exact Image Match) */
    .gold-newsletter-input {
        background-color: #FFFFFF !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 6px !important;
        padding: 10px 14px !important;
        font-size: 0.88rem !important;
        color: #0F172A !important;
    }

    .gold-newsletter-input::placeholder {
        color: #94A3B8;
    }

    .btn-gold-solid-block {
        background: var(--gold-btn-gradient);
        color: #FFFFFF !important;
        border: none;
        border-radius: 6px;
        padding: 10px 18px;
        font-size: 0.82rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(196, 154, 33, 0.25);
    }

    .btn-gold-solid-block:hover {
        background: linear-gradient(180deg, #F3DA83 0%, #B08818 100%);
        box-shadow: 0 6px 18px rgba(196, 154, 33, 0.4);
        transform: translateY(-1px);
    }

    /* Footer Bottom Line */
    .footer-thin-bottom {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    .copyright-slate-text {
        color: var(--text-slate);
        font-size: 0.8rem;
    }

    .admin-stealth-link {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.75rem;
        transition: color 0.3s ease;
    }

    .admin-stealth-link:hover {
        color: var(--gold-primary);
    }

    .text-slate-muted {
        color: #475569;
    }
</style>