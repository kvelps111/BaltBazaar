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
use Twilio\Rest\Client;

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
        // Validate all fields - phone is now just 8 digits
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => [
                'required', 
                'string',
                'regex:/^[0-9]{8}$/'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone_number.regex' => 'Phone number must be 8 digits'
        ]);

        // Add +371 prefix to phone number
        $phoneNumber = '+371' . $request->phone_number;

        // Check if phone number or email is banned
        $bannedByPhone = BannedUser::where('phone_number', $phoneNumber)->first();
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

        // Check if phone number already exists
        if (User::where('phone_number', $phoneNumber)->exists()) {
            throw ValidationException::withMessages([
                'phone_number' => ['This phone number is already registered.'],
            ]);
        }

        // Create user with full international phone number
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $phoneNumber,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Generate and send verification code
        $code = rand(100000, 999999);
        
        session([
            'verification_code' => $code,
            'verification_phone' => $phoneNumber,
            'code_sent_at' => now()
        ]);

        // Send SMS via Twilio
        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $twilio->messages->create($phoneNumber, [
            'from' => config('services.twilio.phone'),
            'body' => "Your BaltBazaar verification code is: {$code}"
        ]);

        return redirect()->route('verification.phone.prompt');
    }
}