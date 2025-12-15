<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        :root {
            --balt-green: #2ecc71;
            --balt-green-dark: #27ae60;
            --dark: #1a1a1a;
        }

        /* Animated Background */
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
            opacity: 0.06;
            animation: float 25s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
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

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.06;
            }
            33% {
                transform: translate(40px, -40px) scale(1.2);
                opacity: 0.1;
            }
            66% {
                transform: translate(-30px, 30px) scale(0.9);
                opacity: 0.04;
            }
        }

        /* Profile Page */
        .profile-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 3rem 1.5rem;
        }

        /* Page Header */
        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.8s ease;
        }

        .profile-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .profile-header p {
            color: #666;
            font-size: 1.1rem;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Profile Container */
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            display: grid;
            gap: 2rem;
        }

        /* Profile Card */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease;
            animation-fill-mode: both;
        }

        .profile-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .profile-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .profile-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .profile-card:hover {
            border-color: var(--balt-green);
            box-shadow: 0 8px 30px rgba(46, 204, 113, 0.15);
            transform: translateY(-2px);
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

        /* Responsive */
        @media (max-width: 768px) {
            .profile-header h1 {
                font-size: 2rem;
            }

            .profile-card {
                padding: 1.5rem;
            }

            .profile-page {
                padding: 2rem 1rem;
            }
        }
    </style>

    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="profile-page bg-gradient-to-br from-gray-50 to-green-50/30">
        <!-- Page Header -->
        <div class="profile-header">
            <h1>🔧 Mans profils</h1>
            <p>Pārvaldiet savu kontu un iestatījumus</p>
        </div>

        <div class="profile-container">
            <div class="profile-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="profile-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
