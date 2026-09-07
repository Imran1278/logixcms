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
            --logix-card-bg: rgba(11, 37, 69, 0.5);
            --logix-border: rgba(212, 175, 55, 0.25);
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

        /* Clean & Professional Fade-In Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-down { animation: fadeInDown 0.8s ease forwards; }
        .animate-up-1 { animation: fadeInUp 0.8s ease 0.2s forwards; opacity: 0; }
        .animate-up-2 { animation: fadeInUp 0.8s ease 0.35s forwards; opacity: 0; }
        .animate-up-3 { animation: fadeInUp 0.8s ease 0.5s forwards; opacity: 0; }

        .splash-container {
            text-align: center;
            padding: 3rem 2.5rem;
            max-width: 750px;
            width: 90%;
            background: var(--logix-card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--logix-border);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--logix-gold);
            color: var(--logix-gold);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        h1 span {
            color: var(--logix-gold);
        }

        p.subtitle {
            font-size: 1rem;
            color: #94A3B8;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 580px;
            margin-left: auto;
            margin-right: auto;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 12px 28px;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-gold {
            background-color: var(--logix-gold);
            color: var(--logix-navy-dark);
            border: 1px solid var(--logix-gold);
        }

        .btn-primary-gold:hover {
            background-color: var(--logix-gold-hover);
            border-color: var(--logix-gold-hover);
            color: var(--logix-navy-dark);
            transform: translateY(-2px);
        }

        .btn-outline-gold {
            background-color: transparent;
            color: var(--logix-gold);
            border: 1px solid var(--logix-gold);
        }

        .btn-outline-gold:hover {
            background-color: var(--logix-gold);
            color: var(--logix-navy-dark);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <!-- Centralized Splash Screen Content -->
    <div class="splash-container">
        <div class="brand-badge animate-down">
            <i class="bi bi-shield-check"></i> Secure Portals Access
        </div>
        <h1 class="animate-up-1">LOGIX <span>CMS</span></h1>
        <p class="subtitle animate-up-2">Empowering digital experiences with high-performance web engineering, clean architecture, and modern portal management systems.</p>
        
        <div class="button-group animate-up-3">
            <a href="{{ route('student.login') }}" class="btn-custom btn-primary-gold">
                <i class="bi bi-mortarboard-fill"></i> Student Portal
            </a>
            <a href="{{ route('login') }}" class="btn-custom btn-outline-gold">
                <i class="bi bi-person-workspace"></i> Admin Login
            </a>
        </div>
    </div>

</body>
</html>