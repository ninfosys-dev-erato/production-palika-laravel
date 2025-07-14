<form wire:submit.prevent="save">

    <div class="row">

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='title' class="form-label">{{ __('digitalboard::digitalboard.program_title') }}</label>
                <input dusk="digitalboard-title-field" wire:model='program.title' name='title' type='text'
                    class="form-control {{ $errors->has('program.title') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('program.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.program_title') }}">
                <div>
                    @error('program.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='photo' class="form-label">{{ __('digitalboard::digitalboard.program_image') }}</label>
                <input dusk="digitalboard-uploadedImage-field" wire:model="uploadedImage" name='uploadedImage' type='file' accept=".jpg,.jpeg,.png"
                    class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('uploadedImage') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
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
                @elseif($program->exists)
                    <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $uploadedImage) }}"
                        alt="Current Banner Image" class="img-thumbnail mt-2" style="height: 300px;">
                @endif
            </div>

        </div>

        <div class="col-md-4 mb-3">
            <div class="form-group" wire:ignore>
                <label for="program_wards" class="form-label">{{ __('digitalboard::digitalboard.select_wards') }}</label>
                <select dusk="digitalboard-selectedWards-field" id="program_wards" name="selectedWards" class="form-select select2-component" multiple
                    style="width: 100%;" wire:model="selectedWards">

                    @foreach ($wards as $value => $label)
                        <option value="{{ $value }}">{{ replaceNumbersWithLocale($label,true) }}</option>
                    @endforeach

                </select>
            </div>
            @error('wards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
        <a href="{{ route('admin.digital_board.programs.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('digitalboard::digitalboard.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            const wardsSelect = $('#program_wards');

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
