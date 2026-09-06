<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Layout</title>

    <!-- Google Fonts (Montserrat for clean uppercase navigation) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary-teal: #00d2c4;
            --primary-teal-hover: #00b8ac;
            --text-dark: #222222;
            --text-muted: #666666;
            --border-color: #eeeeee;
        }

        /* --- TOP BAR STYLES --- */
        .top-bar {
            border-bottom: 1px solid var(--border-color);
            padding: 10px 0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-dark);
        }

        .top-bar .welcome-text {
            color: var(--text-dark);
            margin-right: 25px;
        }

        .top-bar .phone-text {
            color: var(--text-dark);
            margin-right: 25px;
            text-decoration: none;
        }

        .top-bar .social-links a {
            color: var(--text-dark);
            margin-left: 12px;
            font-size: 13px;
            transition: color 0.2s;
            text-decoration: none;
        }

        .top-bar .social-links a:hover {
            color: var(--primary-teal);
        }

        /* Auth Buttons */
        .btn-teal {
            background-color: var(--primary-teal);
            color: #ffffff !important;
            border-radius: 50px;
            padding: 7px 22px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-teal:hover {
            background-color: var(--primary-teal-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 210, 196, 0.3);
        }

        /* --- MAIN NAVBAR STYLES --- */
        .main-navbar {
            padding: 20px 0;
            background: #ffffff;
        }

        /* Logo Styling */
        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            position: relative;
        }

        .brand-text {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .brand-text span {
            color: var(--primary-teal);
        }

        /* Navigation Links */
        .nav-link-custom {
            color: var(--text-dark);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 8px 18px !important;
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--primary-teal) !important;
        }

        /* Action Icons (Search, Cart, Menu) */
        .nav-action-icon {
            color: var(--text-dark);
            font-size: 16px;
            margin-left: 20px;
            cursor: pointer;
            position: relative;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-action-icon:hover {
            color: var(--primary-teal);
        }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background-color: var(--primary-teal);
            color: white;
            font-size: 9px;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .top-bar-left, .top-bar-right {
                justify-content: center !important;
                margin-bottom: 8px;
            }
            .top-bar {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Header Start -->
    <header>
        <!-- 1. Top Bar -->
        <div class="top-bar">
            <div class="container-fluid px-lg-5">
                <div class="row align-items-center">
                    <!-- Left Side: Welcome, Call, Social -->
                    <div class="col-lg-8 col-12 d-flex align-items-center flex-wrap top-bar-left">
                        <span class="welcome-text">WELCOME</span>
                        <a href="tel:+443003030266" class="phone-text">CALL +44 300 303 0266</a>
                        <div class="d-inline-flex align-items-center social-links">
                            <span class="me-2 text-dark">FOLLOW US</span>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        </div>
                    </div>

                    <!-- Right Side: Login & Register Buttons -->
                    <div class="col-lg-4 col-12 d-flex justify-content-lg-end justify-content-center gap-2 top-bar-right">
                        <a href="{{ route('login') }}" class="btn-teal">
                            <i class="fa-regular fa-user"></i> LOGIN
                        </a>
                        <a href="{{ route('register') }}" class="btn-teal">
                            <i class="fa-solid fa-pencil"></i> REGISTER
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Main Navigation Bar -->
        <nav class="navbar navbar-expand-lg main-navbar">
            <div class="container-fluid px-lg-5">
                
                <!-- Logo -->
                <a class="navbar-brand-custom" href="#">
                    <!-- Abstract Logo SVG Matching Design -->
                    <svg class="brand-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 2L35 11V29L20 38L5 29V11L20 2Z" fill="#20B2AA"/>
                        <path d="M20 2L35 11L20 20L5 11L20 2Z" fill="#00D2C4"/>
                        <path d="M20 20V38L5 29V11L20 20Z" fill="#3B82F6"/>
                        <polygon points="20,5 24,11 20,15 16,11" fill="#FF8C00"/>
                    </svg>
                    <span class="brand-text">eSmarts<span>.</span></span>
                </a>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                    <i class="fa-solid fa-bars fs-3"></i>
                </button>

                <!-- Nav Links & Right Icons -->
                <div class="collapse navbar-collapse" id="mainMenu">
                    
                    <!-- Centered Menu Items -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link-custom active" href="#">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="#">COURSES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="#">INSTRUCTORS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="#">EVENTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="#">PAGES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="#">ELEMENTS</a>
                        </li>
                    </ul>

                    <!-- Right Side Icons (Search, Cart, Drawer Menu) -->
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="#" class="nav-action-icon" title="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                        <a href="#" class="nav-action-icon" title="Cart">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span class="cart-badge">0</span>
                        </a>
                        <a href="#" class="nav-action-icon" title="Menu">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- Header End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>