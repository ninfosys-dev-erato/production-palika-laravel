<div >
    <div class="card-body pt-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <p class="text-muted">
                    {{ __('A 6-digit OTP code has been sent to your email. It will expire in 5 minutes.') }}
                </p>
            </div>

            <div class='col-md-5 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='otpInput'>{{ __('Enter OTP') }}</label>
                    <input wire:model="otpInput" id="otpInput" name="otpInput" type="text" class='form-control' placeholder="{{ __('Enter 6-digit code') }}">
                </div>
                
            </div>

            <div class="col-md-7 d-flex align-items-end gap-2 mb-3">
                <button type="button" class="btn btn-primary" wire:click="verifyOtp" wire:loading.attr="disabled">
                    {{ __('Verify OTP') }}
                </button>
                <button type="button" class="btn btn-secondary " wire:click="resendOtp" wire:loading.attr="disabled">
                     {{ __('Resend OTP') }}
                </button>
            </div>
        </div>
        <div class="col-md-12">
            @error('otpInput')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>


@if($emailVerified)
<div class="alert alert-success mt-3" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ __('Email verified successfully!') }}
</div>
@endif
</div>