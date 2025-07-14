<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Name') }}" id="name" name="user.name" />
            </div>

            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Email') }}" id="email" type="email" name="user.email" />
            </div>
            <div class='col-md-4'>
                <div class="d-flex gap-2">
                    <span>
                        <x-form.file-input :label="__('Signature')" id="signature" name="user.signature" accept="image/*" />
                    </span>
                    @if (is_string($user['signature']) && !empty($user['signature']))
                        <img src="{{ customAsset(config('src.Profile.profile.path'), $this->user['signature']) }}"
                            alt="Signature" width="50">
                    @endif
                </div>


            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.profile.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
