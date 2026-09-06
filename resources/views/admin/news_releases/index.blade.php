@extends('layouts.app')

@section('page_title', 'CMS - News & Media Management')

@push('styles')
<style>
    :root {
        --admin-navy: #0A2D5A;
        --admin-gold: #CFAE4E;
        --admin-teal: #00d2c4;
    }

    .cms-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .cms-header-pill {
        background: linear-gradient(135deg, var(--admin-navy) 0%, #051329 100%);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 14px 20px;
        font-size: 0.95rem;
        font-weight: 700;
        border-bottom: 2px solid var(--admin-gold);
    }

    .form-box-styled {
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
    }

    .btn-navy-action {
        background-color: var(--admin-navy);
        color: #ffffff;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 10px 18px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-navy-action:hover {
        background-color: #113f7c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(10, 45, 90, 0.25);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <!-- Page Title Header Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-4 rounded-4 shadow-sm border border-slate-100">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 p-3 text-white shadow-sm" style="background: linear-gradient(135deg, var(--admin-navy) 0%, #051329 100%); border: 1px solid rgba(207, 174, 78, 0.3);">
                <i class="fa-solid fa-newspaper fs-4" style="color: var(--admin-gold);"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1">News & Media CMS</h4>
                <p class="text-muted small mb-0">Manage Press Releases, Announcements, and Upcoming Events for Student Portal Dashboard.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- SECTION 1: PRESS RELEASE -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="cms-card overflow-hidden">
                <div class="cms-header-pill d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-images me-2" style="color: var(--admin-gold);"></i>1. Official Press Releases (Banner & Title)</span>
                    <span class="badge bg-light text-dark fw-bold border px-3 py-1.5 rounded-pill shadow-xs">Student Portal Section</span>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Form -->
                    <form action="{{ route('admin.press.store') }}" method="POST" enctype="multipart/form-data" class="form-box-styled mb-4">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">Press Release Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter concise press title..." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark small">Upload Banner Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-navy-action w-100 shadow-sm" style="background-color: var(--admin-gold); color: #0A2D5A; border: 1px solid var(--admin-gold);">
                                    <i class="fa-solid fa-plus me-1"></i> Add Press
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Data List Table -->
                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th style="width: 90px;" class="ps-3">Preview</th>
                                    <th>Title</th>
                                    <th>Published Date</th>
                                    <th style="width: 100px;" class="text-center pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pressReleases as $press)
                                    <tr>
                                        <td class="ps-3">
                                            <img src="{{ asset($press->image) }}" alt="Press Image" class="rounded-3 shadow-sm" style="width: 65px; height: 42px; object-fit: cover;">
                                        </td>
                                        <td class="fw-bold text-dark">{{ $press->title }}</td>
                                        <td class="small text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ $press->created_at?->format('d M, Y') }}</td>
                                        <td class="text-center pe-3">
                                            <form action="{{ route('admin.press.destroy', $press->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this press release?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No Press Releases published yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2 & 3: LATEST NEWS & UPCOMING EVENTS -->
    <div class="row g-4">
        
        <!-- LATEST NEWS -->
        <div class="col-lg-6">
            <div class="cms-card h-100 overflow-hidden">
                <div class="cms-header-pill">
                    <i class="fa-solid fa-clock-rotate-left me-2" style="color: var(--admin-gold);"></i>2. Latest Campus News
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.latest_news.store') }}" method="POST" class="form-box-styled mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">News Headline</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter news headline..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">News Date</label>
                            <input type="date" name="news_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Short Detail</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Summary of news..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-navy-action w-100">
                            <i class="fa-solid fa-plus me-1"></i> Add Latest News
                        </button>
                    </form>

                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th class="ps-3">Headline & Date</th>
                                    <th style="width: 80px;" class="text-center pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestNews as $news)
                                    <tr>
                                        <td class="ps-3 py-3">
                                            <div class="fw-bold text-dark">{{ $news->title }}</div>
                                            <div class="small text-muted mt-1"><i class="fa-regular fa-calendar-days me-1 text-primary"></i>{{ is_string($news->news_date) ? $news->news_date : $news->news_date?->format('d M, Y') }}</div>
                                        </td>
                                        <td class="text-center pe-3">
                                            <form action="{{ route('admin.latest_news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Delete this news entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">No Latest News entries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- UPCOMING EVENTS -->
        <div class="col-lg-6">
            <div class="cms-card h-100 overflow-hidden">
                <div class="cms-header-pill">
                    <i class="fa-regular fa-calendar-check me-2" style="color: var(--admin-gold);"></i>3. Upcoming Events & Schedules
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('admin.upcoming_news.store') }}" method="POST" class="form-box-styled mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Event Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Upcoming event title..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Event Date</label>
                            <input type="date" name="news_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Event Agenda / Details</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief details regarding event..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-navy-action w-100">
                            <i class="fa-solid fa-plus me-1"></i> Add Upcoming Event
                        </button>
                    </form>

                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th class="ps-3">Event & Scheduled Date</th>
                                    <th style="width: 80px;" class="text-center pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingNews as $item)
                                    <tr>
                                        <td class="ps-3 py-3">
                                            <div class="fw-bold text-dark">{{ $item->title }}</div>
                                            <div class="small text-muted mt-1"><i class="fa-regular fa-clock me-1 text-success"></i>{{ is_string($item->news_date) ? $item->news_date : $item->news_date?->format('d M, Y') }}</div>
                                        </td>
                                        <td class="text-center pe-3">
                                            <form action="{{ route('admin.upcoming_news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">No Upcoming Events scheduled.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection