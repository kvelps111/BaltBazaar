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
        <div class="verify-icon">📱</div>

        <h1 class="verify-title">Verify Your Phone Number</h1>

        <div class="verify-info-box mb-4">
            <p>
                We've sent a 6-digit verification code to <strong>{{ session('verification_phone') }}</strong>
            </p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-4">
                <p class="text-green-600 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.phone.verify') }}" class="w-full">
            @csrf
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
                <input 
                    id="code" 
                    type="text" 
                    name="code" 
                    placeholder="123456"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl tracking-widest"
                    maxlength="6"
                    required 
                    autofocus
                />
                @error('code')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full">
                Verify Phone Number
            </button>
        </form>

        <form method="POST" action="{{ route('verification.phone.resend') }}" class="w-full mt-3">
            @csrf
            <button type="submit" class="btn-secondary w-full">
                Resend Code
            </button>
        </form>

        <div class="verify-button-group mt-4">
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