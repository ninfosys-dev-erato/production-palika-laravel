<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-12'>
            <x-form.ck-editor-input label="{{ __('settings::settings.header') }}" id="header" name="letterHead.header"
                :value="$letterHead->header ?? ''" />

        </div>
        <div class='col-md-12'>
            <x-form.ck-editor-input label="{{ __('settings::settings.footer') }}" id="footer" name="letterHead.footer"
                :value="$letterHead->footer ?? ''" />
        </div>


        <div class="col-md-6 mb-3">
            <label for="ward_no">{{ __('settings::settings.ward_no') }}</label>
            <select id="ward_no" name="ward_no" class="form-control {{ $errors->has('ward_no') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('customer.gender') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                wire:model.defer="letterHead.ward_no">
                <option value="">{{ __('settings::settings.select_ward') }}</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}">{{ __('settings::settings.ward') }} {{ $i }}</option>
                @endfor
            </select>
            @error('letterHead.ward_no')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="is_active">{{ __('settings::settings.status') }}</label>
            <select id="is_active" name="is_active"
                class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('is_active') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"wire:model.defer="letterHead.is_active">
                <option value="">{{ __('settings::settings.select_status') }}</option>
                <option value="1">{{ __('settings::settings.active') }}</option>
                <option value="0">{{ __('settings::settings.inactive') }}</option>
            </select>
            @error('letterHead.is_active')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('settings::settings.save') }}</button>
        <a href="{{ route('admin.setting.letter-head.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('settings::settings.back') }}</a>
    </div>
</form>
