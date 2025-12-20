<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BannedUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate all fields including phone number uniqueness
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'unique:users,phone_number'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check if phone number or email is banned
        $bannedByPhone = BannedUser::where('phone_number', $request->phone_number)->first();
        $bannedByEmail = BannedUser::where('email', $request->email)->first();

        if ($bannedByPhone) {
            throw ValidationException::withMessages([
                'phone_number' => ['This phone number has been banned and cannot be used for registration.'],
            ]);
        }

        if ($bannedByEmail) {
            throw ValidationException::withMessages([
                'email' => ['This email has been banned and cannot be used for registration.'],
            ]);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard'));
    }
}