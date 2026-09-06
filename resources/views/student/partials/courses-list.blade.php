{{-- File Path: resources/views/student/partials/courses-list.blade.php --}}
@php
    $cList = $coursesList ?? $courses ?? $availableCourses ?? collect();
@endphp

<style>
    .catalog-header-bar {
        border-bottom: 2px solid var(--panel-border, #f1f5f9);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .catalog-title-text {
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
    }

    .course-catalog-card {
        background: var(--box-bg, #ffffff);
        border: 1px solid var(--panel-border, #e2e8f0);
        border-radius: 16px;
        padding: 22px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .course-catalog-card:hover {
        transform: translateY(-5px);
        border-color: rgba(200, 162, 81, 0.5);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .course-catalog-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--navy-primary, #0a2540) 0%, var(--color-gold, #c8a251) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .course-catalog-card:hover::before {
        opacity: 1;
    }

    .course-code-badge {
        background: var(--box-subtle-bg, #f8fafc);
        border: 1px solid var(--panel-border, #cbd5e1);
        color: var(--text-main, #0a2540);
        font-weight: 800;
        font-size: 0.72rem;
        padding: 4px 10px;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }

    .course-price-tag {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main, #0f172a);
    }

    .course-duration-badge {
        background: rgba(200, 162, 81, 0.1);
        border: 1px solid rgba(200, 162, 81, 0.3);
        color: #9a782e;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 20px;
    }

    .empty-catalog-state {
        background: var(--box-subtle-bg, #f8fafc);
        border: 2px dashed var(--panel-border, #cbd5e1);
        border-radius: 18px;
        padding: 48px 20px;
    }
</style>

<div class="react-card mb-4" id="courses-section">
    <!-- Section Header -->
    <div class="catalog-header-bar d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h5 class="catalog-title-text text-theme-primary mb-1">
                <i class="fa-solid fa-book-bookmark me-2 text-warning"></i>AVAILABLE COURSES CATALOGUE
            </h5>
            <p class="text-theme-muted small mb-0">Explore professional training programs and technical tracks offered at LOGIX.</p>
        </div>
        <div class="badge bg-body-tertiary text-theme-primary border border-theme px-3 py-2 fw-bold fs-8 rounded-pill shadow-sm">
            <i class="fa-solid fa-circle-check text-success me-1"></i> Active Programs
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="row g-3">
        @forelse($cList as $course)
            @php
                // Safe Schema Mapping for Database Columns
                $cTitle    = $course->course_name ?? $course->title ?? 'Course Title';
                $cCode     = $course->course_code ?? $course->code ?? 'LC-0'.$course->id;
                $cFee      = $course->standard_fee ?? $course->fee ?? $course->total_fee ?? 0;
                $cDuration = ($course->duration ?? '3') . ' ' . ($course->duration_type ?? 'Months');
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="course-catalog-card">
                    <div>
                        <!-- Card Top Bar -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="course-code-badge">{{ $cCode }}</span>
                            <span class="text-success small fw-bold d-flex align-items-center gap-1 fs-8">
                                <i class="fa-solid fa-circle text-success" style="font-size: 0.45rem;"></i> Active
                            </span>
                        </div>

                        <!-- Course Title & Description -->
                        <h6 class="fw-bold text-theme-primary mb-2 fs-6" style="line-height: 1.35;">
                            {{ $cTitle }}
                        </h6>
                        <p class="text-theme-muted small mb-3 lh-sm fs-8">
                            {{ Str::limit(strip_tags($course->description ?? 'Comprehensive practical skill development course with real-world project experience.'), 90) }}
                        </p>
                    </div>

                    <!-- Card Footer Info -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-theme mt-2">
                        <div>
                            <span class="text-theme-muted d-block fs-8 fw-semibold">Tuition Fee</span>
                            <span class="course-price-tag">
                                Rs. {{ number_format($cFee) }}
                            </span>
                        </div>
                        <span class="course-duration-badge">
                            <i class="fa-regular fa-clock me-1"></i>{{ trim($cDuration) }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-catalog-state text-center text-muted">
                    <div class="stat-card-icon-box mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem;">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h6 class="fw-bold text-theme-primary mb-1">No Active Courses Available</h6>
                    <p class="small text-theme-muted mb-0">Check back later or contact campus administration for new intake sessions.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>