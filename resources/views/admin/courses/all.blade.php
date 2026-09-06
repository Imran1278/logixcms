@extends('layouts.app')

@section('page_title', 'Academic & Professional Programs')

@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        
        --panel-bg: #FFFFFF;
        --panel-border: #E2E8F0;
        --panel-header-bg: #0A2D5A;
        --panel-header-text: #FFFFFF;
        --input-bg: #FFFFFF;
        --input-border: #CBD5E1;
        --input-text: #0F172A;
        --text-primary: #0F172A;
        --text-muted: #64748B;
        --card-bg: #FFFFFF;
        --badge-subtle-bg: #F1F5F9;
    }

    [data-bs-theme="dark"] {
        --panel-bg: #0F1B2D;
        --panel-border: #1E293B;
        --panel-header-bg: #06152B;
        --panel-header-text: #F1F5F9;
        --input-bg: #162842;
        --input-border: #334155;
        --input-text: #F8FAFC;
        --text-primary: #F8FAFC;
        --text-muted: #94A3B8;
        --card-bg: #0F1B2D;
        --badge-subtle-bg: #162842;
    }

    .page-hero-card {
        background: linear-gradient(135deg, rgba(6, 21, 43, 0.95) 0%, rgba(10, 45, 90, 0.90) 100%), 
                    url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat;
        color: #ffffff;
        padding: 40px 20px;
        border-radius: 18px;
        border: 1px solid var(--panel-border);
    }

    .search-card {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--panel-border);
        padding: 8px 16px;
    }

    .search-card .form-control {
        background: transparent !important;
        color: var(--input-text) !important;
    }

    .course-card { 
        background: var(--card-bg); 
        border-radius: 16px; 
        border: 1px solid var(--panel-border); 
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }

    .course-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-color: var(--color-gold);
    }

    .course-img-wrapper { 
        height: 190px; 
        overflow: hidden; 
        position: relative;
        background: var(--color-navy); 
    }

    .course-img-wrapper img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.5s ease;
    }

    .course-card:hover .course-img-wrapper img {
        transform: scale(1.06);
    }

    .code-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(6, 21, 43, 0.85);
        backdrop-filter: blur(4px);
        color: var(--color-gold);
        font-weight: 700;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 50px;
        border: 1px solid rgba(207, 174, 78, 0.3);
    }

    .price-tag {
        color: var(--color-gold);
        font-weight: 800;
        font-size: 1.25rem;
    }

    .btn-gold-action {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 50px;
        padding: 8px 18px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold-action:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
    }

    .subtle-badge {
        background-color: var(--badge-subtle-bg);
        color: var(--text-primary);
        border: 1px solid var(--panel-border);
    }

    .card-title-text {
        color: var(--text-primary);
    }

    .card-desc-text {
        color: var(--text-muted);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">

    <!-- Hero Banner -->
    <div class="page-hero-card text-center mb-4">
        <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill text-uppercase mb-2">
            Academic Catalog
        </span>
        <h2 class="fw-bold text-white mb-2">Academic & Professional Programs</h2>
        <p class="text-light opacity-75 mx-auto mb-0" style="max-width: 600px;">
            Manage and view active courses, curriculum details, schedules, and fee structures in your admin portal.
        </p>
    </div>

    <!-- Search Section -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="search-card">
                <div class="input-group input-group-lg border-0 align-items-center">
                    <span class="input-group-text bg-transparent border-0 text-muted ps-2">
                        <i class="fa-solid fa-magnifying-glass fs-5"></i>
                    </span>
                    <input type="text" id="courseSearchInput" class="form-control border-0 shadow-none fs-6" placeholder="Search course by title or code (e.g. BSCS, Laravel, Web Design)...">
                    <span class="input-group-text bg-transparent border-0 pe-2 d-none" id="clearSearch" style="cursor: pointer;">
                        <i class="fa-solid fa-circle-xmark text-secondary"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4" id="coursesGrid">
        @forelse($courses as $course)
            <div class="col-lg-4 col-md-6 course-item" data-title="{{ strtolower($course->course_name) }}" data-code="{{ strtolower($course->course_code) }}">
                <div class="course-card h-100 d-flex flex-column">
                    
                    <div class="course-img-wrapper">
                        @if($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->course_name }}">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-white p-3 text-center">
                                <i class="fa-solid fa-graduation-cap display-4 text-warning mb-2 opacity-75"></i>
                                <span class="fw-bold fs-5">{{ $course->course_name }}</span>
                            </div>
                        @endif
                        <span class="code-badge">{{ $course->course_code }}</span>
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 class="fw-bold card-title-text mb-2">{{ $course->course_name }}</h4>
                        
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <small class="badge subtle-badge"><i class="fa-regular fa-clock text-warning me-1"></i> {{ $course->duration }} {{ $course->duration_type }}</small>
                            @if($course->seats)
                                <small class="badge subtle-badge"><i class="fa-solid fa-chair text-info me-1"></i> {{ $course->seats }} Seats</small>
                            @endif
                            @if($course->has_installments)
                                <small class="badge bg-success-subtle text-success border border-success-subtle"><i class="fa-solid fa-wallet me-1"></i> Installments Available</small>
                            @endif
                        </div>

                        <p class="card-desc-text small flex-grow-1 mb-3">
                            {{ Str::limit($course->description, 110, '...') }}
                        </p>

                        @if(!empty($course->timing_slots) || !empty($course->timing))
                            <div class="mb-3 pt-2 border-top">
                                <small class="fw-bold d-block text-uppercase text-muted mb-1" style="font-size: 10px;">Available Slots:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @if(is_array($course->timing_slots))
                                        @foreach($course->timing_slots as $slot)
                                            <span class="badge bg-primary-subtle text-primary fw-medium" style="font-size: 10px;">{{ $slot }}</span>
                                        @endforeach
                                    @elseif($course->timing)
                                        <span class="badge bg-primary-subtle text-primary fw-medium" style="font-size: 10px;">{{ $course->timing }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="pt-3 mt-auto border-top d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-uppercase text-muted d-block fw-bold" style="font-size: 10px;">{{ $course->fee_type ?? 'Standard Fee' }}</small>
                                <span class="price-tag">PKR {{ number_format($course->standard_fee) }}</span>
                            </div>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-gold-action btn-sm">
                                View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 search-card max-w-md mx-auto" style="max-width: 500px;">
                    <i class="fa-solid fa-folder-open display-3 text-warning mb-3"></i>
                    <h4 class="fw-bold card-title-text">No Active Courses Available</h4>
                    <p class="card-desc-text mb-0">Please create courses using the management section.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- No Search Results Message -->
    <div class="col-12 text-center py-5 d-none" id="noResultsMsg">
        <div class="p-4 search-card max-w-md mx-auto" style="max-width: 450px;">
            <i class="fa-solid fa-magnifying-glass-minus display-4 text-secondary mb-3"></i>
            <h5 class="fw-bold card-title-text mb-1">No Matching Courses Found</h5>
            <p class="card-desc-text small mb-0">Try searching with a different course title or code.</p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.getElementById('courseSearchInput').addEventListener('keyup', function () {
        const query = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.course-item');
        const clearBtn = document.getElementById('clearSearch');
        let visibleCount = 0;

        if (query.length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }

        items.forEach(item => {
            const title = item.getAttribute('data-title');
            const code = item.getAttribute('data-code');

            if (title.includes(query) || code.includes(query)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noResults = document.getElementById('noResultsMsg');
        if (visibleCount === 0 && items.length > 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    });

    document.getElementById('clearSearch').addEventListener('click', function () {
        const input = document.getElementById('courseSearchInput');
        input.value = '';
        input.dispatchEvent(new Event('keyup'));
    });
</script>
@endpush