@php
    try {
        $pressReleases = \App\Models\PressRelease::where('status', 1)->latest()->take(6)->get();
    } catch (\Exception $e) {
        $pressReleases = collect();
    }
@endphp

<!-- Luxury Gold & White Press Release Section -->
<section class="press-release-gold-section py-5 position-relative overflow-hidden" id="press-releases">
    <!-- Ambient Gold Wave Background Graphics -->
    <div class="gold-ambient-particle-1"></div>
    <div class="gold-ambient-particle-2"></div>

    <div class="container py-lg-4 position-relative" style="z-index: 3;">
        
        <!-- Section Header (Image Layout Inspired) -->
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="sub-badge-gold text-uppercase tracking-widest fw-bold">
                LATEST RELEASE
            </span>
            <h2 class="press-main-title fw-extrabold display-6 mt-1 mb-2">
                LATEST PRESS RELEASES
            </h2>
            <p class="press-lead-text text-secondary">
                Stay updated with the latest institutional announcements, achievements, and media highlights from LOGIX College.
            </p>
        </div>

        <!-- Press Releases Stacked Cards Container -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="d-flex flex-column gap-4">
                    @forelse($pressReleases as $release)
                        <!-- Gold Paper Card with Folded Corner Effect -->
                        <div class="gold-paper-card p-4 p-md-5 position-relative">
                            <!-- Top Right Paper Fold Corner Visual -->
                            <div class="paper-fold-corner"></div>

                            <div class="row align-items-center g-4">
                                @if($release->image)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card-img-frame rounded-3 overflow-hidden shadow-sm">
                                            <img src="{{ asset($release->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $release->title }}">
                                        </div>
                                    </div>
                                @endif

                                <div class="{{ $release->image ? 'col-md-8 col-lg-9' : 'col-12' }}">
                                    <!-- Title matching reference font hierarchy -->
                                    <h3 class="press-card-title fw-extrabold mb-1">
                                        {{ $release->title }}
                                    </h3>

                                    <!-- Date Typography -->
                                    <div class="press-date-text mb-3">
                                        {{ $release->created_at ? $release->created_at->format('M d, Y') : 'Announcement' }}
                                    </div>

                                    <!-- Description / Teaser Content -->
                                    <p class="press-excerpt-text text-secondary mb-4">
                                        {{ Str::limit(strip_tags($release->description ?? $release->content ?? 'Official release details regarding institutional advancements, strategic leadership, and student excellence across all academic departments.'), 220) }}
                                    </p>

                                    <!-- Gold Read Link (Exact Match to Image CTA) -->
                                    <div>
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('press.details') ? route('press.details', $release->id) : '#' }}" class="gold-read-more-link fw-bold text-decoration-none d-inline-flex align-items-center gap-2">
                                            <span>Read Full Article</span>
                                            <i class="fa-solid fa-chevron-right fs-7"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State Styling -->
                        <div class="empty-gold-paper-box text-center p-5 rounded-4">
                            <i class="fa-regular fa-newspaper fa-3x mb-3 text-gold-muted opacity-50"></i>
                            <h5 class="fw-bold text-dark mb-1">No Press Releases Available</h5>
                            <p class="text-secondary small mb-0">Check back soon for latest institutional announcements.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Custom Styling Matching Provided Image Design -->
<style>
    :root {
        --gold-main: #D4AF37;
        --gold-dark: #B48A16;
        --gold-light-bg: rgba(253, 240, 166, 0.18);
        --text-navy: #0F172A;
        --text-muted-gray: #64748B;
    }

    .press-release-gold-section {
        background-color: #F8FAFC;
        color: var(--text-navy);
    }

    /* Background Ambient Glows */
    .gold-ambient-particle-1 {
        position: absolute;
        top: -10%;
        left: -5%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .gold-ambient-particle-2 {
        position: absolute;
        bottom: -10%;
        right: -5%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .max-w-700 {
        max-width: 700px;
    }

    /* Sub-header Badge */
    .sub-badge-gold {
        color: var(--gold-dark);
        font-size: 0.8rem;
        letter-spacing: 2px;
    }

    .press-main-title {
        color: var(--text-navy);
        letter-spacing: -0.5px;
    }

    .press-lead-text {
        font-size: 0.98rem;
        line-height: 1.65;
    }

    /* Paper Card (Inspired by Reference Stacked Sheet) */
    .gold-paper-card {
        background: linear-gradient(180deg, #FFFFFF 0%, #FAFAFA 100%);
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04), 0 2px 6px rgba(212, 175, 55, 0.06);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }

    .gold-paper-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(212, 175, 55, 0.15);
        border-color: rgba(212, 175, 55, 0.5);
    }

    /* Paper Fold Trick (Top Right Corner) */
    .paper-fold-corner {
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 32px 32px 0;
        border-color: transparent #E2E8F0 transparent transparent;
        filter: drop-shadow(-2px 2px 2px rgba(0, 0, 0, 0.08));
        transition: border-color 0.3s ease;
    }

    .gold-paper-card:hover .paper-fold-corner {
        border-color: transparent var(--gold-main) transparent transparent;
    }

    .card-img-frame {
        height: 140px;
        background-color: #F1F5F9;
    }

    /* Title Styling */
    .press-card-title {
        color: var(--text-navy);
        font-size: 1.25rem;
        letter-spacing: -0.3px;
        text-transform: uppercase;
        line-height: 1.35;
    }

    /* Date Typography */
    .press-date-text {
        color: #C49A21;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .press-excerpt-text {
        font-size: 0.92rem;
        line-height: 1.65;
        color: var(--text-muted-gray);
    }

    /* Gold Link CTA */
    .gold-read-more-link {
        color: #C49A21 !important;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
        transition: gap 0.3s ease, color 0.3s ease;
    }

    .gold-read-more-link:hover {
        color: #997A15 !important;
        gap: 8px !important;
    }

    .empty-gold-paper-box {
        background: #FFFFFF;
        border: 2px dashed rgba(212, 175, 55, 0.3);
    }

    .text-gold-muted {
        color: var(--gold-main);
    }
</style>