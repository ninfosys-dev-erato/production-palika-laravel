<form wire:submit.prevent="save">

    <div class="row">

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='position form-label'>{{ __('businessregistration::businessregistration.business_nature') }}</label>
                <input dusk="businessregistration-title-field" wire:model='businessNature.title' name='title' type='text' class='form-control'
                    placeholder="{{ __('businessregistration::businessregistration.business_nature') }}">
                <div>
                    @error('title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='position form-label'>{{ __('businessregistration::businessregistration.business_nature') }} (नेपाली)</label>
                <input dusk="businessregistration-title-field" wire:model='businessNature.title_ne' name='title' type='text' class='form-control'
                    placeholder="{{ __('businessregistration::businessregistration.business_nature') }}">
                <div>
                    @error('title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('businessregistration::businessregistration.save') }}</button>
        <a href="{{ route('admin.business-registration.business-nature.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('businessregistration::businessregistration.back') }}</a>
    </div>
</form>