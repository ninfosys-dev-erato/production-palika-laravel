<?php

namespace App\Services;

use App\Mail\EmailVerificationOTPMail;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EmailVerificationService
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ?? Auth::user();
    }

    /**
     * Send OTP to user email
     */
    public function sendOtp(): bool
    {
        $otp = rand(100000, 999999);

        // Save or update OTP in DB, expires in 5 minutes
        EmailOtp::updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5)
            ]
        );

        // Send email
        Mail::to($this->user->email)->send(new EmailVerificationOTPMail($otp));

        return true;
    }

    /**
     * Resend OTP
     */
    public function resendOtp(): bool
    {
        // Optional: Add rate limiting if needed
        return $this->sendOtp();
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(string $otp): bool
    {
        $otpRecord = EmailOtp::where('user_id', $this->user->id)
                             ->where('otp', $otp)
                             ->first();

        if (!$otpRecord) {
            return false; // Invalid OTP
        }

        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return false; // Expired OTP
        }

        // Mark user as verified
        $this->user->email_verified_at = Carbon::now();
        $this->user->save();

        // Delete OTP after verification
        $otpRecord->delete();

        return true;
    }

    /**
     * Check if email is already verified
     */
    public function isVerified(): bool
    {
        return (bool) $this->user->email_verified_at;
    }
}
