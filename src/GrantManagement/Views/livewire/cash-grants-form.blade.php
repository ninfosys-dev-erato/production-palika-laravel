<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-4'>
                <div class='form-group' wire:ignore>
                    <label for='cashGrant.name'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.name') }}</label>
                    <select name="selectUser" id="selectUser" class="form-select form-control select2-component"
                        wire:ignore>
                        <option value="" hidden>{{ __('Select an option') }}</option>
                        @foreach ($customer as $id => $name)
                            <option value="{{ $id }}" {{ $id == $this->name ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>


                    <!-- <input wire:model='cashGrant.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_name') }}"> -->
                    <div>
                        @error('cashGrant.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='address' class='form-label'>{{ __('grantmanagement::grantmanagement.ward') }}</label>
                    <select wire:model='cashGrant.address' name='address' class='form-control'>
                        <option value="">{{ __('grantmanagement::grantmanagement.select_ward') }}</option>
                        @foreach ($wards as $id => $ward_name_ne)
                            <option value="{{ $id }}">{{ $ward_name_ne }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('cashGrant.address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='age' class='form-label'>{{ __('grantmanagement::grantmanagement.age') }}</label>
                    <input wire:model='cashGrant.age' name='age' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_age') }}">
                    <div>
                        @error('cashGrant.age')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='contact'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.contact') }}</label>
                    <input wire:model='cashGrant.contact' name='contact' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_contact') }}">
                    <div>
                        @error('cashGrant.contact')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='citizenship_no'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.citizenship_no') }}</label>
                    <input wire:model='cashGrant.citizenship_no' name='citizenship_no' type='text'
                        class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_citizenship_no') }}">
                    <div>
                        @error('cashGrant.citizenship_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='father_name'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.father_name') }}</label>
                    <input wire:model='cashGrant.father_name' name='father_name' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_father_name') }}">
                    <div>
                        @error('cashGrant.father_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='grandfather_name'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.grandfather_name') }}</label>
                    <input wire:model='cashGrant.grandfather_name' name='grandfather_name' type='text'
                        class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_grandfather_name') }}">
                    <div>
                        @error('cashGrant.grandfather_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='helplessness_type_id'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.helplessness_type') }}</label>
                    <select wire:model='cashGrant.helplessness_type_id' name='cashGrant.helplessness_type_id'
                        class='form-control'>
                        <option value="">{{ __('grantmanagement::grantmanagement.select_helplessness_type') }}
                        </option>
                        @foreach ($helplessnessTypes as $id => $helplessness_type)
                            <option value="{{ $id }}">{{ $helplessness_type }}</option>
                        @endforeach
                    </select>
                    @error('cashGrant.helplessness_type_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='cash' class='form-label'>{{ __('grantmanagement::grantmanagement.cash') }}</label>
                    <input wire:model='cashGrant.cash' name='cash' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_cash') }}">
                    <div>
                        @error('cashGrant.cash')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='file'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.file') }}</label>
                    <input wire:model='uploadedFile' name='uploadedFile' type='file'
                        class="form-control {{ $errors->has('uploadedFile') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('uploadedFile') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_file') }}" accept="image/*">
                    <div>
                        @error('uploadedFile')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                        @if ($uploadedFileUrl)
                            {{-- <img src="{{ $uploadedFile->temporaryUrl() }}" alt="Uploaded File Preview"
                                class="img-thumbnail mt-2" style="height: 300px;"> --}}
                            <div class="mt-1">
                                <strong>{{ __('File Preview') }}:</strong>
                                <a href="{{ $uploadedFileUrl }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm ms-2">
                                    <i class="bx bx-file"></i> {{ __('View Uploaded File') }}
                                </a>
                            </div>
                        @endif
                        <div wire:loading wire:target="{{ $uploadedFile }}">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Uploading...
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='remark'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.remark') }}</label>
                    <input wire:model='cashGrant.remark' name='remark' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_remark') }}">
                    <div>
                        @error('cashGrant.remark')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
        <a href="{{ route('admin.cash_grants.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
    </div>
</form>


@push('scripts')
    <script>
        const selectElement = $('#selectUser');

        selectElement.select2({
            placeholder: "{{ __('grantmanagement::grantmanagement.select_user') }}",
            allowClear: true,
            width: '100%'
        });

        // Handle change event
        selectElement.on('change', function() {
            @this.set('cashGrant.name', $(this).val());
            @this.call('showUserData', $(this).val());
        });
    </script>
@endpush
