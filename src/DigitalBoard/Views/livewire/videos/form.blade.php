<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label for='title' class="form-label">{{ __('digitalboard::digitalboard.enter_video_title') }}</label>
                    <input dusk="digitalboard-title-field" wire:model='video.title' name='title' type='text'
                        class="form-control {{ $errors->has('video.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('video.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('digitalboard::digitalboard.enter_video_title') }}">
                    @error('video.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label for='url' class="form-label">{{ __('digitalboard::digitalboard.video_url') }}</label>
                    <input dusk="digitalboard-url-field" wire:model='video.url' name='url' type='text'
                        class="form-control {{ $errors->has('video.url') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('video.url') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{__('digitalboard::digitalboard.enter_url')}}">
                    @error('video.url')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-group" wire:ignore>
                    <label for="video_wards" class="form-label">{{ __('digitalboard::digitalboard.select_wards') }}</label>
                    <select dusk="digitalboard-selectedWards-field" id="video_wards" name="selectedWards" class="form-select select2-component" multiple
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

{{--            <div class='col-md-12 mb-3'>--}}
{{--                <div class='form-group'>--}}
{{--                    <label for='videoFile' class="form-label">{{ __('digitalboard::digitalboard.upload_video') }}</label>--}}
{{--                    <input dusk="digitalboard-videoFile-field" wire:model='videoFile' type='file' accept="video/mp4"--}}
{{--                        class="form-control {{ $errors->has('videoFile') ? 'is-invalid' : '' }}"--}}
{{--                        style="{{ $errors->has('videoFile') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">--}}
{{--                    @error('videoFile')--}}
{{--                        <small class='text-danger'>{{ $message }}</small>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class='col-md-12 mb-3'>
                <div class='form-group' wire:ignore>
                    <label for='videoFile' class="form-label">{{ __('digitalboard::digitalboard.upload_video') }}</label>
                    <label style="background-color: white; color: #afafaf; padding: 6px 12px; border: 1px solid #dfdfdf; border-radius: 4px; cursor: pointer; display: block;">
                        <span id="file-name">{{__('digitalboard::digitalboard.choose_file')}}</span>
                        <input dusk="digitalboard-videoFile-field" id="fileInput" wire:model="videoFile" type="file" accept="video/mp4"
                               class="{{ $errors->has('videoFile') ? 'is-invalid' : '' }}"
                               style="display: none; {{ $errors->has('videoFile') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                    </label>
                    @error('videoFile')
                    <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>


            <div class='col-md-12 mt-3'>
                @if (
                    $videoFile instanceof \Livewire\TemporaryUploadedFile ||
                        $videoFile instanceof \Illuminate\Http\File ||
                        $videoFile instanceof \Illuminate\Http\UploadedFile)
                    <div class='video-preview'>
                        <video width="320" height="240" controls>
                            <source src="{{ $videoFile->temporaryUrl() }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @elseif($video->exists && $video->file)
                    <div class='video-preview'>
                        <video width="320" height="240" controls>
                            <source
                                src="{{ customFileAsset(config('src.DigitalBoard.video.video_path'), $video->file, $isPrivate ? 'local' : 'public', 'tempUrl') }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif
            </div>


            <div class='col-md-6 mb-3'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input dusk="digitalboard-can_show_on_admin-field" class="form-check-input" type="checkbox" id="can_show_on_admin"
                            wire:model="canShowOnAdmin">
                        <label class="form-check-label" for="can_show_on_admin" style="font-size: 0.95rem;">
                            {{ __('digitalboard::digitalboard.can_show_on_palika') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input dusk="digitalboard-isPrivate-field" class="form-check-input" type="checkbox" id="is_private" wire:model="isPrivate">
                        <label class="form-check-label" for="is_private" style="font-size: 0.95rem;">
                            {{ __('digitalboard::digitalboard.is_private_') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('digitalboard::digitalboard.save') }}</button>
        <a href="{{ route('admin.digital_board.videos.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('digitalboard::digitalboard.back') }}</a>
    </div>
</form>


@script
    <script>
        $(document).ready(function() {
            const wardsSelect = $('#video_wards');

            wardsSelect.select2({
                placeholder: "{{ __('digitalboard::digitalboard.select_wards') }}"
            })

            wardsSelect.on('change', function() {
                const $selectedWards = $(this).val();
                @this.set('selectedWards', $selectedWards)
            })
        })


        // JavaScript to display the file name when a file is chosen
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'फाईल चयन गर्नुहोस्';
            document.getElementById('file-name').textContent = fileName;
        });

    </script>
@endscript
