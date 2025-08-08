<form wire:submit.prevent="save">
    <div class="row">
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='title' class="form-label">{{ __('digitalboard::digitalboard.notice_title') }}</label>
                <input dusk="digitalboard-title-field" wire:model='notice.title' name='title' type='text'
                    class="form-control {{ $errors->has('notice.title') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('notice.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.notice_title') }}">
                <div>
                    @error('notice.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label for='date' class="form-label">{{ __('digitalboard::digitalboard.notice_date') }}</label>
                <input dusk="digitalboard-date-field" wire:model='notice.date' name='date' type='text'
                    class="form-control {{ $errors->has('notice.date') ? 'is-invalid' : '' }} nepali-date"
                    style="{{ $errors->has('notice.date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.notice_date') }}" id="notice_date">
            </div>
            <div>
                @error('notice.date')
                    <small class='text-danger'>{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class='col-md-12 mb-3'>
            <div class='form-group'>
                <label for='description'
                    class="form-label">{{ __('digitalboard::digitalboard.notice_description') }}</label>
                <textarea dusk="digitalboard-description-field" wire:model='notice.description' name='description' type='text'
                    class="form-control {{ $errors->has('notice.description') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('notice.description') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.notice_description') }}">

                </textarea>
                <div>
                    @error('notice.description')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-12 mb-3'>
            <div class='form-group'>
                <label for='photo'
                    class="form-label">{{ __('digitalboard::digitalboard.select_notice_photo') }}</label>
                <input dusk="digitalboard-uploadedImage-field" wire:model="uploadedImage" name='uploadedImage'
                    type='file' class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('uploadedImage') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    accept=".jpg,.jpeg,.png,.pdf"
                    placeholder="{{ __('digitalboard::digitalboard.select_notice_file') }}">
                <div>
                    @error('uploadedImage')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
                @if (
                    ($uploadedImage && $uploadedImage instanceof \Illuminate\Http\File) ||
                        $uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
                        $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                    @php
                        $extension = strtolower($uploadedImage->getClientOriginalExtension());
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ $uploadedImage->temporaryUrl() }}" alt="Uploaded Image Preview"
                            class="img-thumbnail mt-2" style="height: 300px;">
                    @elseif ($extension === 'pdf')
                        <div class="card mt-2" style="max-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('digitalboard::digitalboard.pdf_file') }}</h5>
                                <p class="card-text">{{ $uploadedImage->getClientOriginalName() }}</p>
                                <a href="{{ $uploadedImage->temporaryUrl() }}" target="_blank"
                                    class="btn btn-primary btn-sm">
                                    {{ __('digitalboard::digitalboard.open_pdf') }}
                                </a>
                            </div>
                        </div>
                    @endif
                @elseif($action === App\Enums\Action::UPDATE)
                    @php
                        $extension = strtolower(pathinfo($uploadedImage, PATHINFO_EXTENSION));
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ customAsset(config('src.DigitalBoard.notice.notice_path'), $uploadedImage) }}"
                            alt="Current Banner Image" class="img-thumbnail mt-2" style="height: 300px;">
                    @elseif ($extension === 'pdf')
                        <div class="card mt-2" style="max-width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('digitalboard::digitalboard.pdf_file') }}</h5>
                                <p class="card-text">{{ $uploadedImage }}</p>
                                <a href="{{ customFileAsset(config('src.DigitalBoard.notice.notice_path'), $uploadedImage) }}"
                                    target="_blank" class="btn btn-primary btn-sm">
                                    {{ __('digitalboard::digitalboard.open_pdf') }}
                                </a>
                            </div>
                        </div>
                    @endif
                @endif

            </div>

        </div>

        <div class="col-md-4 mb-3">
            <div class="form-group" wire:ignore>
                <label for="notice_wards"
                    class="form-label">{{ __('digitalboard::digitalboard.select_wards') }}</label>
                <select dusk="digitalboard-selectedWards-field" id="notice_wards" name="selectedWards"
                    class="form-select select2-component" multiple style="width: 100%;" wire:model="selectedWards">

                    @foreach ($wards as $value => $label)
                        <option value="{{ $value }}">{{ replaceNumbersWithLocale($label, true) }}</option>
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
                    <input dusk="digitalboard-canShowOnAdmin-field" class="form-check-input" type="checkbox"
                        id="can_show_on_admin" wire:model="canShowOnAdmin">
                    <label class="form-check-label" for="can_show_on_admin" style="font-size: 0.95rem;">
                        {{ __('digitalboard::digitalboard.can_show_on_palika') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('digitalboard::digitalboard.save') }}</button>
        <a href="{{ route('admin.digital_board.notices.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('digitalboard::digitalboard.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            const wardsSelect = $('#notice_wards');

            wardsSelect.select2({
                placeholder: "{{ __('digitalboard::digitalboard.select_wards') }}"
            })

            wardsSelect.on('change', function() {
                const selectedWards = $(this).val();
                @this.set('selectedWards', selectedWards)
            })
        })
    </script>
@endscript
