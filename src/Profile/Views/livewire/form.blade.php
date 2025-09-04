<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Name') }}" id="name" name="user.name" />
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" id="email" name="user.email" 
                           placeholder="{{ __('Enter your email') }}" wire:model="user.email">
            
                    @if($user->hasVerifiedEmail())
                    <span class="input-group-text bg-black text-white">
                        <i class="bx bx-check"></i>
                    </span>
                    @endif
                </div>
            </div>
            
           
            <div class='col-md-4'>
                <div class="d-flex gap-2">
                    <span>
                        <x-form.file-input :label="__('Signature')" id="signature" name="user.signature" accept="image/*" />
                    </span>
                    @if (is_string($user['signature']) && !empty($user['signature']))
                        <img src="{{ customFileAsset(config('src.Profile.profile.path'), $this->user['signature'], 'local', 'tempUrl') }}"
                            alt="Signature" width="50">
                    @endif
                </div>
            </div>
        </div>

        @if (!$user->hasVerifiedEmail())
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ __('Your email address has not been verified.') }}
                    <button type="button" class="btn btn-primary btn-sm ms-3" wire:click="sendEmailVerification" wire:loading.attr="disabled">
                        <i class="fas fa-envelope me-1"></i>
                        {{ __('Verify Email') }}
                    </button>
                </div>
            </div>
        </div>
        @endif
       
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.profile.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
