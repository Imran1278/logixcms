@php
    $batchesCount = isset($batchesList) ? $batchesList->count() : (isset($batches) ? count($batches) : 0);
    $coursesCount = isset($coursesList) ? $coursesList->count() : (isset($courses) ? count($courses) : 0);
@endphp

<aside class="acad-sidebar d-none d-lg-flex flex-column justify-content-between shadow-sm" style="background: linear-gradient(180deg, #0A2D5A 0%, #051329 100%); border-right: 1px solid rgba(207, 174, 78, 0.2); width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000;">
    <div>
        <!-- Brand Logo Header -->
        <div class="brand-header text-center py-4 px-3 mb-2" style="border-bottom: 1px solid rgba(207, 174, 78, 0.15);">
            <h2 class="brand-title mb-0 fw-bold tracking-wider" style="color: #ffffff; letter-spacing: 2px; font-size: 1.5rem;">LOGIX</h2>
            <div class="brand-subtitle fs-8 text-uppercase mt-1" style="color: #CFAE4E; letter-spacing: 3px; font-size: 0.7rem;">EST. 2024</div>
            <div class="brand-gold-line mx-auto mt-2 rounded-pill" style="width: 40px; height: 3px; background-color: #CFAE4E;"></div>
        </div>

        <!-- Navigation Menu Links -->
        <nav class="nav flex-column gap-1 px-3 mt-3">
            <a href="javascript:void(0)" onclick="switchTab('dashboard')" id="btn-nav-dashboard" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all active" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85ul; font-weight: 500;">
                <i class="fa-solid fa-house nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>DASHBOARD</span>
            </a>

            <a href="javascript:void(0)" onclick="switchTab('attendances')" id="btn-nav-attendances" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-solid fa-calendar-check nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>ATTENDANCE & 2FA</span>
            </a>

            <a href="javascript:void(0)" onclick="switchTab('courses')" id="btn-nav-courses" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-solid fa-book-bookmark nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>COURSES</span>
                @if($coursesCount > 0)
                    <span class="badge rounded-pill ms-auto fw-bold fs-8" style="background-color: #CFAE4E; color: #0A2D5A;">{{ $coursesCount }}</span>
                @endif
            </a>

            <a href="javascript:void(0)" onclick="switchTab('fees')" id="btn-nav-fees" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-solid fa-file-lines nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>GRADES & FEES</span>
            </a>

            <a href="javascript:void(0)" onclick="switchTab('inquiries')" id="btn-nav-inquiries" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-regular fa-comments nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>INQUIRIES</span>
            </a>

            <a href="javascript:void(0)" onclick="switchTab('downloads')" id="btn-nav-downloads" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-solid fa-folder-open nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>DOWNLOADS & FORMS</span>
            </a>

            <a href="javascript:void(0)" onclick="switchTab('profile')" id="btn-nav-profile" class="nav-item-custom d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 text-decoration-none transition-all" style="color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; font-weight: 500;">
                <i class="fa-regular fa-user nav-icon fs-6" style="color: #CFAE4E; width: 20px; text-align: center;"></i>
                <span>PROFILE</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Logout Action -->
    <div class="px-3 pb-4">
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn w-100 fw-bold py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: rgba(207, 174, 78, 0.15); color: #CFAE4E; border: 1px solid rgba(207, 174, 78, 0.4); transition: all 0.2s ease;">
                <i class="fa-solid fa-right-from-bracket"></i> LOGOUT
            </button>
        </form>
    </div>
</aside>

<!-- Custom Inline Styling for Active State Hover & Polish -->
<style>
    .nav-item-custom:hover {
        background-color: rgba(207, 174, 78, 0.1) !important;
        color: #ffffff !important;
    }
    .nav-item-custom.active {
        background: linear-gradient(135deg, rgba(207, 174, 78, 0.25) 0%, rgba(207, 174, 78, 0.1) 100%) !important;
        color: #CFAE4E !important;
        border-left: 4px solid #CFAE4E;
        font-weight: 600 !important;
    }
    .btn:hover {
        background-color: #CFAE4E !important;
        color: #0A2D5A !important;
    }
</style>