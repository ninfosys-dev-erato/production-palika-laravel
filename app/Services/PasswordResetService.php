<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class PasswordResetService
{
    public function sendOtp(User $user)
    {
        // Generate random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in cache for 10 minutes
        Cache::put('password_reset_otp_' . $user->email, $otp, now()->addMinutes(10));
// dd(Cache::get('password_reset_otp_' . $user->email), $user->email);
        // Send OTP via email
        Mail::raw("Your password reset OTP is: {$otp}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset OTP');
        });

        return $otp;
    }

    public function verifyOtp(string $email, string $otp): bool
    {
        $cachedOtp = Cache::get('password_reset_otp_' . $email);

        // dd($cachedOtp, $otp, $email);

        return $cachedOtp && $cachedOtp == $otp;
    }
}
