<x-guest-layout>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="verify-box">
        <div class="verify-icon">✉️</div>

        <h1 class="verify-title">Verify Your Email</h1>

        <p class="verify-subtitle">
            Welcome to BaltBazaar! We've sent a verification link to your email address. Please check your inbox and click the link to activate your account.
        </p>

        <div class="verify-info-box">
            <p>
                <strong>Didn't receive the email?</strong> Check your spam folder or request a new verification link below.
            </p>
        </div>

        <div class="verify-button-group">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button type="submit" class="btn-primary w-full">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="btn-secondary w-full">
                    Logout
                </button>
            </form>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mt-4">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm my-1">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</x-guest-layout>
