<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Current Password') }}" id="current_password" type="password"
                    name="form.current_password" />
            </div>

            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Password') }}" id="password" type="password" name="form.password" />
            </div>
            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Confirm Password') }}" id="password_confirmation"
                    type="password_confirmation" name="form.password_confirmation" />
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.profile.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
