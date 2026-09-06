<!-- Professional Gold Aesthetic Courses Section -->
<section class="courses-gold-section py-5 position-relative overflow-hidden" id="courses">
    <!-- Background Gold Glow Wave Particles -->
    <div class="gold-ambient-glow-1"></div>
    <div class="gold-ambient-glow-2"></div>

    <div class="container py-lg-4 position-relative" style="z-index: 3;">
        
        <!-- Section Header (Image Layout Inspired) -->
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="sub-badge-gold text-uppercase tracking-widest fw-bold d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-graduation-cap"></i> Academic Excellence
            </span>
            <h2 class="courses-main-title fw-extrabold display-6 mt-2 mb-2">
                Explore Our Career Programs
            </h2>
            <p class="courses-lead-text text-secondary">
                Elevate your professional journey with hands-on skill development, expert mentorship, and industry-recognized certifications at LOGIX College.
            </p>
        </div>

        <!-- Featured Central Gold Card (Design Inspired by Reference Grid Cards) -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                
                <div class="gold-course-card p-4 p-md-5 text-center position-relative">
                    
                    <!-- Top Status Badge -->
                    <div class="mb-4">
                        <span class="gold-status-pill">Admissions Open</span>
                    </div>

                    <!-- Glowing Icon Sphere Box -->
                    <div class="gold-icon-sphere mb-4">
                        <div class="orb-gold-glow-ring"></div>
                        <div class="icon-inner-box">
                            <i class="fa-solid fa-book-open-reader gold-gradient-icon"></i>
                        </div>
                    </div>

                    <!-- Card Title -->
                    <h3 class="fw-extrabold mb-3 fs-3 text-navy-dark">
                        Discover All Active Academic Courses
                    </h3>

                    <!-- Description -->
                    <p class="text-secondary fs-6 mb-4 px-md-3 leading-relaxed">
                        We offer specialized training across Software Development, Graphic Design, Web Technologies, Digital Marketing, and Business Management designed for real-world employment.
                    </p>

                    <!-- Main Action Button (Gold Solid CTA) -->
                    <div class="mb-4">
                        <a href="{{ \Illuminate\Support\Facades\Route::has('courses.all') ? route('courses.all') : '#' }}" class="btn-gold-solid-cta">
                            <span>View All Course Offerings</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Quick Metrics Bar (Bottom Card Stats) -->
                    <div class="gold-stats-divider pt-4">
                        <div class="row g-3">
                            <div class="col-4 border-end">
                                <div class="stat-box">
                                    <h5 class="fw-extrabold mb-0 text-navy-dark">100%</h5>
                                    <p class="stat-label">Practical Skill</p>
                                </div>
                            </div>
                            <div class="col-4 border-end">
                                <div class="stat-box">
                                    <h5 class="fw-extrabold mb-0 text-navy-dark">Verified</h5>
                                    <p class="stat-label">Certifications</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <h5 class="fw-extrabold mb-0 text-navy-dark">Flexible</h5>
                                    <p class="stat-label">Batch Timings</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<!-- Custom Gold Luxury Styling (Matching Provided Image Theme) -->
<style>
    :root {
        --gold-primary: #D4AF37;
        --gold-light-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.95) 0%, rgba(253, 240, 166, 0.25) 100%);
        --gold-btn-gradient: linear-gradient(180deg, #EAD074 0%, #C49A21 100%);
        --gold-btn-hover: linear-gradient(180deg, #F3DA83 0%, #B08818 100%);
        --navy-dark: #0A192F;
        --slate-gray: #64748B;
    }

    .courses-gold-section {
        background-color: #F8FAFC;
        color: #0F172A;
    }

    /* Ambient Background Glows */
    .gold-ambient-glow-1 {
        position: absolute;
        top: -15%;
        left: -5%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .gold-ambient-glow-2 {
        position: absolute;
        bottom: -15%;
        right: -5%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .max-w-700 {
        max-width: 700px;
    }

    .sub-badge-gold {
        color: #B48A16;
        font-size: 0.8rem;
        letter-spacing: 2px;
    }

    .courses-main-title {
        color: #0F172A;
        letter-spacing: -0.5px;
    }

    .courses-lead-text {
        font-size: 0.98rem;
        line-height: 1.65;
    }

    .text-navy-dark {
        color: var(--navy-dark) !important;
    }

    /* Gold Card Design Inspired by Reference Image */
    .gold-course-card {
        background: var(--gold-light-gradient);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 24px;
        box-shadow: 0 20px 45px rgba(212, 175, 55, 0.08);
        backdrop-filter: blur(10px);
        transition: all 0.4s ease;
    }

    .gold-course-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 55px rgba(212, 175, 55, 0.18);
        border-color: rgba(212, 175, 55, 0.6);
    }

    /* Gold Status Pill */
    .gold-status-pill {
        background: rgba(212, 175, 55, 0.15);
        color: #B48A16;
        border: 1px solid rgba(212, 175, 55, 0.35);
        font-size: 0.75rem;
        font-weight: 800;
        padding: 6px 18px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* 3D Glowing Icon Sphere */
    .gold-icon-sphere {
        position: relative;
        display: inline-block;
    }

    .orb-gold-glow-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.35) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(8px);
    }

    .icon-inner-box {
        position: relative;
        z-index: 2;
        width: 80px;
        height: 80px;
        margin: 0 auto;
        background: #FFFFFF;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.25);
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .gold-gradient-icon {
        font-size: 2.2rem;
        background: linear-gradient(135deg, #FDF0A6 0%, #D4AF37 50%, #997A15 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 4px rgba(180, 138, 22, 0.3));
    }

    /* Solid Gold CTA Button (Exact Image Match) */
    .btn-gold-solid-cta {
        background: var(--gold-btn-gradient);
        color: #FFFFFF !important;
        font-weight: 800;
        font-size: 0.92rem;
        padding: 14px 36px;
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 22px rgba(196, 154, 33, 0.35);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
    }

    .btn-gold-solid-cta:hover {
        background: var(--gold-btn-hover);
        box-shadow: 0 12px 28px rgba(196, 154, 33, 0.5);
        transform: translateY(-2px);
        color: #FFFFFF !important;
    }

    .btn-gold-solid-cta i {
        transition: transform 0.3s ease;
    }

    .btn-gold-solid-cta:hover i {
        transform: translateX(4px);
    }

    /* Stats Divider */
    .gold-stats-divider {
        border-top: 1px solid rgba(212, 175, 55, 0.2);
    }

    .stat-label {
        color: var(--slate-gray);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
        margin-bottom: 0;
    }
</style>