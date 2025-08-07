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
                <label for='file' class="form-label">{{ __('digitalboard::digitalboard.select_notice_photo') }}</label>
                <input dusk="digitalboard-uploadedFiles-field" wire:model="uploadedFiles" name='uploadedFiles'
                    type='file' class="form-control {{ $errors->has('uploadedFiles') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('uploadedFiles') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.select_notice_file') }}">
                <div>
                    @error('uploadedFiles')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
                @if ($uploadedFiles)
                    <div class="row mt-3">
                        @foreach ($uploadedFiles as $file)
                            @php
                                $mime = $file->getMimeType();
                                $isImage = str_starts_with($mime, 'image/');
                                $isPDF = $mime === 'application/pdf';
                            @endphp

                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                @if ($isImage)
                                    <img src="{{ $file->temporaryUrl() }}" alt="Image Preview"
                                        class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" />
                                @elseif ($isPDF)
                                    <div class="border rounded p-3 d-flex align-items-center"
                                        style="height: 60px;">
                                        <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                        <a href="{{ $file->temporaryUrl() }}" target="_blank"
                                            class="text-primary fw-bold text-decoration-none">
                                            {{ __('अपलोड गरिएको फाइल हेर्नुहोस्') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="border p-2 text-center" style="height: 150px;">
                                        <p class="mb-1">Unsupported File</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @elseif($action === App\Enums\Action::UPDATE && !empty($existingImage))
                    @php
                        $fileUrl = customFileAsset(
                            config('src.DigitalBoard.notice.notice_path'),
                            $existingImage,
                            'local',
                            'tempUrl',
                        );
                    @endphp
                    <div class="mt-3">
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bx bx-file"></i>
                            {{ __('yojana::yojana.view_uploaded_file') }}
                        </a>
                    </div>
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
