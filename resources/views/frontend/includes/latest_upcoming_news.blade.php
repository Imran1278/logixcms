@php
    try {
        $latestNewsList = \App\Models\LatestNews::where('status', 1)->latest('news_date')->take(3)->get();
        $upcomingNewsList = \App\Models\UpcomingNews::where('status', 1)->orderBy('news_date', 'asc')->take(3)->get();
    } catch (\Exception $e) {
        $latestNewsList = collect();
        $upcomingNewsList = collect();
    }
@endphp

<!-- Professional Gold-Aesthetic Campus News Section -->
<section class="campus-news-gold-section py-5 position-relative overflow-hidden" id="campus-news">
    <!-- Ambient Gold Backdrop Glows -->
    <div class="gold-ambient-glow-1"></div>
    <div class="gold-ambient-glow-2"></div>

    <div class="container py-lg-4 position-relative" style="z-index: 3;">
        
        <!-- Section Header (Exact Image Layout) -->
        <div class="text-center max-w-700 mx-auto mb-4">
            <span class="sub-badge-gold text-uppercase tracking-widest fw-bold">
                CAMPUS NEWS
            </span>
            <h2 class="news-main-title fw-extrabold display-6 mt-1 mb-2">
                CAMPUS NEWS & ANNOUNCEMENTS
            </h2>
            <p class="news-lead-text text-secondary">
                Stay informed with latest updates and upcoming events at LOGIX College.
            </p>
        </div>

        <!-- Gold Pill Tabs Filter Switch -->
        <div class="d-flex justify-content-center mb-5">
            <ul class="nav nav-pills gold-news-tabs p-1 gap-2 rounded-pill" id="newsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest-news-pane" type="button" role="tab">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i> Latest News
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-news-pane" type="button" role="tab">
                        <i class="fa-regular fa-calendar-check me-1"></i> Upcoming Events
                    </button>
                </li>
            </ul>
        </div>

        <!-- News Content Container -->
        <div class="tab-content" id="newsTabContent">
            
            <!-- Tab 1: Latest News (3-Column Layout Like Image) -->
            <div class="tab-pane fade show active" id="latest-news-pane" role="tabpanel">
                <div class="row g-4 justify-content-center">
                    @forelse($latestNewsList as $news)
                        <div class="col-lg-4 col-md-6">
                            <div class="news-column-card p-4 h-100 position-relative">
                                <!-- Top Square Icon Box (Image Inspired) -->
                                <div class="news-icon-square mb-3">
                                    <i class="fa-regular fa-newspaper"></i>
                                </div>

                                <!-- News Title -->
                                <h4 class="news-item-title fw-extrabold mb-1">
                                    {{ $news->title }}
                                </h4>

                                <!-- Date Typography -->
                                <div class="news-item-date mb-3">
                                    {{ is_string($news->news_date) ? $news->news_date : ($news->news_date?->format('M d, Y') ?? 'N/A') }}
                                </div>

                                <!-- News Body / Description -->
                                <p class="news-item-excerpt text-secondary mb-0">
                                    {{ \Illuminate\Support\Str::limit($news->description, 200) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-news-box text-center p-5 rounded-4">
                                <i class="fa-regular fa-folder-open fa-3x text-gold-muted mb-3 opacity-50"></i>
                                <h5 class="fw-bold text-dark mb-1">No Latest News Found</h5>
                                <p class="text-secondary small mb-0">Check back soon for latest announcements.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab 2: Upcoming News (3-Column Layout Like Image) -->
            <div class="tab-pane fade" id="upcoming-news-pane" role="tabpanel">
                <div class="row g-4 justify-content-center">
                    @forelse($upcomingNewsList as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="news-column-card p-4 h-100 position-relative">
                                <!-- Top Square Icon Box (Image Inspired) -->
                                <div class="news-icon-square mb-3">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>

                                <!-- Event Title -->
                                <h4 class="news-item-title fw-extrabold mb-1">
                                    {{ $item->title }}
                                </h4>

                                <!-- Date Typography -->
                                <div class="news-item-date mb-3">
                                    {{ is_string($item->news_date) ? $item->news_date : ($item->news_date?->format('M d, Y') ?? 'TBA') }}
                                </div>

                                <!-- Description -->
                                <p class="news-item-excerpt text-secondary mb-0">
                                    {{ \Illuminate\Support\Str::limit($item->description, 200) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-news-box text-center p-5 rounded-4">
                                <i class="fa-regular fa-calendar-xmark fa-3x text-gold-muted mb-3 opacity-50"></i>
                                <h5 class="fw-bold text-dark mb-1">No Upcoming Events Scheduled</h5>
                                <p class="text-secondary small mb-0">New schedule updates will appear here soon.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Custom Gold Luxury Styling (Matching Provided Image Theme) -->
<style>
    :root {
        --gold-main: #D4AF37;
        --gold-dark: #B48A16;
        --text-navy: #0F172A;
        --text-muted-gray: #64748B;
    }

    .campus-news-gold-section {
        background-color: #F8FAFC;
        color: var(--text-navy);
    }

    /* Background Ambient Glows */
    .gold-ambient-glow-1 {
        position: absolute;
        top: -10%;
        left: -5%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .gold-ambient-glow-2 {
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

    .news-main-title {
        color: var(--text-navy);
        letter-spacing: -0.5px;
    }

    .news-lead-text {
        font-size: 0.98rem;
        line-height: 1.65;
    }

    /* Tab Switch Styling */
    .gold-news-tabs {
        background: #FFFFFF;
        border: 1px solid rgba(212, 175, 55, 0.25);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.08);
    }

    .gold-news-tabs .nav-link {
        color: var(--text-navy);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 8px 22px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .gold-news-tabs .nav-link.active {
        background: linear-gradient(180deg, #EAD074 0%, #C49A21 100%) !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 12px rgba(196, 154, 33, 0.3);
    }

    /* Column News Cards (Image Layout Match) */
    .news-column-card {
        background: transparent;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .news-column-card:hover {
        background: #FFFFFF;
        box-shadow: 0 12px 30px rgba(212, 175, 55, 0.12);
        transform: translateY(-4px);
    }

    /* Square Icon Box */
    .news-icon-square {
        width: 44px;
        height: 44px;
        background: #FFFFFF;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-dark);
        font-size: 1.25rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    /* Item Title */
    .news-item-title {
        color: var(--text-navy);
        font-size: 1.1rem;
        line-height: 1.35;
        text-transform: uppercase;
        letter-spacing: -0.2px;
    }

    /* Date Typography */
    .news-item-date {
        color: #C49A21;
        font-size: 0.82rem;
        font-weight: 700;
    }

    /* Excerpt / Content Body */
    .news-item-excerpt {
        font-size: 0.9rem;
        line-height: 1.65;
        color: var(--text-muted-gray);
    }

    .empty-news-box {
        background: #FFFFFF;
        border: 2px dashed rgba(212, 175, 55, 0.3);
    }

    .text-gold-muted {
        color: var(--gold-main);
    }
</style>