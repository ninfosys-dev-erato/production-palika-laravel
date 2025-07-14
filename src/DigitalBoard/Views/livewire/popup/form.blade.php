<form wire:submit.prevent="save">
    <div class="row">

        <div class='col-md-12 mb-3'>
            <div class='form-group'>
                <label for='photo' class="form-label">{{ __('digitalboard::digitalboard.select_popup_photo') }}</label>
                <input dusk="digitalboard-uploadedImage-field" wire:model="uploadedImage" name='uploadedImage' type='file'
                    class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('uploadedImage') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    accept=".jpg,.jpeg,.png" placeholder="{{ __('digitalboard::digitalboard.select_popup_photo') }}">
                <div>
                    @error('uploadedImage')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
                @if (
                    ($uploadedImage && $uploadedImage instanceof \Illuminate\Http\File) ||
                        $uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
                        $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                    <img src="{{ $uploadedImage->temporaryUrl() }}" alt="Uploaded Image Preview"
                        class="img-thumbnail mt-2" style="height: 300px;">
                @elseif($popUp->exists)
                    <img src="{{ customAsset(config('src.DigitalBoard.popup.popup_path'), $uploadedImage) }}"
                        alt="Current Banner Image" class="img-thumbnail mt-2" style="height: 300px;">
                @endif
            </div>

        </div>

        <div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>{{ __('digitalboard::digitalboard.popup_title') }}</label>
                <input dusk="digitalboard-title-field" wire:model='popUp.title' name='title' type='text'
                    class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('uploadedImage') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.popup_title') }}">
                <div>
                    @error('popUp.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group" wire:ignore>
                <label for="popup_wards" class="form-label">{{ __('digitalboard::digitalboard.select_wards') }}</label>
                <select dusk="digitalboard-selectedWards-field" id="popup_wards" name="selectedWards" class="form-select select2-component" multiple
                    style="width: 100%;" wire:model="selectedWards">

                    @foreach ($wards as $value => $label)
                        <option value="{{ $value }}">{{ replaceNumbersWithLocale($label, true) }}</option>
                    @endforeach

                </select>
            </div>
            @error('wards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class='col-md-6'>
            <div class='form-group'>
                <label for='display_duration'>{{ __('digitalboard::digitalboard.popup_display_duration') }}</label>
                <input dusk="digitalboard-display_duration-field" wire:model='popUp.display_duration' name='display_duration' type='number'
                    class="form-control {{ $errors->has('popUp.display_duration') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('popUp.display_duration') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.popup_display_duration') }}">
                <div>
                    @error('popUp.display_duration')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-6'>
            <div class='form-group'>
                <label for='iteration_duration'>{{ __('digitalboard::digitalboard.popup_iteration_duration') }}</label>
                <input dusk="digitalboard-iteration_duration-field" wire:model='popUp.iteration_duration' name='iteration_duration' type='number'
                    class="form-control {{ $errors->has('popUp.iteration_duration') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('popUp.iteration_duration') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.popup_iteration_duration') }}">
                <div>
                    @error('popUp.iteration_duration')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-12'>
            <div class="form-group">
                <div class="form-check mt-2">
                    <input dusk="digitalboard-isActive-field" class="form-check-input" type="checkbox" id="isActive" wire:model="isActive">
                    <label class="form-check-label" for="isActive" style="font-size: 0.95rem;">
                        {{ __('digitalboard::digitalboard.popup_is_active_') }}
                    </label>
                </div>
            </div>
        </div>

        <div class='col-md-12'>
            <div class="form-group">
                <div class="form-check mt-2">
                    <input dusk="digitalboard-canShowOnAdmin-field" class="form-check-input" type="checkbox" id="can_show_on_admin" wire:model="canShowOnAdmin">
                    <label class="form-check-label" for="can_show_on_admin" style="font-size: 0.95rem;">
                        {{ __('digitalboard::digitalboard.can_show_on_palika') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('digitalboard::digitalboard.save') }}</button>
        <a href="{{ route('admin.digital_board.pop_ups.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('digitalboard::digitalboard.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            const wardsSelect = $('#popup_wards');

            wardsSelect.select2({
                placeholder: "{{ __('digitalboard::digitalboard.select_wards') }}"
            })

            wardsSelect.on('change', function() {
                const $selectedWards = $(this).val();
                @this.set('selectedWards', $selectedWards)
            })
        })
    </script>
@endscript
