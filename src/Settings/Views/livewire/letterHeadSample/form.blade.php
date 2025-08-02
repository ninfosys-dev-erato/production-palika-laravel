<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-12 mb-3'>
            <label for="name" class="form-label">{{ __('settings::settings.name') }}</label>
            <input type="text" id="name" name="name"
                class="form-control {{ $errors->has('letterHeadSample.name') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('letterHeadSample.name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                wire:model.defer="letterHeadSample.name" placeholder="{{ __('settings::settings.enter_name') }}">
            @error('letterHeadSample.name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class='col-md-12 mb-3'>
            <label for="slug" class="form-label">{{ __('settings::settings.slug') }}</label>
            <select id="slug" name="slug"
                class="form-control {{ $errors->has('letterHeadSample.slug') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('letterHeadSample.slug') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                wire:model.defer="letterHeadSample.slug">
                <option value="">{{ __('settings::settings.select_template_type') }}</option>
                @foreach ($templateTypes as $value => $label)
                    <option value="{{ $value }}">
                        {{ __($label) }}
                    </option>
                @endforeach
            </select>
            @error('letterHeadSample.slug')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class='col-md-12 mb-3'>
            <x-form.ck-editor-input label="{{ __('settings::settings.content') }}" id="content"
                name="letterHeadSample.content" :value="$letterHeadSample->content ?? ''" />
        </div>

        <div class='col-md-12 mb-3'>
            <label for="style" class="form-label">{{ __('settings::settings.style') }}</label>
            <textarea id="style" name="style" rows="5"
                class="form-control {{ $errors->has('letterHeadSample.style') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('letterHeadSample.style') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                wire:model.defer="letterHeadSample.style" placeholder="{{ __('settings::settings.enter_style') }}">{{ $letterHeadSample->style ?? '' }}</textarea>
            @error('letterHeadSample.style')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('settings::settings.save') }}</button>
        <a href="{{ route('admin.letter-head-sample.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('settings::settings.back') }}</a>
    </div>
</form>
