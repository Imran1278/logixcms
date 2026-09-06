@php
    // YouTube URL Ko Auto-Embed Format me Convert karne ki Logic
    $videoEmbedUrl = null;
    if (!empty($about->home_video_url)) {
        $rawUrl = $about->home_video_url;
        if (Str::contains($rawUrl, ['youtube.com/watch?v=', 'youtu.be/'])) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $rawUrl, $matches);
            if (isset($matches[1])) {
                $videoEmbedUrl = "https://www.youtube.com/embed/" . $matches[1] . "?autoplay=0&rel=0";
            }
        } elseif (Str::contains($rawUrl, 'embed')) {
            $videoEmbedUrl = $rawUrl;
        }
    }
@endphp

<!-- Luxury & Academic Excellence About Section -->
<section class="about-premium-section py-5 position-relative overflow-hidden" id="about-section">
    <!-- Soft Golden Mesh Particles Background -->
    <div class="gold-ambient-mesh"></div>
    <div class="gold-ambient-wave"></div>

    <div class="container py-lg-4 position-relative" style="z-index: 3;">
        
        <!-- Header Section (Image Inspired) -->
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="sub-badge-gold text-uppercase tracking-widest fw-bold">Who We Are</span>
            <h2 class="about-main-title fw-extrabold display-6 mt-2 mb-3">
                {{ $about->home_title ?? 'Dedicated to Academic Excellence' }}
            </h2>
            <p class="about-lead-text text-secondary">
                {{ $about->home_description ?? 'LOGIX College provides excellence through personalized learning with our professional faculty, modern environment, and innovative IT training dedicated to your career success.' }}
            </p>
        </div>

        <div class="row g-4 align-items-center">
            
            <!-- Left Side: Feature Grid (Image Left Column Style) -->
            <div class="col-lg-6">
                <div class="row g-4">
                    
                    <!-- Feature 1: Our Story -->
                    <div class="col-12">
                        <div class="feature-card-clean d-flex align-items-start gap-3">
                            <div class="feature-icon-square">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div>
                                <h5 class="feature-title fw-bold mb-1">Our Story</h5>
                                <p class="feature-desc mb-0">Empowering students with hands-on skills and quality education to bridge the gap between academic learning and industry demands.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2: Experienced Faculty -->
                    <div class="col-12">
                        <div class="feature-card-clean d-flex align-items-start gap-3">
                            <div class="feature-icon-square">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h5 class="feature-title fw-bold mb-1">Experienced Faculty</h5>
                                <p class="feature-desc mb-0">Learn directly from certified industry experts and veteran educators dedicated to your personal growth and success.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3: Recognized Programs -->
                    <div class="col-12">
                        <div class="feature-card-clean d-flex align-items-start gap-3">
                            <div class="feature-icon-square">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h5 class="feature-title fw-bold mb-1">Trusted Community</h5>
                                <p class="feature-desc mb-0">Join an expansive network of alumni, industry leaders, and ambitious peers building the future together.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4: High-End Labs / Campus -->
                    <div class="col-12">
                        <div class="feature-card-clean d-flex align-items-start gap-3">
                            <div class="feature-icon-square">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <h5 class="feature-title fw-bold mb-1">Our Campus & Labs</h5>
                                <p class="feature-desc mb-0">State-of-the-art computer labs, high-speed networking setup, and a modern academic infrastructure.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Side: 3D Golden Graphic Showcase & Video Modal/Player -->
            <div class="col-lg-6">
                <div class="golden-showcase-card position-relative p-4 rounded-5 text-center">
                    
                    <!-- Floating 3D Glowing Book Graphic (Top Element) -->
                    <div class="glowing-orb-container mb-4">
                        <div class="orb-gold-glow"></div>
                        <div class="3d-emblem-box">
                            <i class="fa-solid fa-book-bookmark gold-3d-icon"></i>
                        </div>
                    </div>

                    <!-- Right Column Secondary Box & Button (Image Style) -->
                    <div class="card-gold-inner p-4 rounded-4 mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3 text-start">
                            <div class="feature-icon-square bg-gold-light">
                                <i class="fa-solid fa-graduation-cap text-gold"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Experienced Faculty & Guidance</h6>
                                <small class="text-muted">Personalized mentorship for every learner.</small>
                            </div>
                        </div>

                        <!-- Main Video Player Frame -->
                        <div class="video-preview-wrapper rounded-3 overflow-hidden shadow-sm position-relative mb-3">
                            <div class="ratio ratio-16x9 bg-dark">
                                @if(!empty($videoEmbedUrl))
                                    <iframe 
                                        src="{{ $videoEmbedUrl }}" 
                                        title="LOGIX College Introduction Video" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen 
                                        class="border-0 w-100 h-100">
                                    </iframe>
                                @elseif(!empty($about->home_video_url))
                                    <video controls class="w-100 h-100" style="object-fit: cover;">
                                        <source src="{{ asset($about->home_video_url) }}" type="video/mp4">
                                        Your browser does not support HTML5 video.
                                    </video>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center text-white h-100 bg-navy-gradient p-3">
                                        <i class="fa-solid fa-circle-play text-warning display-5 mb-2"></i>
                                        <span class="fw-semibold fs-7">Campus Video Tour</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Solid Golden CTA Button (Exact match from provided Image) -->
                        <a href="{{ \Illuminate\Support\Facades\Route::has('about.details') ? route('about.details') : '#' }}" class="btn-gold-solid w-100 text-uppercase fw-extrabold tracking-wider py-3 rounded-3 d-inline-block text-decoration-none">
                            Learn More
                        </a>
                    </div>

                    <!-- Floating 3D Building Emblem Graphic (Bottom Element) -->
                    <div class="building-graphic-box">
                        <i class="fa-solid fa-landmark gold-3d-icon-large"></i>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Custom Styling Matching the Reference Image -->
<style>
    :root {
        --theme-gold-main: #D4AF37;
        --theme-gold-gradient: linear-gradient(135deg, #FDF0A6 0%, #D4AF37 50%, #997A15 100%);
        --theme-gold-bg: rgba(212, 175, 55, 0.08);
        --theme-navy-dark: #0A192F;
        --theme-text-gray: #64748B;
    }

    .about-premium-section {
        background-color: #F8FAFC;
        color: #0F172A;
    }

    /* Soft Ambient Gold Glows */
    .gold-ambient-mesh {
        position: absolute;
        top: -10%;
        right: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
    }

    .gold-ambient-wave {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.06) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
    }

    .max-w-700 {
        max-width: 700px;
    }

    /* Sub Badge */
    .sub-badge-gold {
        color: #B48A16;
        font-size: 0.8rem;
        letter-spacing: 2px;
    }

    .about-main-title {
        color: #0F172A;
        letter-spacing: -0.5px;
    }

    .about-lead-text {
        font-size: 0.98rem;
        line-height: 1.65;
    }

    /* Feature Cards Clean */
    .feature-card-clean {
        padding: 8px;
        border-radius: 12px;
        transition: transform 0.3s ease;
    }

    .feature-card-clean:hover {
        transform: translateX(4px);
    }

    .feature-icon-square {
        width: 44px;
        height: 44px;
        min-width: 44px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0F172A;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .feature-title {
        color: #0F172A;
        font-size: 1.05rem;
    }

    .feature-desc {
        color: var(--theme-text-gray);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Golden Showcase Card (Right Column) */
    .golden-showcase-card {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.8) 0%, rgba(253, 240, 166, 0.25) 100%);
        border: 1px solid rgba(212, 175, 55, 0.25);
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.08);
        backdrop-filter: blur(10px);
    }

    .card-gold-inner {
        background: #FFFFFF;
        border: 1px solid rgba(212, 175, 55, 0.2);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
    }

    .bg-gold-light {
        background: rgba(212, 175, 55, 0.12) !important;
        border-color: rgba(212, 175, 55, 0.3) !important;
    }

    .text-gold {
        color: #B48A16 !important;
    }

    .bg-navy-gradient {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
    }

    /* 3D Glowing Icons */
    .glowing-orb-container {
        position: relative;
        display: inline-block;
    }

    .orb-gold-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 110px;
        height: 110px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(10px);
    }

    .3d-emblem-box {
        position: relative;
        z-index: 2;
        width: 90px;
        height: 90px;
        margin: 0 auto;
        background: #FFFFFF;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.25);
    }

    .gold-3d-icon {
        font-size: 2.5rem;
        background: var(--theme-gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 4px rgba(180, 138, 22, 0.3));
    }

    .building-graphic-box {
        margin-top: 10px;
    }

    .gold-3d-icon-large {
        font-size: 4rem;
        background: var(--theme-gold-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 10px rgba(180, 138, 22, 0.3));
    }

    /* Exact Golden Solid CTA Button */
    .btn-gold-solid {
        background: linear-gradient(180deg, #EAD074 0%, #C49A21 100%);
        color: #FFFFFF !important;
        border: none;
        box-shadow: 0 6px 18px rgba(196, 154, 33, 0.35);
        font-size: 0.85rem;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-gold-solid:hover {
        background: linear-gradient(180deg, #F3DA83 0%, #B08818 100%);
        box-shadow: 0 10px 25px rgba(196, 154, 33, 0.5);
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .golden-showcase-card {
            margin-top: 20px;
        }
    }
</style>