<x-guest-layout>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="auth-container">
        <div class="auth-logo">
            <h1 class="auth-logo-title">BaltBazaar</h1>
            <p class="auth-logo-subtitle">Welcome back to the marketplace</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="auth-session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="auth-form-group">
                <label for="email" class="auth-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username" class="auth-input" />
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password" class="auth-input" />
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="auth-form-group">
                <div class="auth-remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
            </div>

            <div class="auth-footer">
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif

                <button type="submit" class="auth-btn">
                    Log in
                </button>
            </div>
        </form>

        <div class="auth-divider">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link-green">Register now</a>
        </div>
    </div>
</x-guest-layout>
