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
                        <div class="row">
                            @foreach ($files as $file)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    @if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ $file->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail w-100"
                                            style="height: 150px; object-fit: cover;">
                                    @endif

                                    @if (in_array($file->getClientOriginalExtension(), ['pdf']))
                                        <div class="card" style="max-width: 200px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ __('downloads::downloads.pdf_file') }}</h5>
                                                <p class="card-text">{{ $file->getClientOriginalName() }}</p>
                                                <a href="{{ $file->temporaryUrl() }}" target="_blank"
                                                    class="btn btn-primary btn-sm">
                                                    {{ __('downloads::downloads.open_pdf') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($existingImages)
                        <div class="row mt-3">
                            @foreach ($existingImages as $existingFile)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    @if (in_array(pathinfo($existingFile, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ customAsset(config('src.Downloads.download.file_path'), $existingFile) }}"
                                            alt="Existing Image" class="img-thumbnail w-100"
                                            style="height: 150px; object-fit: cover;">
                                    @endif

                                    @if (in_array(pathinfo($existingFile, PATHINFO_EXTENSION), ['pdf']))
                                        <div class="card" style="max-width: 200px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ __('downloads::downloads.pdf_file') }}</h5>
                                                <p class="card-text">{{ $existingFile }}</p>
                                                <a href="{{ customAsset(config('src.Downloads.download.file_path'), $existingFile) }}"
                                                    target="_blank" class="btn btn-primary btn-sm">
                                                    {{ __('downloads::downloads.open_pdf') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
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