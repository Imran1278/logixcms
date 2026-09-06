<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Downloads Portal - LOGIX College</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --logix-navy: #0F172A;
            --logix-navy-dark: #071527;
            --logix-gold: #D4AF37;
            --logix-gold-dark: #B48A16;
            --logix-gold-light: rgba(212, 175, 55, 0.12);
            --gold-gradient: linear-gradient(180deg, #EAD074 0%, #C49A21 100%);
            --text-slate: #64748B;
        }

        body {
            background-color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--logix-navy);
        }

        /* Top Navbar */
        .public-navbar {
            background-color: var(--logix-navy-dark);
            padding: 14px 0;
            border-bottom: 2px solid var(--logix-gold);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .brand-logo {
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .btn-return-home {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .btn-return-home:hover {
            background: var(--logix-gold);
            color: var(--logix-navy-dark);
            border-color: var(--logix-gold);
        }

        /* Header Banner */
        .download-header-banner {
            background: linear-gradient(180deg, var(--logix-navy-dark) 0%, var(--logix-navy) 100%);
            color: #ffffff;
            padding: 60px 0 65px 0;
            position: relative;
            overflow: hidden;
        }

        .gold-glow-particle-1 {
            position: absolute;
            top: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .sub-badge-gold {
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: #EAD074;
            font-size: 0.78rem;
            letter-spacing: 1.5px;
        }

        /* Search Input Box */
        .search-box-wrapper {
            position: relative;
            max-width: 650px;
            margin: -32px auto 35px auto;
            z-index: 10;
        }

        .search-box-wrapper input {
            height: 60px;
            padding-left: 54px;
            padding-right: 20px;
            border-radius: 50px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            background: #FFFFFF;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            font-size: 0.95rem;
            color: var(--logix-navy);
            transition: all 0.3s ease;
        }

        .search-box-wrapper input:focus {
            border-color: var(--logix-gold);
            box-shadow: 0 12px 35px rgba(212, 175, 55, 0.22);
            outline: none;
        }

        .search-box-wrapper .search-icon {
            position: absolute;
            left: 22px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--logix-gold-dark);
            font-size: 1.1rem;
        }

        /* Quick Filter Pills */
        .category-pill {
            background: #FFFFFF;
            color: var(--logix-navy);
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .category-pill:hover, .category-pill.active {
            background: var(--gold-gradient);
            color: #FFFFFF;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(196, 154, 33, 0.3);
        }

        /* Category Header Divider */
        .category-title-header {
            border-bottom: 2px solid #E2E8F0;
            padding-bottom: 10px;
        }

        .category-badge-count {
            background: #FFFFFF;
            color: var(--logix-gold-dark);
            border: 1px solid rgba(212, 175, 55, 0.3);
            font-weight: 700;
            font-size: 0.78rem;
        }

        /* Download Card Styling */
        .download-card {
            background: #FFFFFF;
            border-radius: 14px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 20px;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .download-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(212, 175, 55, 0.12);
            border-color: rgba(212, 175, 55, 0.5);
        }

        /* Dynamic File Extension Badge */
        .file-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 800;
            flex-shrink: 0;
            letter-spacing: 0.5px;
        }

        .type-pdf { background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .type-doc, .type-docx { background-color: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .type-zip, .type-rar { background-color: #FAF5FF; color: #9333EA; border: 1px solid #E9D5FF; }
        .type-png, .type-jpg, .type-jpeg { background-color: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
        .type-default { background-color: #F8FAFC; color: #475569; border: 1px solid #E2E8F0; }

        /* Gold Download Button */
        .btn-download {
            background: var(--gold-gradient);
            color: #FFFFFF !important;
            border-radius: 50px;
            padding: 9px 20px;
            font-size: 0.82rem;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(196, 154, 33, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-download:hover {
            background: linear-gradient(180deg, #F3DA83 0%, #B08818 100%);
            box-shadow: 0 6px 18px rgba(196, 154, 33, 0.4);
            transform: translateY(-1px);
        }

        /* Empty Boxes */
        .empty-download-box {
            background: #FFFFFF;
            border: 2px dashed rgba(212, 175, 55, 0.3);
        }

        .text-gold-muted {
            color: var(--logix-gold);
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="public-navbar sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="brand-logo text-white text-decoration-none d-flex align-items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-gold fs-5"></i>
                <span>LOGIX <span class="text-gold">COLLEGE</span></span>
            </a>
            <a href="{{ route('home') }}" class="btn btn-return-home btn-sm rounded-pill px-3 py-1-5 fw-semibold">
                <i class="fa-solid fa-arrow-left me-1 fs-7"></i> Return Home
            </a>
        </div>
    </nav>

    <!-- Header Banner -->
    <div class="download-header-banner text-center position-relative">
        <div class="gold-glow-particle-1"></div>
        <div class="container position-relative" style="z-index: 2;">
            <span class="sub-badge-gold px-3 py-2 rounded-pill fw-bold text-uppercase d-inline-block mb-3">
                <i class="fa-solid fa-cloud-arrow-down me-1"></i> Official Student Resource Hub
            </span>
            <h1 class="fw-extrabold display-6 mb-2">Student Downloads & Documents</h1>
            <p class="text-white-50 mb-0 mx-auto" style="max-width: 620px; font-size: 0.95rem;">
                Access official college prospectuses, admission forms, rules & regulations, and academic request forms.
            </p>
        </div>
    </div>

    <!-- Live Search Section -->
    <div class="container">
        <div class="search-box-wrapper">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search forms by name or description (e.g. Admission, Fee, Prospectus)...">
        </div>

        @if(isset($downloads) && count($downloads) > 0)
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <a href="#all" class="category-pill active"><i class="fa-solid fa-layer-group me-1"></i> All Categories</a>
                @foreach($downloads as $categoryName => $categoryItems)
                    <a href="#cat-{{ Str::slug($categoryName) }}" class="category-pill">
                        {{ $categoryName }} ({{ count($categoryItems) }})
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <div class="container pb-5">

        <div id="downloadsContainer">
            @forelse($downloads as $categoryName => $categoryItems)
                <div class="category-group mb-5" id="cat-{{ Str::slug($categoryName) }}">
                    <div class="d-flex align-items-center justify-content-between mb-3 category-title-header">
                        <h4 class="fw-extrabold text-dark mb-0 ps-2 border-start border-4 border-warning">
                            {{ $categoryName }}
                        </h4>
                        <span class="badge category-badge-count rounded-pill px-3 py-2">{{ count($categoryItems) }} Files</span>
                    </div>
                    
                    <div class="row g-3">
                        @foreach($categoryItems as $item)
                            @php
                                $ext = strtolower($item->file_type);
                                $typeClass = in_array($ext, ['pdf', 'doc', 'docx', 'zip', 'rar', 'png', 'jpg', 'jpeg']) ? 'type-' . $ext : 'type-default';
                            @endphp
                            
                            <div class="col-lg-6 download-item-col" data-title="{{ strtolower($item->title) }}" data-desc="{{ strtolower($item->description) }}">
                                <div class="download-card d-flex align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3 overflow-hidden">
                                        <div class="file-icon {{ $typeClass }}">
                                            {{ strtoupper($item->file_type) }}
                                        </div>

                                        <div class="text-truncate">
                                            <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $item->title }}">{{ $item->title }}</h6>
                                            <p class="text-muted small mb-1 text-truncate" style="font-size: 0.82rem;">
                                                {{ $item->description ?? 'Official downloadable document' }}
                                            </p>
                                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 11px;">
                                                <span><i class="fa-regular fa-calendar-check me-1 text-warning"></i>{{ $item->created_at->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ asset($item->file_path) }}" download class="btn-download text-nowrap ms-2">
                                        <i class="fa-solid fa-download"></i> 
                                        <span class="d-none d-sm-inline">Download</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center empty-download-box p-5 rounded-4 my-4">
                    <i class="fa-solid fa-folder-open fa-3x text-gold-muted mb-3 d-block opacity-50"></i>
                    <h5 class="fw-bold text-dark mb-1">No Forms Available Right Now</h5>
                    <p class="text-muted small mb-0">Please check back later or contact the college administration office.</p>
                </div>
            @endforelse
        </div>

        <!-- Dynamic No Results Message for Search -->
        <div id="noSearchMatch" class="text-center empty-download-box p-5 rounded-4 my-4 d-none">
            <i class="fa-solid fa-file-circle-xmark fa-3x text-gold-muted mb-3 d-block opacity-50"></i>
            <h5 class="fw-bold text-dark mb-1">No Matching Documents Found</h5>
            <p class="text-muted small mb-0">Try searching with a different term or keyword.</p>
        </div>

    </div>

    <!-- Live Search JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const categories = document.querySelectorAll('.category-group');
            const noMatchMsg = document.getElementById('noSearchMatch');

            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let hasGlobalMatch = false;

                categories.forEach(category => {
                    let categoryHasMatch = false;
                    const categoryItems = category.querySelectorAll('.download-item-col');

                    categoryItems.forEach(item => {
                        const title = item.getAttribute('data-title');
                        const desc = item.getAttribute('data-desc');

                        if (title.includes(query) || desc.includes(query)) {
                            item.classList.remove('d-none');
                            categoryHasMatch = true;
                            hasGlobalMatch = true;
                        } else {
                            item.classList.add('d-none');
                        }
                    });

                    if (categoryHasMatch) {
                        category.classList.remove('d-none');
                    } else {
                        category.classList.add('d-none');
                    }
                });

                if (!hasGlobalMatch && query !== '') {
                    noMatchMsg.classList.remove('d-none');
                } else {
                    noMatchMsg.classList.add('d-none');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>