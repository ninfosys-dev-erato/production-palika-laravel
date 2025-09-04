<div>
    @if ($step === 1)
        <h4 class="mb-2">Forgot Password?</h4>
        <p class="mb-4">Please Enter Registered Email To Reset Password</p>
        <form wire:submit.prevent="sendOtp">
            <div class="mb-3">
                <label class="form-label">Registered Email</label>
                <input type="email" wire:model.defer="email" class="form-control" placeholder="Enter your email">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Send OTP</button>
        </form>
    @elseif ($step === 2)
        <form wire:submit.prevent="verifyOtp">
            <div class="mb-3">
                <label class="form-label">Enter OTP</label>
                <input type="text" wire:model.defer="otp" class="form-control" placeholder="6-digit OTP">
                <small class="text-muted">OTP will expire in 5 minutes</small>
                @error('otp') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>
    @elseif ($step === 3)
        <form wire:submit.prevent="resetPassword">
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" wire:model.defer="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" wire:model.defer="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    @endif
</div>
