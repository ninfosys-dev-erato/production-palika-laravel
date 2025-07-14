<form wire:submit.prevent="save">
    <div class="row">

        <div class='col-md-12 mb-3'>
            <div class='form-group'>
                <label
                    for='position form-label'>{{ __('businessregistration::businessregistration.registration_type') }}</label>
                <input dusk="businessregistration-title-field" wire:model='registrationType.title' name='title'
                    type='text' class="form-control {{ $errors->has('registrationType.title') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('registrationType.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('businessregistration::businessregistration.registration_type') }}">
                <div>
                    @error('registrationType.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="form_id"
                    class="position form-label">{{ __('businessregistration::businessregistration.select_form') }}</label>
                <select dusk="businessregistration-form_id-field" id="form_id" class="form-select select2-component"
                    style="width: 100%;" wire:model='registrationType.form_id'>
                    <option>{{ __('businessregistration::businessregistration.select_form') }}</option>
                    @foreach ($forms as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @error('registrationType.form_id')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div>



        {{-- <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="registration_category_id"
                    class="position form-label">{{ __('businessregistration::businessregistration.select_category') }}</label>
                <select dusk="businessregistration-registration_category_id-field" id="registration_category_id"
                    class="form-select" style="width: 100%;" wire:model='registrationType.registration_category_id'
                    name="registrationType.registration_category_id">
                    <option>{{ __('businessregistration::businessregistration.select_category') }}</option>
                    @foreach ($registrationCategories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @error('registrationType.registration_category_id')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div> --}}

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="registration_category_enum"
                    class="position form-label">{{ __('businessregistration::businessregistration.select_category_enum') }}</label>
                <select dusk="businessregistration-registration_category_enum-field" id="registration_category_enum"
                    class="form-select" style="width: 100%;" wire:model='registrationType.registration_category_enum'
                    name="registrationType.registration_category_enum">
                    <option>{{ __('businessregistration::businessregistration.select_category') }}</option>
                    @foreach ($registration_category_enums as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @error('registrationType.registration_category_enum')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="form_id"
                    class="position form-label">{{ __('businessregistration::businessregistration.select_action') }}</label>
                <select dusk="businessregistration-select_action" id="select_action" class="form-select"
                    style="width: 100%;" wire:model="registrationType.action">
                    <option>{{ __('businessregistration::businessregistration.select_action') }}</option>
                    @foreach ($businessActions as $action)
                        <option value="{{ $action->value }}">{{ $action->label() }}</option>
                    @endforeach
                </select>
            </div>
            @error('registrationType.form_id')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div>


        @if ($isBusiness)
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="department_id"
                        class="position form-label">{{ __('businessregistration::businessregistration.select_department') }}</label>
                    <select dusk="businessregistration-department_id-field" id="department_id" class="form-select"
                        style="width: 100%;" wire:model='registrationType.department_id'
                        name="registrationType.department_id">
                        <option>{{ __('businessregistration::businessregistration.select_category') }}</option>
                        @foreach ($departments as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @error('registrationType.department_id')
                    <div class="invalid-feedback">{{ __($message) }}</div>
                @enderror
            </div>

        @endif

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('businessregistration::businessregistration.save') }}</button>
        <a href="{{ route('admin.business-registration.registration-types.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('businessregistration::businessregistration.back') }}</a>
    </div>
</form>

{{-- @script
<script>
    $(document).ready(function () {
        const registrationCategory = $('#registration_category_id');

        registrationCategory.select2({
            placeholder: "{{ __('businessregistration::businessregistration.select_registration_category') }}"
        })

        registrationCategory.on('change', function () {
            const selectedCategory = $(this).val();
            @this.set('registrationType.registration_category_id', selectedCategory);
        })
    })
</script>
@endscript --}}
