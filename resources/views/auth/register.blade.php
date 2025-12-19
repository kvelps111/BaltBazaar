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
            <p class="auth-logo-subtitle">Join the student marketplace</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="auth-form-group">
                <label for="name" class="auth-label">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name" class="auth-input" />
                @error('name')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="auth-form-group">
                <label for="email" class="auth-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username" class="auth-input" />
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="auth-form-group">
                <label for="phone_number" class="auth-label">Telefona numurs</label>
                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}"
                       required autocomplete="tel" placeholder="+371 12345678" class="auth-input" />
                @error('phone_number')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password" class="auth-input" />
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="auth-form-group">
                <label for="password_confirmation" class="auth-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password" class="auth-input" />
                @error('password_confirmation')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-footer">
                <a class="auth-link" href="{{ route('login') }}">
                    Already registered?
                </a>

                <button type="submit" class="auth-btn">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
