<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - BaltBazaar</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
    
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
        }

        /* Main Content */
        .container {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .verification-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 2px solid rgba(46, 204, 113, 0.15);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.8s ease;
        }

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

        .icon-container {
            text-align: center;
            margin-bottom: 2rem;
            animation: scaleIn 0.8s ease 0.2s both;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(46, 204, 113, 0.2);
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1rem;
            text-align: center;
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .info-box {
            background: rgba(46, 204, 113, 0.08);
            border-left: 4px solid var(--balt-green);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease 0.5s both;
        }

        .info-box p {
            font-size: 0.95rem;
            color: #555;
            margin: 0;
            line-height: 1.5;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-direction: column;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .btn {
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: #fff;
            box-shadow: 0 8px 20px rgba(46, 204, 113, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(46, 204, 113, 0.4);
        }

        .btn-secondary {
            background: #fff;
            border: 2px solid var(--balt-green);
            color: var(--balt-green);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: rgba(46, 204, 113, 0.05);
            transform: translateY(-3px);
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
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 1rem 1.5rem;
            }

            header .logo {
                font-size: 1.5rem;
            }

            .verification-box {
                padding: 2rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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

    <!-- Main Content -->
    <div class="container">
        <div class="verification-box">
            <div class="icon-container">
                <div class="icon-circle">✉️</div>
            </div>

            <h1>Verify Your Email</h1>

            <p class="subtitle">
                Welcome to BaltBazaar! We've sent a verification link to your email address. Please check your inbox and click the link to activate your account.
            </p>

            <div class="info-box">
                <p>
                    <strong>Didn't receive the email?</strong> Check your spam folder or request a new verification link below.
                </p>
            </div>

            <div class="button-group">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">
                        Logout
                    </button>
                </form>
            </div>

            @if ($errors->any())
                <div style="background: #fee; border-left: 4px solid #c00; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                    @foreach ($errors->all() as $error)
                        <p style="color: #c00; margin: 0.5rem 0; font-size: 0.9rem;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} BaltBazaar. All rights reserved.
    </footer>
</body>
</html>