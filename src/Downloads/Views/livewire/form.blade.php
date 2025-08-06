<form wire:submit.prevent="save" enctype="multipart/form-data">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title'>{{ __('downloads::downloads.title') }}</label>
                    <input dusk="downloads-title-field" wire:model='download.title' name='title' type='text'
                        class="form-control {{ $errors->has('download.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('download.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('downloads::downloads.enter_title') }}">
                    <div>
                        @error('download.title')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title_en'>{{ __('downloads::downloads.title_en') }}</label>
                    <input dusk="downloads-title_en-field" wire:model='download.title_en' name='title_en' type='text'
                        class="form-control {{ $errors->has('download.title_en') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('download.title_en') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('downloads::downloads.enter_title_en') }}">
                    <div>
                        @error('download.title_en')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="files">{{ __('downloads::downloads.upload_documents_and_photos') }}</label>
                    <input dusk="downloads-files-field" wire:model="files" name="files" type="file" class="form-control"
                        accept=".pdf,.doc,.docx,image/*" multiple>
                    @error('files.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror


                    @if ($files)
                        <div class="row mt-3">
                            @foreach ($files as $file)
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
                                                {{ __('View Uploaded File') }}
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
                    @elseif (!empty($this->download->files))
                        @php
                            $fileList = is_string($this->download->files)
                                ? json_decode($this->download->files, true)
                                : $this->download->files;
                        @endphp

                        @if (!empty($fileList) && is_array($fileList))
                            <div class="row mt-3">
                                @foreach ($fileList as $existingFile)
                                    @php
                                        $extension = pathinfo($existingFile, PATHINFO_EXTENSION);
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        $isPDF = $extension === 'pdf';
                                        $fileUrl = customFileAsset(
                                            config('src.Downloads.download.file_path'),
                                            $existingFile,
                                            'local',
                                            'tempUrl',
                                        );
                                    @endphp

                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        @if ($isImage)
                                            <img src="{{ $fileUrl }}" alt="Existing Image" 
                                                class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" />
                                        @elseif ($isPDF)
                                            <div class="border rounded p-3 d-flex align-items-center"
                                                style="height: 60px;">
                                                <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="text-primary fw-bold text-decoration-none">
                                                    {{ __('View Uploaded File') }}
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
                        @endif
                    @endif
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='status'>{{ __('downloads::downloads.status') }}</label>
                    <select dusk="downloads-status-field" wire:model='download.status' name='status' class='form-control'>
                        <option value="">{{ __('downloads::downloads.select_status') }}</option>
                        <option value="active">{{ __('downloads::downloads.active') }}</option>
                        <option value="inactive">{{ __('downloads::downloads.inactive') }}</option>
                    </select>
                    <div>
                        @error('download.status')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='order'>{{ __('downloads::downloads.order') }}</label>
                    <input dusk="downloads-order-field" wire:model='download.order' name='order' type='text'
                        class="form-control {{ $errors->has('download.order') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('download.order') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('downloads::downloads.enter_order') }}">
                    <div>
                        @error('download.order')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('downloads::downloads.save') }}</button>
        <a href="{{ route('admin.downloads.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('downloads::downloads.back') }}</a>
    </div>
</form>