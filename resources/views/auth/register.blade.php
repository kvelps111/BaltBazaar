<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BaltBazaar</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --balt-green: #2ecc71;
            --dark: #1a1a1a;
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: var(--balt-green);
            opacity: 0.1;
            animation: float 25s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 50%;
            right: -100px;
            animation-delay: 3s;
            animation-duration: 15s;
        }

        .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: -75px;
            left: 30%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .circle:nth-child(4) {
            width: 250px;
            height: 250px;
            top: 20%;
            right: 20%;
            animation-delay: 9s;
            animation-duration: 22s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        /* Container */
        .register-container {
            position: relative;
            z-index: 1;
            background: #fff;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 480px;
            width: 100%;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--balt-green);
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .logo p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: 'Figtree', sans-serif;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: var(--balt-green);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Button Styles */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .login-link {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .login-link:hover {
            color: var(--balt-green);
        }

        .btn-register {
            background: var(--balt-green);
            color: #fff;
            padding: 0.875rem 2.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
            font-family: 'Figtree', sans-serif;
        }

        .btn-register:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .register-container {
                padding: 2rem 1.5rem;
            }

            .logo h1 {
                font-size: 1.75rem;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-register {
                width: 100%;
            }

            .login-link {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="register-container">
        <div class="logo">
            <h1>BaltBazaar</h1>
            <p>Join the student marketplace</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_number">Telefona numurs</label>
                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" placeholder="+371 12345678" />
                @error('phone_number')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <a class="login-link" href="{{ route('login') }}">
                    Already registered?
                </a>

                <button type="submit" class="btn-register">
                    Register
                </button>
            </div>
        </form>
    </div>
</body>
</html>