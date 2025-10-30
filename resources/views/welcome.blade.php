<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BaltBazaar</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
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
            background: #fff;
            color: var(--dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            border-bottom: 1px solid #eee;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--balt-green);
            letter-spacing: 1px;
        }

        header nav a {
            margin-left: 1.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        header nav a:hover {
            color: var(--balt-green);
        }

        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4rem 2rem;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--balt-green);
            margin-bottom: 1rem;
            animation: fadeInDown 1s ease;
        }

        .hero p {
            font-size: 1.25rem;
            color: #555;
            max-width: 600px;
            margin-bottom: 2.5rem;
            animation: fadeInUp 1.2s ease;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 1.4s ease;
        }

        .btn {
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            font-size: 1rem;
        }

        .btn-login {
            background: var(--balt-green);
            color: #fff;
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
        }

        .btn-login:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }

        .btn-register {
            background: #fff;
            border: 2px solid var(--balt-green);
            color: var(--balt-green);
        }

        .btn-register:hover {
            background: var(--balt-green);
            color: #fff;
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            color: #777;
            border-top: 1px solid #eee;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1rem; }
            header { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">BaltBazaar</div>
        
    </header>

    <section class="hero">
        <h1>Welcome to BaltBazaar</h1>
        <p>The student marketplace of the Baltics — buy, sell, and connect with ease.</p>
        <div class="buttons">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
        </div>
    </section>

    <footer>
        &copy; {{ date('Y') }} BaltBazaar. All rights reserved.
    </footer>
</body>
</html>
