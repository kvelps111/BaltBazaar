<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Twilio\Rest\Client;

class PhoneVerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $key = 'send-sms:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['phone' => "Pārāk daudz mēģinājumu. Mēģiniet vēlreiz pēc {$seconds} sekundēm."]);
        }

        RateLimiter::hit($key, 3600);

        $code = rand(100000, 999999);

        session([
            'verification_code'  => $code,
            'verification_phone' => $request->phone,
            'code_sent_at'       => now(),
        ]);

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

        $key = 'verify-code:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['code' => 'Pārāk daudz nepareizu mēģinājumu. Lūdzu, pieprasiet jaunu kodu.']);
        }

        $sentAt = session('code_sent_at');

        if (!$sentAt || now()->diffInMinutes($sentAt) > 10) {
            return back()->withErrors(['code' => 'Koda derīguma laiks ir beidzies. Lūdzu, pieprasiet jaunu kodu.']);
        }

        if ((int) $request->code === (int) session('verification_code')) {
            RateLimiter::clear($key);
            $user = $request->user();
            $user->phone_verified_at = now();
            $user->save();
            session()->forget(['verification_code', 'verification_phone', 'code_sent_at']);

            return redirect()->route('dashboard');
        }

        RateLimiter::hit($key, 3600);

        return back()->withErrors(['code' => 'Nepareizs kods.']);
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
        $key = 'send-sms:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['code' => "Pārāk daudz mēģinājumu. Mēģiniet vēlreiz pēc {$seconds} sekundēm."]);
        }

        RateLimiter::hit($key, 3600);

        $phone = session('verification_phone') ?? $request->user()->phone_number;

        if (!$phone) {
            return back()->withErrors(['code' => 'Nav atrasts tālruņa numurs. Lūdzu, ievadiet numuru vispirms.']);
        }

        $code = rand(100000, 999999);

        session([
            'verification_code' => $code,
            'code_sent_at'      => now(),
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
