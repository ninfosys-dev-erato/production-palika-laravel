<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Hash;
use App\Traits\SessionFlash;


class ForgotPassword extends Component
{
    public $step = 1; // wizard step
    public $email;
    public $user;
    public $otp;
    public $password;
    public $password_confirmation;

    protected PasswordResetService $service;

    use sessionFlash;
    // Inject service via boot
    public function boot(PasswordResetService $service)
    {
        $this->service = $service;
    }

    // Step 1: Send OTP
    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $this->email)->first();
        $this->user = $user;
        if (! $user) {
            $this->addError('email', 'This email is not registered.');
            return;
        }

        $this->service->sendOtp($user);

        $this->successFlash('OTP has been sent to your email.');

        $this->step = 2; // move to OTP entry
    }

    // Step 2: Verify OTP
    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);
        if (! $this->service->verifyOtp($this->user->email, $this->otp)) {
            $this->addError('otp', 'Invalid or expired OTP.');
            return;
        }

        $this->step = 3; // move to password reset
    }

    // Step 3: Reset Password
    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $this->user->password = Hash::make($this->password);
        $this->user->save();

        $this->successFlash('Password has been reset successfully.');

        $this->reset(['step', 'email', 'otp', 'password', 'password_confirmation']);
        
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}
