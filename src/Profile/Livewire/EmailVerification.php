<?php

namespace Src\Profile\Livewire;

use Livewire\Component;
use App\Services\EmailVerificationService;
use App\Traits\SessionFlash;

class EmailVerification extends Component
{
    use SessionFlash;

    public $otpInput;
    public $emailVerified;

    protected $rules = [
        'otpInput' => 'required|digits:6',
    ];

    public function mount()
    {
        $service = new EmailVerificationService();
        $this->emailVerified = $service->isVerified();
    }

    public function sendEmailVerification()
    {
        $service = new EmailVerificationService();
        $service->sendOtp();
        $this->successFlash(__('OTP sent to your email'));
    }

    public function resendOtp()
    {
        $service = new EmailVerificationService();
        $service->resendOtp();
        $this->successFlash(__('OTP resent'));
    }

    public function verifyOtp()
    {
        $this->validate();

        $service = new EmailVerificationService();

        if ($service->verifyOtp($this->otpInput)) {
            $this->emailVerified = true;
            $this->successFlash(__('Email verified successfully'));
            $this->dispatch('close-modal');
        } else {
            $this->addError('otpInput', __('Invalid or expired OTP'));
        }
    }

    public function render()
    {
        return view('Profile::livewire.email-verification');
    }
}
