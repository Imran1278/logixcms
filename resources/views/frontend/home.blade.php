<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | LOGIX CMS</title>
    <!-- Google Fonts & Bootstrap Icons & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --logix-navy-dark: #050E1A;
            --logix-navy: #0B2545;
            --logix-gold: #D4AF37;
            --logix-gold-hover: #E5C158;
            --logix-card-bg: rgba(11, 37, 69, 0.4);
            --logix-border: rgba(212, 175, 55, 0.2);
        }

        /* Custom Professional Custom Cursor */
        * {
            cursor: default !important;
        }
        a, button, .interactive-element {
            cursor: pointer !important;
        }

        .custom-cursor {
            width: 36px;
            height: 36px;
            border: 2px solid var(--logix-gold);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: width 0.2s ease, height 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
            z-index: 9999;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .cursor-dot {
            width: 6px;
            height: 6px;
            background-color: var(--logix-gold);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 10000;
            transition: transform 0.1s ease;
        }

        body.hovering .custom-cursor {
            width: 55px;
            height: 55px;
            background-color: rgba(212, 175, 55, 0.12);
            border-color: var(--logix-gold-hover);
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.5);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--logix-navy-dark);
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(11, 37, 69, 0.6) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 45%);
            color: #FFFFFF;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Advanced Staggered Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(35px); filter: blur(5px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 15px rgba(212, 175, 55, 0.2); }
            50% { box-shadow: 0 0 30px rgba(212, 175, 55, 0.4); }
            100% { box-shadow: 0 0 15px rgba(212, 175, 55, 0.2); }
        }

        .animate-fade-up-1 { animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-up-2 { animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s forwards; opacity: 0; }
        .animate-fade-up-3 { animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards; opacity: 0; }
        .animate-fade-up-4 { animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards; opacity: 0; }

        .splash-container {
            text-align: center;
            padding: 3rem 2.5rem;
            max-width: 800px;
            background: var(--logix-card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--logix-border);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(212, 175, 55, 0.08);
            border: 1px solid var(--logix-gold);
            color: var(--logix-gold);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 22px;
            animation: pulseGlow 3s infinite ease-in-out;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -1px;
        }

        h1 span {
            color: var(--logix-gold);
            background: linear-gradient(135deg, #D4AF37 0%, #FFF2B2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            font-size: 1.1rem;
            color: #94A3B8;
            margin-bottom: 35px;
            line-height: 1.7;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }

        .button-group {
            display: flex;
            gap: 18px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 14px 30px;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary-gold {
            background-color: var(--logix-gold);
            color: var(--logix-navy-dark);
            border: 1px solid var(--logix-gold);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-primary-gold:hover {
            background-color: var(--logix-gold-hover);
            color: var(--logix-navy-dark);
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
        }

        .btn-outline-gold {
            background-color: transparent;
            color: var(--logix-gold);
            border: 1px solid var(--logix-gold);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-gold:hover {
            background-color: var(--logix-gold);
            color: var(--logix-navy-dark);
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }
    </style>
</head>
<body>

    <!-- Custom Cursor Elements -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursor-dot"></div>

    <!-- Centralized Splash Screen Content -->
    <div class="splash-container">
        <div class="brand-badge animate-fade-up-1">
            <i class="bi bi-shield-check"></i> Secure Portals Access
        </div>
        <h1 class="animate-fade-up-2">LOGIX <span>CMS</span></h1>
        <p class="subtitle animate-fade-up-3">Empowering digital experiences with high-performance web engineering, clean architecture, and modern portal management systems.</p>
        
        <div class="button-group animate-fade-up-4">
            <a href="{{ route('student.login') }}" class="btn-custom btn-primary-gold interactive-element">
                <i class="bi bi-mortarboard-fill"></i> Student Portal
            </a>
            <a href="{{ route('login') }}" class="btn-custom btn-outline-gold interactive-element">
                <i class="bi bi-person-workspace"></i> Admin Login
            </a>
        </div>
    </div>

    <!-- Smooth Advanced Cursor JavaScript Tracker -->
    <script>
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursor-dot');
        
        let mouseX = 0, mouseY = 0;
        let cursorX = 0, cursorY = 0;

        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursorDot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
        });

        function renderCursor() {
            cursorX += (mouseX - cursorX) * 0.15;
            cursorY += (mouseY - cursorY) * 0.15;
            cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;
            requestAnimationFrame(renderCursor);
        }
        renderCursor();

        // Add Hover Effects for Interactive Elements
        const interactiveElements = document.querySelectorAll('a, button, .interactive-element');
        interactiveElements.forEach((el) => {
            el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
        });
    </script>
</body>
</html>