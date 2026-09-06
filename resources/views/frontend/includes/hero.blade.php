@php
    $campusVideo = asset('assets/images/campus-tour.mp4');
@endphp

<!-- Animation & Style Dependencies -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

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

    /* Fullscreen Cinematic Hero Container */
    .hero-video-wrapper {
        position: relative;
        width: 100%;
        min-height: 700px;
        overflow: hidden;
        display: flex;
        align-items: center;
        color: var(--brand-white);
    }

    /* Hardware Accelerated Background Video */
    .hero-bg-video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: 0;
        transform: translate(-50%, -50%) scale(1.05);
        object-fit: cover;
        filter: brightness(0.65) contrast(1.1);
        will-change: transform;
    }

    /* Overlay Layering */
    .hero-overlay-dark {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(15, 30, 54, 0.90) 0%, rgba(4, 10, 20, 0.78) 50%, rgba(15, 30, 54, 0.90) 100%),
                    radial-gradient(circle at 20% 50%, rgba(11, 48, 103, 0.6) 0%, transparent 65%);
        z-index: 1;
        backdrop-filter: blur(3px);
    }

    .hero-grid-pattern {
        position: absolute;
        inset: 0;
        background-size: 40px 40px;
        background-image: 
            radial-gradient(circle, rgba(212, 175, 55, 0.14) 1px, transparent 1px),
            linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        z-index: 1;
        pointer-events: none;
    }

    .hero-container {
        position: relative;
        z-index: 3;
        padding: 90px 15px 130px 15px;
    }

    /* Premium Glassmorphic Text Container */
    .glass-text-card {
        background: rgba(15, 30, 54, 0.55);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 24px;
        padding: 42px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6),
                    inset 0 0 25px rgba(212, 175, 55, 0.08);
        transform: translateZ(0);
    }

    /* Carousel Items Transition Styling */
    .slide-content-item {
        display: none;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .slide-content-item.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    /* Typography & Visual Badges */
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(212, 175, 55, 0.15);
        border: 1px solid rgba(212, 175, 55, 0.5);
        backdrop-filter: blur(10px);
        color: var(--brand-gold);
        padding: 8px 22px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.25);
    }

    .hero-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: -1px;
        line-height: 1.12;
        margin-bottom: 18px;
        color: var(--brand-white);
    }

    .hero-heading span.gold-text {
        color: var(--brand-gold);
        background: linear-gradient(135deg, #FFE89C 0%, var(--brand-gold) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 25px rgba(212, 175, 55, 0.3);
    }

    .hero-description {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.1rem;
        color: #E2E8F0;
        max-width: 640px;
        margin: 0 0 32px 0;
        line-height: 1.65;
    }

    /* Action Elements: CTA Button & Search Box */
    .btn-hero-cta {
        background: linear-gradient(135deg, var(--brand-gold) 0%, var(--brand-gold-hover) 100%);
        color: var(--brand-dark) !important;
        border: none;
        padding: 15px 38px;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-hero-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(212, 175, 55, 0.6);
        background: linear-gradient(135deg, #EAD065 0%, var(--brand-gold) 100%);
    }

    .hero-search-box {
        max-width: 580px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(212, 175, 55, 0.4);
        border-radius: 50px;
        padding: 6px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .hero-search-box:focus-within {
        border-color: var(--brand-gold);
        box-shadow: 0 0 25px rgba(212, 175, 55, 0.35);
        background: rgba(255, 255, 255, 0.18);
    }

    .hero-search-box input {
        border: none;
        outline: none;
        padding: 10px 22px;
        width: 100%;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--brand-white);
        background: transparent;
    }

    .hero-search-box input::placeholder {
        color: #CBD5E1;
    }

    .hero-search-box button {
        background: var(--brand-gold);
        color: var(--brand-dark);
        border: none;
        padding: 11px 28px;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 12px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .hero-search-box button:hover {
        background: var(--brand-gold-hover);
        transform: translateY(-1px);
    }

    /* Slider Custom Dots Indicator */
    .slider-indicators-custom {
        display: flex;
        justify-content: flex-start;
        gap: 10px;
        margin-top: 35px;
    }

    .indicator-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        border: none;
        padding: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .indicator-dot.active {
        background: var(--brand-gold);
        width: 36px;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(212, 175, 55, 0.7);
    }

    /* Smooth SVG Wave Divider */
    .hero-curve-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        z-index: 2;
    }

    .hero-curve-bottom svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }

    .hero-curve-bottom .shape-fill {
        fill: var(--brand-light);
    }

    /* Bottom Stats Counter Section */
    .counter-section {
        background: var(--brand-light);
        padding: 10px 0 50px 0;
        border-bottom: 1px solid #E2E8F0;
        position: relative;
        z-index: 3;
    }

    .counter-card {
        padding: 26px 20px;
        border-radius: 18px;
        background: var(--brand-white);
        border: 1px solid rgba(11, 48, 103, 0.08);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }

    .counter-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px rgba(11, 48, 103, 0.12);
        border-color: var(--brand-gold);
    }

    .counter-icon-wrap {
        width: 58px;
        height: 58px;
        margin: 0 auto 14px auto;
        background: rgba(11, 48, 103, 0.06);
        color: var(--brand-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: all 0.3s ease;
    }

    .counter-card:hover .counter-icon-wrap {
        background: var(--brand-primary);
        color: var(--brand-gold);
    }

    .counter-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.4rem;
        font-weight: 900;
        color: var(--brand-primary);
        line-height: 1;
        margin-bottom: 6px;
    }

    .counter-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 800;
        color: var(--brand-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    @media (max-width: 991px) {
        .hero-heading { font-size: 2.8rem; }
        .glass-text-card { padding: 28px; }
    }

    @media (max-width: 576px) {
        .hero-heading { font-size: 2.1rem; }
        .hero-search-box { flex-direction: column; background: transparent; border: none; }
        .hero-search-box input { background: rgba(255, 255, 255, 0.15); margin-bottom: 10px; }
        .hero-search-box button { width: 100%; }
        .hero-curve-bottom svg { height: 35px; }
    }
</style>

<!-- Full Background Video Hero Section -->
<div class="hero-video-wrapper">
    
    <!-- Background Autoplay Loop Video -->
    <video class="hero-bg-video" autoplay loop muted playsinline preload="auto">
        <source src="{{ $campusVideo }}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Dark Overlay Gradients & Grid Pattern -->
    <div class="hero-overlay-dark"></div>
    <div class="hero-grid-pattern"></div>

    <!-- Content Container -->
    <div class="container hero-container">
        <div class="row">
            <div class="col-lg-8 col-xl-7" data-aos="fade-right" data-aos-duration="1200">
                
                <div class="glass-text-card">
                    <!-- Slide 1: General Branding -->
                    <div class="slide-content-item active">
                        <span class="hero-badge"><i class="fa-solid fa-award"></i> 25 Years of Excellence</span>
                        <h1 class="hero-heading">Achieve Your <br><span class="gold-text">Academic Goals</span></h1>
                        <p class="hero-description">Experience excellence through personalized learning. Join a community dedicated to success in emerging technologies and degree programs.</p>
                    </div>

                    <!-- Slide 2: IT & AI Courses -->
                    <div class="slide-content-item">
                        <span class="hero-badge"><i class="fa-solid fa-laptop-code"></i> NAVTTC & PSDA Certified</span>
                        <h1 class="hero-heading">Master Tech & <br><span class="gold-text">Freelancing Skills</span></h1>
                        <p class="hero-description">Learn Artificial Intelligence, Web Development, Cyber Security & Digital Marketing with hands-on practical training.</p>
                    </div>

                    <!-- Slide 3: Virtual University -->
                    <div class="slide-content-item">
                        <span class="hero-badge"><i class="fa-solid fa-university"></i> Virtual University Campus</span>
                        <h1 class="hero-heading">Recognized BS & <br><span class="gold-text">Master Programs</span></h1>
                        <p class="hero-description">Affordable, flexible, and HEC recognized degrees with nationwide campus support right in Sargodha.</p>
                    </div>

                    <!-- Slide 4: Creative Skills -->
                    <div class="slide-content-item">
                        <span class="hero-badge"><i class="fa-solid fa-wand-magic-sparkles"></i> Creative Skills Center</span>
                        <h1 class="hero-heading">Build Careers In <br><span class="gold-text">Fashion & Arts</span></h1>
                        <p class="hero-description">Professional career guidance and practical skill development at our dedicated Umer Campus.</p>
                    </div>

                    <!-- Global Search & Direct CTA Action -->
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <a href="{{ route('courses.index') }}" class="btn-hero-cta">
                                <span>Explore Our Courses</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                        <form action="{{ route('courses.index') }}" method="GET" class="hero-search-box mt-2">
                            <input type="text" name="search" placeholder="Search IT Courses, Degrees, or Certifications..." aria-label="Search Courses" required>
                            <button type="submit" aria-label="Submit Search"><i class="fa-solid fa-magnifying-glass me-1"></i> Search</button>
                        </form>
                    </div>

                    <!-- Dynamic Dots -->
                    <div class="slider-indicators-custom" role="tablist">
                        <button class="indicator-dot active" aria-label="Slide 1" onclick="setSlide(0)"></button>
                        <button class="indicator-dot" aria-label="Slide 2" onclick="setSlide(1)"></button>
                        <button class="indicator-dot" aria-label="Slide 3" onclick="setSlide(2)"></button>
                        <button class="indicator-dot" aria-label="Slide 4" onclick="setSlide(3)"></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Curved Bottom Styling Transition Divider -->
    <div class="hero-curve-bottom">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,65 C650,160 900,10 1200,40 L1200,120 L0,120 Z" class="shape-fill"></path>
        </svg>
    </div>
</div>

<!-- Stats Counter Section -->
<div class="counter-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="counter-card">
                    <div class="counter-icon-wrap">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="counter-number">25+</div>
                    <div class="counter-label">Years of Excellence</div>
                </div>
            </div>
            <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="counter-card">
                    <div class="counter-icon-wrap">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div class="counter-number">
                        {{ \App\Models\Course::where('status', 1)->count() }}
                    </div>
                    <div class="counter-label">Programs Offered</div>
                </div>
            </div>
            <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="counter-card">
                    <div class="counter-icon-wrap">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="counter-number">15,000+</div>
                    <div class="counter-label">Successful Graduates</div>
                </div>
            </div>
            <div class="col-lg-3 col-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="counter-card">
                    <div class="counter-icon-wrap">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="counter-number">100%</div>
                    <div class="counter-label">Practical Training</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS Script & Optimized Slider Controller -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    let currentSlideIndex = 0;
    let autoSlideInterval = null;
    let slides = [];
    let dots = [];

    function renderSlide(index) {
        if (!slides.length || !dots.length) return;

        slides.forEach(slide => slide.classList.remove("active"));
        dots.forEach(dot => dot.classList.remove("active"));

        slides[index].classList.add("active");
        dots[index].classList.add("active");
        currentSlideIndex = index;
    }

    function nextSlide() {
        let nextIndex = (currentSlideIndex + 1) % slides.length;
        renderSlide(nextIndex);
    }

    function setSlide(index) {
        renderSlide(index);
        resetAutoSlide();
    }

    function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextSlide, 4200);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true });
        }
        
        slides = document.querySelectorAll(".slide-content-item");
        dots = document.querySelectorAll(".indicator-dot");

        startAutoSlide();
    });

    window.addEventListener("beforeunload", function() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
    });
</script>