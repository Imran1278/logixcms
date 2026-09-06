<!-- Modern Faculty & Tutors Section -->
<section class="tutors-section py-5 position-relative overflow-hidden" id="tutors">
    
    <!-- Floating Background Decorative Elements -->
    <div class="decor-shape shape-circle-gold"></div>
    <div class="decor-shape shape-circle-navy"></div>
    <div class="decor-shape shape-cross-teal">+</div>
    <div class="decor-shape shape-cross-gold">+</div>

    <div class="container text-center position-relative" style="z-index: 2;">
        
        <!-- Header Section -->
        <div class="section-header-wrap mb-5 position-relative">
            <span class="watermark-text">FACULTY</span>
            <span class="badge-subtitle d-inline-block mb-2">
                <i class="fa-solid fa-graduation-cap me-1"></i> EXPERT INSTRUCTORS
            </span>
            <h2 class="section-title fw-extrabold display-6 mb-3">
                Learn From Expert Faculty
            </h2>
            <p class="section-desc mx-auto mb-0">
                Our highly qualified instructors are dedicated to empowering students with practical training, hands-on experience, and industry-oriented skills.
            </p>
        </div>

        <!-- Tutors Grid -->
        <div class="row g-4 justify-content-center">
            @forelse($tutors as $tutor)
                <div class="col-lg-4 col-md-6">
                    <div class="tutor-card text-center p-4 h-100 bg-white position-relative d-flex flex-column justify-content-between">
                        
                        <div>
                            <!-- Top Accent Line -->
                            <div class="card-top-accent"></div>

                            <!-- Image Avatar Box -->
                            <div class="tutor-img-box mb-4 mx-auto position-relative">
                                <img src="{{ asset($tutor->image) }}" alt="{{ $tutor->name }}" class="img-fluid" loading="lazy">
                                <span class="verify-badge" title="Verified Faculty">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                            </div>

                            <!-- Name & Rank -->
                            <h4 class="fw-bold mb-1 fs-5 tutor-name">{{ $tutor->name }}</h4>
                            <span class="badge rank-badge fw-bold px-3 py-1 rounded-pill mb-3">
                                {{ $tutor->rank }}
                            </span>

                            <!-- Bio Description -->
                            <p class="tutor-bio px-1 mb-4">
                                {{ Str::limit($tutor->bio ?? 'Dedicated faculty member committed to teaching excellence and mentoring students.', 115) }}
                            </p>
                        </div>

                        <!-- Social Buttons -->
                        <div class="tutor-socials d-flex justify-content-center align-items-center gap-2 pt-3 border-top">
                            @if($tutor->twitter)
                                <a href="{{ $tutor->twitter }}" target="_blank" aria-label="Twitter" class="social-btn icon-twitter"><i class="fa-brands fa-x-twitter"></i></a>
                            @endif
                            @if($tutor->linkedin)
                                <a href="{{ $tutor->linkedin }}" target="_blank" aria-label="LinkedIn" class="social-btn icon-linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                            @endif
                            @if($tutor->instagram)
                                <a href="{{ $tutor->instagram }}" target="_blank" aria-label="Instagram" class="social-btn icon-instagram"><i class="fa-brands fa-instagram"></i></a>
                            @endif
                            @if($tutor->youtube)
                                <a href="{{ $tutor->youtube }}" target="_blank" aria-label="YouTube" class="social-btn icon-youtube"><i class="fa-brands fa-youtube"></i></a>
                            @endif

                            @if(!$tutor->twitter && !$tutor->linkedin && !$tutor->instagram && !$tutor->youtube)
                                <span class="text-muted extra-small italic py-1"><i class="fa-solid fa-award text-gold me-1"></i> LOGIX Certified Instructor</span>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 py-5">
                    <div class="p-4 rounded-4 bg-white d-inline-block border shadow-sm">
                        <i class="fa-solid fa-chalkboard-user display-5 text-muted mb-2 d-block"></i>
                        <p class="text-muted mb-0 fw-bold fs-6">No faculty members listed at the moment.</p>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>

<!-- Advanced Styling -->
<style>
    :root {
        --logix-navy: #0B2545;
        --logix-gold: #D4AF37;
        --logix-teal: #00D2C4;
        --text-slate: #64748B;
    }

    .tutors-section {
        background-color: #F8FAFC;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    }

    /* Watermark Typography */
    .watermark-text {
        position: absolute;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 5.5rem;
        color: rgba(11, 37, 69, 0.04);
        letter-spacing: 6px;
        user-select: none;
        z-index: 0;
    }

    .badge-subtitle {
        color: var(--logix-teal);
        background: rgba(0, 210, 196, 0.1);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .section-title {
        color: var(--logix-navy);
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
    }

    .section-desc {
        color: var(--text-slate);
        max-width: 620px;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Floating Shapes */
    .decor-shape {
        position: absolute;
        user-select: none;
        pointer-events: none;
        font-weight: bold;
    }
    .shape-circle-gold {
        width: 12px;
        height: 12px;
        border: 2px solid var(--logix-gold);
        border-radius: 50%;
        top: 12%;
        left: 6%;
    }
    .shape-circle-navy {
        width: 14px;
        height: 14px;
        border: 2px solid var(--logix-navy);
        border-radius: 50%;
        top: 18%;
        right: 8%;
    }
    .shape-cross-teal {
        color: var(--logix-teal);
        font-size: 1.3rem;
        top: 45%;
        right: 4%;
    }
    .shape-cross-gold {
        color: var(--logix-gold);
        font-size: 1.2rem;
        bottom: 12%;
        left: 5%;
    }

    /* Cards */
    .tutor-card {
        border-radius: 20px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 10px 30px rgba(11, 37, 69, 0.04);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }

    .card-top-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--logix-navy), var(--logix-gold));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .tutor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(11, 37, 69, 0.12) !important;
        border-color: rgba(212, 175, 55, 0.3);
    }

    .tutor-card:hover .card-top-accent {
        opacity: 1;
    }

    /* Avatar Box */
    .tutor-img-box {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        padding: 4px;
        background: #FFFFFF;
        border: 2px solid rgba(212, 175, 55, 0.4);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .tutor-card:hover .tutor-img-box {
        border-color: var(--logix-navy);
        transform: scale(1.03);
    }

    .tutor-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .verify-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: #FFFFFF;
        color: #0EA5E9;
        border-radius: 50%;
        font-size: 16px;
        line-height: 1;
    }

    .tutor-name {
        color: var(--logix-navy);
    }

    .rank-badge {
        background-color: #F1F5F9;
        color: var(--logix-navy);
        border: 1px solid #CBD5E1;
        font-size: 0.75rem;
    }

    .tutor-bio {
        line-height: 1.6;
        font-size: 0.88rem;
        color: var(--text-slate);
        min-height: 52px;
    }

    /* Social Action Buttons */
    .social-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #F1F5F9;
        color: #64748B;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .social-btn:hover {
        transform: translateY(-3px);
    }

    .icon-twitter:hover { background: #000000; color: #FFFFFF; }
    .icon-linkedin:hover { background: #0A66C2; color: #FFFFFF; }
    .icon-instagram:hover { background: #E4405F; color: #FFFFFF; }
    .icon-youtube:hover { background: #FF0000; color: #FFFFFF; }
</style>