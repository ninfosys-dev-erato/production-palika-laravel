<div class="form">
    <form wire:submit.prevent="save">
        <div class="row mb-3">
            <div class="col-12" wire:ignore>
                <x-form.checkbox-input label="{{ __('grievance::grievance.is_anonymous') }}" id="is_anonymous"
                    name="is_anonymous" :options="['is_anonymous' => __('grievance::grievance.is_anonymous')]" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.text-input label="{{ __('grievance::grievance.subject') }}" id="subject" name="subject" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.textarea-input label="{{ __('grievance::grievance.description') }}" id="description"
                    name="description" />
            </div>
        </div>
        <div class="row mb-3" wire:ignore>
            <label class="form-label" type="departments">{{ __('grievance::grievance.select_a_department') }}</label>
            <x-form.select :options="$branches" multiple name="selectedDepartments" wireModel="selectedDepartments"
                placeholder="Select Department" />
        </div>

        <div class="row mb-3">

            <div class="col-12">
                <div class="form-group mb-4" wire:ignore>
                    <label for="grievance_type_id">{{ __('grievance::grievance.grievance_type') }}</label>
                    <select id="grievance_type_id" name="grievance_type_id"
                        class="form-select select2-component @error('grievance_type_id') is-invalid @enderror"
                        style="width: 100%;" required>

                        <option value="">{{ __('grievance::grievance.choose_grievance_type') }}</option>

                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}">{{ ucwords(str_replace('_', ' ', $label)) }}</option>
                        @endforeach
                    </select>
                </div>
                @error('grievance_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class='form-group'>
                <label for="file">{{ __('grievance::grievance.file') }}</label>
                <input wire:model="uploadedFiles" name="file" type="file" class="form-control"
                    multiple>
                @error('uploadedFiles')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror
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
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled">{{ __('grievance::grievance.save') }}</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const selectElement = $('#grievance_type_id');

            const initializeSelect2 = () => {
                selectElement.select2();
                selectElement.on('change', function(e) {
                    @this.set('grievance_type_id', $(this).val());
                });
            };

            initializeSelect2();
        })
    </script>
@endpush

@script
    <script>
        $(document).ready(function() {

            const grievanceSelect = $('#grievance_type_id');
            grievanceSelect.select2();
            grievanceSelect.on('change', function() {
                @this.set('grievance_type_id', $(this).val());
            })
        })
    </script>
@endscript
