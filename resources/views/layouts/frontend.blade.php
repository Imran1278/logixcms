<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Primary SEO Meta Tags -->
    <title>@yield('title', 'LOGIX College | Premier Educational Institute')</title>
    <meta name="description" content="@yield('meta_description', 'LOGIX College is a premier ISO certified educational institution providing market-driven technology, management, and professional courses since 2000.')">
    <meta name="keywords" content="@yield('meta_keywords', 'LOGIX College, Education, IT Courses, Software Development, Sargodha, Degree Programs, Skills Development')">
    <meta name="author" content="LOGIX College">

    <!-- Open Graph / Facebook / WhatsApp Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'LOGIX College | Premier Educational Institute')">
    <meta property="og:description" content="@yield('meta_description', 'Premier ISO certified educational institution empowering students with cutting-edge skills.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/logix-logo.png'))">

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logix-logo.png') }}">

    <!-- DNS Prefetch & Resource Preloading for Ultra Performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

    <!-- Google Fonts: Plus Jakarta Sans & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS & FontAwesome 6 Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Core Layout Styling -->
    <style>
        :root {
            --logix-navy-dark: #071527;
            --logix-navy: #0B2545;
            --logix-gold: #D4AF37;
            --logix-gold-hover: #B8952B;
            --logix-teal: #00D2C4;
            --logix-red: #E63946;
            --logix-bg-light: #F8FAFC;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0B1623;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--logix-gold);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #EAD074;
        }

        html, body {
            height: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #FFFFFF;
            color: #1E293B;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Flexible Content Layout Wrapper */
        main {
            flex: 1 0 auto;
        }

        /* Toast Alert Floating Box */
        .toast-container-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1090;
        }

        /* Floating Back-to-Top Button */
        .back-to-top-btn {
            position: fixed;
            bottom: 25px;
            left: 25px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: var(--logix-navy);
            color: var(--logix-gold);
            border: 1px solid var(--logix-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .back-to-top-btn.show {
            opacity: 1;
            visibility: visible;
        }
        .back-to-top-btn:hover {
            background-color: var(--logix-gold);
            color: var(--logix-navy-dark);
            transform: translateY(-3px);
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column h-100">

    <!-- Session Dynamic Toast Flash Messages -->
    <div class="toast-container-floating">
        @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-white bg-danger border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Global Public Header Navbar -->
    @include('frontend.includes.header')

    <!-- Main Content Dynamic Section -->
    <main id="main-content" class="flex-shrink-0">
        @yield('content')
    </main>

    <!-- Global Public Footer -->
    @include('frontend.includes.footer')

    <!-- Modal Extensions -->
    @if(view()->exists('course_finder.index'))
        @include('course_finder.index')
    @endif

    <!-- AI Interactive Student Assistant Chatbot -->
    @if(view()->exists('frontend.includes.chatbot'))
        @include('frontend.includes.chatbot')
    @endif

    <!-- Scroll To Top Button -->
    <button id="backToTopBtn" class="back-to-top-btn" aria-label="Back to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global JS Configurations -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Setup CSRF Token for all jQuery / Vanilla JS Fetch requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Auto Dismiss Toast Alerts
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toastEl => {
                setTimeout(() => {
                    const bsToast = bootstrap.Toast.getInstance(toastEl) || new bootstrap.Toast(toastEl);
                    bsToast.hide();
                }, 4000);
            });

            // Back to Top Scroll Behavior
            const backToTopBtn = document.getElementById('backToTopBtn');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    backToTopBtn?.classList.add('show');
                } else {
                    backToTopBtn?.classList.remove('show');
                }
            });

            backToTopBtn?.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>