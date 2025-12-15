<section>
    <style>
        .section-header {
            margin-bottom: 1.5rem;
            border-bottom: 2px solid rgba(46, 204, 113, 0.1);
            padding-bottom: 1rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-description {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(46, 204, 113, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--balt-green);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        .form-input:hover {
            border-color: var(--balt-green);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        .success-message {
            color: var(--balt-green);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .verification-notice {
            background: rgba(46, 204, 113, 0.1);
            border: 2px solid rgba(46, 204, 113, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 0.75rem;
        }

        .verification-notice p {
            color: var(--dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .btn-verify {
            background: none;
            border: none;
            color: var(--balt-green);
            text-decoration: underline;
            cursor: pointer;
            font-weight: 600;
            padding: 0;
            transition: all 0.2s ease;
        }

        .btn-verify:hover {
            color: var(--balt-green-dark);
        }

        .verification-sent {
            color: var(--balt-green);
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>

    <header class="section-header">
        <h2 class="section-title">
            {{ __('Profile Information') }}
        </h2>
        <p class="section-description">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-input"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-input"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verification-notice">
                    <p>
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn-verify">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="verification-sent">
                            ✓ {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-save">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="success-message"
                >✓ {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
