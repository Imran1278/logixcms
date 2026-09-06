<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('page_title', 'Dashboard') | LOGIX CMS</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Executive Color Palette */
            --color-navy: #0A2D5A;
            --color-blue: #2E5FA3;
            --color-ice: #8BB4E3;
            --color-gold: #CFAE4E;
            --color-red: #B91C1C;
            --color-white: #FFFFFF;
            --color-black: #000000;

            /* Light Theme Defaults */
            --bg-body: #F4F7FA;
            --bg-card: #FFFFFF;
            --bg-header: #FFFFFF;
            --bg-sidebar: #0A2D5A;
            --bg-sidebar-hover: #163C6E;
            --text-main: #0A2D5A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --sidebar-width: 270px;
        }

        /* Dark Theme Overrides */
        [data-bs-theme="dark"] {
            --bg-body: #080F1A;
            --bg-card: #0F1B2D;
            --bg-header: #0F1B2D;
            --bg-sidebar: #06152B;
            --bg-sidebar-hover: #102544;
            --text-main: #F1F5F9;
            --text-muted: #94A3B8;
            --border-color: #1E293B;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-main);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            -webkit-font-smoothing: antialiased;
        }

        /* --- EXECUTIVE SIDEBAR STYLES --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--bg-sidebar);
            color: #ffffff;
            z-index: 1045;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }

        .sidebar .brand {
            padding: 22px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar .brand h3 {
            margin: 0;
            font-weight: 800;
            font-size: 1.35rem;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .sidebar .brand span {
            color: var(--color-gold);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }

        .sidebar-menu {
            padding: 15px 12px;
            flex-grow: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--color-gold) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: var(--color-gold);
            border-radius: 10px;
        }

        .nav-category {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--color-ice);
            opacity: 0.8;
            padding: 16px 14px 6px;
        }

        .sidebar .nav-link {
            color: #CBD5E1;
            padding: 10px 14px;
            font-weight: 500;
            font-size: 0.88rem;
            border-radius: 8px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--bg-sidebar-hover);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: var(--color-navy);
            background-color: var(--color-gold);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            font-size: 1rem;
            text-align: center;
            color: var(--color-ice);
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link.active i {
            color: var(--color-navy);
        }

        /* --- MAIN CONTENT & HEADER --- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 24px 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .top-navbar {
            background-color: var(--bg-header);
            padding: 12px 24px;
            margin-bottom: 24px;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 15px;
            z-index: 1020;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .theme-toggle-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle-btn:hover {
            border-color: var(--color-gold);
            color: var(--color-gold);
            transform: rotate(15deg);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(10, 45, 90, 0.1);
            color: var(--color-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid var(--color-gold);
        }

        [data-bs-theme="dark"] .user-avatar {
            background-color: rgba(207, 174, 78, 0.15);
            color: var(--color-gold);
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(10, 45, 90, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-backdrop.show { display: block; }
            .main-content { margin-left: 0; padding: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <div class="brand d-flex align-items-center justify-content-between">
            <div>
                <h3>LOGIX</h3>
                <span>EXECUTIVE PORTAL</span>
            </div>
            <button class="btn btn-link text-white d-lg-none p-0 fs-5" id="sidebarCloseBtn" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="nav-category">Main Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>

            <div class="nav-category">Academic & CRM</div>
            <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i> Courses Directory
            </a>
            <a href="{{ route('batches.index') }}" class="nav-link {{ request()->routeIs('batches.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Batch Management
            </a>
            <a href="{{ route('inquiries.index') }}" class="nav-link {{ request()->routeIs('inquiries.*') ? 'active' : '' }}">
                <i class="fa-solid fa-headset"></i> Inquiries (CRM)
            </a>
            <a href="{{ route('admissions.index') }}" class="nav-link {{ request()->routeIs('admissions.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i> Student Admissions
            </a>
            <a href="{{ route('admin.finder.index') }}" class="nav-link {{ request()->routeIs('admin.finder.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> Course Finder Questions
            </a>

            <div class="nav-category">CMS Content</div>
            <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i> News & Releases
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="nav-link {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-arrow-up"></i> Manage Downloads
            </a>
            <a href="{{ route('admin.tutors.index') }}" class="nav-link {{ request()->routeIs('admin.tutors.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i> Manage Tutors
            </a>
            <a href="{{ route('admin.about.index') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-info"></i> Manage About
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope-open-text"></i> Manage Contacts
            </a>
            <a href="{{ route('admin.header_settings.index') }}" class="nav-link {{ request()->routeIs('admin.header_settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> Manage Header
            </a>
            <a href="{{ route('admin.footer.index') }}" class="nav-link {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope"></i> Manage Footer
            </a>

            <div class="nav-category">Accounts & Operations</div>
            <a href="{{ route('fees.index') }}" class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Fee Management
            </a>
            <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-user"></i> Mark Attendance
            </a>
            <a href="{{ route('attendance.report') }}" class="nav-link {{ request()->routeIs('attendance.report') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Attendance Report
            </a>
            <a href="{{ route('certificates.index') }}" class="nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                <i class="fa-solid fa-award"></i> Certificates
            </a>
        </div>

        <div class="p-3 border-top text-center text-muted small" style="border-color: rgba(255,255,255,0.08) !important;">
            <span class="opacity-75">LOGIX CMS v3.5 &bull; Executive Suite</span>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-3 border shadow-sm" id="sidebarToggleBtn" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="m-0 fw-bold fs-5">@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                
                <!-- Dark/Light Theme Switcher Button -->
                <button class="theme-toggle-btn shadow-sm" id="themeToggleBtn" type="button" title="Toggle Light/Dark Mode">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>

                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-2 border position-relative shadow-sm" style="width: 38px; height: 38px;" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                        <i class="fa-regular fa-bell text-secondary"></i>
                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-0" aria-labelledby="notificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <div class="dropdown-header bg-dark text-white d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="fw-bold"><i class="fa-solid fa-bell me-1"></i> Notifications</span>
                            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                <a href="{{ route('notifications.clearAll') }}" class="text-white text-decoration-none" style="font-size: 11px;">Mark all read</a>
                            @endif
                        </div>

                        <div class="list-group list-group-flush">
                            @if(auth()->check())
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="list-group-item list-group-item-action p-3 border-bottom">
                                        <div class="d-flex align-items-start">
                                            <div class="me-2 mt-1">
                                                <i class="fa-solid {{ $notification->data['icon'] ?? 'fa-info-circle text-info' }} fs-5"></i>
                                            </div>
                                            <div class="w-100">
                                                <div class="fw-bold" style="font-size: 13px;">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                                <small class="text-muted d-block" style="font-size: 11px;">{{ $notification->data['message'] ?? '' }}</small>
                                                <small class="text-primary text-end d-block mt-1" style="font-size: 10px;">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="fa-regular fa-bell-slash fs-4 d-block mb-1"></i>
                                        <small>No unread notifications</small>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-reset" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="d-none d-sm-block text-start">
                            <span class="fw-bold d-block leading-tight fs-6">{{ Auth::user()->name ?? 'Admin User' }}</span>
                            <span class="text-muted small">Super Administrator</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="fa-solid fa-user me-2 text-muted"></i> Profile Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger fw-semibold" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- System Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #10b981 !important;">
                <i class="fa-solid fa-circle-check me-2 text-success"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #ef4444 !important;">
                <i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Yield Content -->
        @yield('content')
    </main>

    <!-- Essential JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Switcher & Mobile Sidebar Handler -->
    <script>
        $(document).ready(function () {
            // Mobile Sidebar Toggle Logic
            function toggleSidebar() {
                $('#sidebar').toggleClass('show');
                $('#sidebarBackdrop').toggleClass('show');
            }

            $('#sidebarToggleBtn, #sidebarCloseBtn, #sidebarBackdrop').on('click', function () {
                toggleSidebar();
            });

            // Dark Mode / Light Mode Switcher Logic
            const htmlTag = $('html');
            const themeBtn = $('#themeToggleBtn');
            const themeIcon = $('#themeIcon');

            // Apply saved theme on page load
            const savedTheme = localStorage.getItem('logix_theme') || 'light';
            setTheme(savedTheme);

            themeBtn.on('click', function () {
                const currentTheme = htmlTag.attr('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });

            function setTheme(theme) {
                htmlTag.attr('data-bs-theme', theme);
                localStorage.setItem('logix_theme', theme);

                if (theme === 'dark') {
                    themeIcon.removeClass('fa-moon').addClass('fa-sun text-warning');
                } else {
                    themeIcon.removeClass('fa-sun text-warning').addClass('fa-moon');
                }
            }
        });
    </script>
    
{{-- Admin AI Chatbot Widget Include --}}
    @include('frontend.includes/chatbot')
    @stack('scripts')
</body>
</html>