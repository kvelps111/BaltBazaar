<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BaltBazaar - Student Marketplace</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        :root {
            --balt-green: #2ecc71;
            --balt-green-dark: #27ae60;
            --dark: #1a1a1a;
            --light-bg: #f5f7fa;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            color: var(--dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        .bg-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: var(--balt-green);
            opacity: 0.08;
            animation: float 25s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 300px;
            height: 300px;
            top: 50%;
            right: -150px;
            animation-delay: 3s;
            animation-duration: 20s;
        }

        .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: 30%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .circle:nth-child(4) {
            width: 350px;
            height: 350px;
            top: 20%;
            right: 15%;
            animation-delay: 9s;
            animation-duration: 22s;
        }

        .circle:nth-child(5) {
            width: 250px;
            height: 250px;
            bottom: 20%;
            left: 10%;
            animation-delay: 12s;
            animation-duration: 28s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.08;
            }
            33% {
                transform: translate(40px, -40px) scale(1.2);
                opacity: 0.12;
            }
            66% {
                transform: translate(-30px, 30px) scale(0.9);
                opacity: 0.06;
            }
        }

        /* Header */
        header {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(46, 204, 113, 0.1);
            animation: slideDown 0.8s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        header .logo {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--balt-green);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        header nav {
            display: flex;
            gap: 1rem;
        }

        header nav a {
            text-decoration: none;
            font-weight: 600;
            color: var(--dark);
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        header nav a:hover {
            color: var(--balt-green);
            background: rgba(46, 204, 113, 0.1);
        }

        /* Hero Section */
        .hero {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4rem 2rem;
        }

        .hero-content {
            max-width: 800px;
            animation: fadeInUp 1s ease;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero h1 span {
            display: inline-block;
            animation: fadeInUp 1.2s ease backwards;
        }

        .hero h1 span:nth-child(1) { animation-delay: 0.1s; }
        .hero h1 span:nth-child(2) { animation-delay: 0.2s; }
        .hero h1 span:nth-child(3) { animation-delay: 0.3s; }

        .hero .subtitle {
            font-size: 1.4rem;
            color: #555;
            margin-bottom: 1rem;
            font-weight: 600;
            animation: fadeInUp 1.4s ease;
        }

        .hero p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeInUp 1.6s ease;
        }

        /* Feature Cards */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            width: 100%;
            max-width: 700px;
            animation: fadeInUp 1.8s ease;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            transition: all 0.3s ease;
            cursor: default;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--balt-green);
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.2);
        }

        .feature-card .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .feature-card h3 {
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .feature-card p {
            font-size: 0.85rem;
            color: #777;
            margin: 0;
        }

        /* Buttons */
        .buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 2s ease;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-login {
            background: var(--balt-green);
            color: #fff;
            box-shadow: 0 8px 20px rgba(46, 204, 113, 0.3);
        }

        .btn-login:hover {
            background: var(--balt-green-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(46, 204, 113, 0.4);
        }

        .btn-register {
            background: #fff;
            border: 2px solid var(--balt-green);
            color: var(--balt-green);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-register:hover {
            background: var(--balt-green);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.3);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        /* Footer */
        footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
            color: #777;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(46, 204, 113, 0.1);
        }

        footer a {
            color: var(--balt-green);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: var(--balt-green-dark);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 1rem 1.5rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero .subtitle {
                font-size: 1.1rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
                width: 100%;
                max-width: 300px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            header .logo {
                font-size: 1.5rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            header nav {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <!-- Header -->
    <header>
        <div class="logo">BaltBazaar</div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                <span>Welcome</span> <span>to</span> <span>BaltBazaar</span>
            </h1>
            <p class="subtitle">The Student Marketplace of the Baltics</p>
            <p>Buy, sell, and connect with fellow students across the Baltic region. Your trusted platform for student-to-student commerce.</p>

            <!-- Feature Cards -->
            <div class="features">
                <div class="feature-card">
                    <div class="icon">🎓</div>
                    <h3>Student-Focused</h3>
                    <p>Built by students, for students</p>
                </div>
                <div class="feature-card">
                    <div class="icon">💰</div>
                    <h3>Save Money</h3>
                    <p>Best deals on campus essentials</p>
                </div>
                <div class="feature-card">
                    <div class="icon">🤝</div>
                    <h3>Safe & Trusted</h3>
                    <p>Verified student community</p>
                </div>
            </div>

            <!-- Call to Action Buttons -->
            <div class="buttons">
                <a href="{{ route('login') }}" class="btn btn-login">
                    <span>Login</span>
                    <span>→</span>
                </a>
                <a href="{{ route('register') }}" class="btn btn-register">
                    <span>Create Account</span>
                    
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} BaltBazaar. All rights reserved. | 
        <a href="#">Privacy Policy</a> | 
        <a href="#">Terms of Service</a>
    </footer>
</body>
</html>