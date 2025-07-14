<div class="form">
    <form wire:submit.prevent="save">
        {{ csrf_field() }}
        <div class="row mb-3">
            <div class="col-12">
                <x-form.text-input label="{{ __('Subject') }}" id="subject" name="subject" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.textarea-input label="{{ __('Description') }}" id="description" name="description" />
            </div>
        </div>
        <div class="row mb-3" wire:ignore>
            <label class="form-label" type="departments">{{ __('Select a Department') }}</label>
            <x-form.select :options="$branches" multiple name="selectedDepartments" wireModel="selectedDepartments"
                placeholder="Select Department" />
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-group mb-4" wire:ignore>
                    <label for="grievance_type_id">{{ __('Grievance Type') }}</label>
                    <select id="grievance_type_id" name="grievance_type_id"
                        class="form-select select2-component @error('grievance_type_id') is-invalid @enderror"
                        style="width: 100%;" required>

                        <option value="">{{ __('Choose Grievance Type') }}</option>

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
                <label fclass="form-label" for='image'>{{ __('Image') }}</label>
                <input wire:model="uploadedImage" name='uploadedImage' type='file' class='form-control' multiple
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <div>
                    @error('uploadedImage')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
                @if ($uploadedImage)
                    <div class="row">
                        @foreach ($uploadedImage as $image)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image Preview"
                                    class="img-thumbnail w-100 " style="height: 150px; object-fit: cover;" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-12 text-start">
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled">{{ __('Save') }}</button>
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
