<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class PhoneVerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $code = rand(100000, 999999);
        
        // Store in session with 10 min expiry
        session([
            'verification_code' => $code,
            'verification_phone' => $request->phone,
            'code_sent_at' => now()
        ]);

        // Send SMS
        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $twilio->messages->create($request->phone, [
            'from' => config('services.twilio.phone'),
            'body' => "Your verification code is: {$code}"
        ]);

        return back()->with('success', 'Code sent!');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);

        if ($request->code == session('verification_code')) {
            // Mark user as phone verified
            $request->user()->update(['phone_verified_at' => now()]);
            session()->forget(['verification_code', 'verification_phone', 'code_sent_at']);
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['code' => 'Invalid code']);
    }

    public function prompt()
    {
        if (auth()->user()->phone_verified_at) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-phone');
    }

    public function resendCode(Request $request)
    {
        $phone = session('verification_phone') ?? $request->user()->phone_number;

        if (!$phone) {
            return back()->withErrors(['code' => 'No phone number found. Please enter your number first.']);
        }

        $code = rand(100000, 999999);

        session([
            'verification_code' => $code,
            'code_sent_at' => now()
        ]);

        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $twilio->messages->create($phone, [
            'from' => config('services.twilio.phone'),
            'body' => "Your BaltBazaar verification code is: {$code}"
        ]);

        return back()->with('success', 'New code sent!');
    }
}