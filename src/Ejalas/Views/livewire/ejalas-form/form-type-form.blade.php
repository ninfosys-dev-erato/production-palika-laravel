<form wire:submit.prevent="save">
    <div class="row">

        <div class='col-md-12 mb-3'>
            <div class='form-group'>
                <label
                    for='name form-label'>{{ __('ejalas::ejalas.form_type_name') }}</label>
                <input dusk="formtype-name-field" wire:model='formType.name' name='name'
                    type='text' class="form-control {{ $errors->has('formType.name') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('formType.name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('ejalas::ejalas.enter_form_type_name') }}">
                <div>
                    @error('formType.name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="form_id"
                    class="position form-label">{{ __('ejalas::ejalas.select_form') }}</label>
                <select  class="form-select"
                   wire:model='formType.form_id'>
                    <option value="">{{ __('ejalas::ejalas.select_form') }}</option>
                    @foreach ($forms as $id => $title)
                        <option value="{{ $id }}">{{ $title }}</option>
                    @endforeach
                </select>
                <div>
                    @error('formType.form_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="form_type"
                    class="position form-label">{{ __('ejalas::ejalas.form_type') }}</label>
                <select  id="form_type" class="form-select"
                   wire:model='formType.form_type'>
                    <option value="">{{ __('ejalas::ejalas.select_form_type') }}</option>
                    @foreach ($formTypeOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div>
                    @error('formType.form_type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>


    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.form-template-type.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
