<form wire:submit.prevent="save">
    <div class="row">

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='position form-label'>{{ __('businessregistration::businessregistration.registration_category') }}</label>
                <input dusk="businessregistration-registrationCategory.title-field" wire:model='registrationCategory.title' name='registrationCategory.title' type='text'
                    class="form-control {{ $errors->has('registrationCategory.title') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('registrationCategory.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('businessregistration::businessregistration.registration_category') }}">
                <div>
                    @error('registrationCategory.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='position form-label'>{{ __('businessregistration::businessregistration.registration_category') }} {{ 'नेपाली' }}</label>
                <input dusk="businessregistration-registrationCategory.title_ne-field" wire:model='registrationCategory.title_ne' name='registrationCategory.title_ne' type='text'
                    class="form-control {{ $errors->has('registrationCategory.title_ne') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('registrationCategory.title_ne') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('businessregistration::businessregistration.registration_category_नपल') }}">
                <div>
                    @error('registrationCategory.title_ne')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('businessregistration::businessregistration.save') }}</button>
        <a href="{{ route('admin.business-registration.registration-category.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('businessregistration::businessregistration.back') }}</a>
    </div>
</form>