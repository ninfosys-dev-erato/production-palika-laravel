<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.name') }}" id="name" name="employee.name" />

        </div>
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.address') }}" id="address" name="employee.address" />
        </div>

        <div class="col-md-6">
            <x-form.file-input label="{{ __('employees::employees.photo') }}" id="photo" name="uploadedImage"
                accept=".jpg,.jpeg,.png" />
        </div>
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.phone') }}" id="phone" name="employee.phone" />
        </div>
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.email') }}" id="email" name="employee.email" />
        </div>
        <div class="col-md-6">
            <label for="gender">{{ __('employees::employees.gender') }}</label>
            <select id="gender" name="employee.gender"
                class="form-control {{ $errors->has('employee.gender') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('employee.gender') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                wire:model="employee.gender">
                <option value="">{{ __('employees::employees.choose_gender') }}</option>
                @foreach ($genders as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            @error('employee.gender')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>

        <div class='col-md-6 mb-4'>
            <div class='form-group'>
                <label for='ward_no' class='form-label'>{{ __('employees::employees.ward_no') }}</label>
                <select wire:model='employee.ward_no' name='ward_no' class='form-control'>
                    <option value="">{{ __('employees::employees.select_ward') }}</option>
                    @foreach ($wards as $id => $title)
                        <option value="{{ $title }}">{{ $title }}</option>
                    @endforeach
                </select>
                <div>
                    @error('employee.ward_no')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6" wire:ignore>
            <x-form.select :options="\Src\Employees\Models\Designation::get()->pluck('title', 'id')->toArray()" name="designation_id" wireModel="employee.designation_id"
                placeholder="{{ __('employees::employees.choose_designation') }}" label="{{ __('employees::employees.designation') }}" required />
        </div>


        <div class="col-md-6" wire:ignore>
            <x-form.select :options="\Src\Employees\Models\Branch::get()->pluck('title', 'id')->toArray()" name="branch_id" wireModel="employee.branch_id"
                placeholder="{{ __('employees::employees.choose_department') }}" label="{{ __('employees::employees.choose_department') }}" />
        </div>

        <div class="col-md-6">
            <x-form.checkbox-input label="{{ __('employees::employees.is_department_head') }}" id="is_department_head"
                name="is_department_head" :options="['is_department_head' => __('employees::employees.is_department_head')]" />
        </div>

        <div class='col-md-6'>
            <x-form.text-input label='{{ __('employees::employees.pan_no') }}' id="pan_no" name="employee.pan_no" />
        </div>

        <div class="col-md-6" wire:ignore>
            <x-form.select :options="$types" name="type" wireModel="employee.type"
                placeholder="{{ __('employees::employees.choose_employee_type') }}" label="{{ __('employees::employees.type') }}" />
        </div>

        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.position') }}" id="position" type="number" min="0"
                name="employee.position" />
        </div>

        <div class="col-md-12">
            <x-form.textarea-input label="{{ __('employees::employees.remarks') }}" id="ckeditor" name="employee.remarks" />
        </div>

        @if (!$employee->user_id)
            <div class="col-md-12">
                <div class="form-check form-switch d-flex justify-content-center">
                    <input type="checkbox" wire:model.live="isUser" id="isUser" class="form-check-input">
                    <label class="form-check-label">{{ __('employees::employees.do_you_want_to_create_user_account_as_well_') }}</label>
                </div>
            </div>
        @endif

        @if ($isUser)
            <div class="col-md-6" wire:ignore>
                <div class="form-group mb-4">
                    <label for="selectedRoles">{{ __('employees::employees.roles') }}</label>
                    <select id="selectedRoles" name="selectedRoles"
                        class="form-select select2-component @error('selectedRoles') is-invalid @enderror"
                        style="width: 100%;" multiple>

                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}">{{ ucwords(str_replace('_', ' ', $label)) }}</option>
                        @endforeach
                    </select>

                    @error('selectedRoles')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='password'>{{ __('employees::employees.password') }}</label>
                    <input wire:model='user_password' name='password' type='password' class='form-control'
                        placeholder="{{ __('employees::employees.password') }}">
                    @error('user_password')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endif
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('employees::employees.save') }}</button>
        <a href="{{ url()->previous() }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('employees::employees.back') }}</a>
    </div>
</form>

@script
    <script>
        $wire.on('create-user', () => {
            $(document).ready(function() {
                const selectElement = $('#selectedRoles');

                const initializeSelect2 = () => {
                    selectElement.select2();
                    selectElement.on('change', function(e) {
                        @this.set('selectedRoles', $(this).val());
                    });
                };

                initializeSelect2();
            })
        })
    </script>
@endscript
