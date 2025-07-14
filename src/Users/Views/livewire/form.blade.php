<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='name' class="mb-2 mt-4">{{ __('users::users.name') }}</label>
                    <input wire:model='user.name' name='name' type='text'
                        class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('user.name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('users::users.enter_name') }}">
                    @error('user.name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='email' class="mb-2 mt-4">{{ __('users::users.email') }}</label>
                    <input wire:model='user.email' name='email' type='text'
                        class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('user.email') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('users::users.enter_email') }}">
                    @error('user.email')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='mobile_no' class="mb-2 mt-4">{{ __('users::users.phone_number') }}</label>
                    <input wire:model='user.mobile_no' name='mobile_no' type='text'
                        class="form-control {{ $errors->has('user.mobile_no') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('customer.gender') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('users::users.enter_phone_number') }}">
                    @error('user.mobile_no')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='password' class="mb-2 mt-4">{{ __('users::users.password') }}</label>
                    <input wire:model='user_password' name='password' type='password'
                        class="form-control {{ $errors->has('user_password') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('user_password') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('users::users.enter_password') }}">
                    @error('user_password')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div wire:ignore>
                <x-form.select :options="array_combine($wards, $wards)" multiple name="selected_wards" wireModel="selected_wards"
                    placeholder="{{ __('users::users.select_wards') }}" label="{{ __('users::users.select_assigned_wards') }}" />
            </div>

            <div wire:ignore>
                <x-form.select :options="$roles" multiple name="selectedRoles" wireModel="selectedRoles"
                    placeholder="{{ __('users::users.select_roles') }}" label="{{ __('users::users.select_assigned_roles') }}" />
            </div>

        </div>



        <label class="mb-2 mt-4">{{ __('users::users.select_assigned_departments') }}</label>
        <div class="table-responsive card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('users::users.assign_department') }}</th>
                        <th>{{ __('users::users.is_hod') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $index => $department)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0">{{ $department['title'] }}</p>
                                    <input type="checkbox" wire:model.live="selectedDepartments"
                                        value="{{ $department['id'] }}" class="form-check-input ms-2">
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input type="checkbox" wire:model="departmentHeads.{{ $department['id'] }}"
                                        class="form-check-input"
                                        {{ in_array($department['id'], $selectedDepartments) ? '' : 'disabled' }}>
                                    <label class="form-check-label"></label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($errors->has('department_head'))
                <div class="alert alert-danger">
                    {{ $errors->first('department_head') }}
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('users::users.save') }}</button>
        <a href="javascript:void(0);" class="btn btn-danger" wire:loading.attr="disabled"
            onclick="window.history.back();">{{ __('users::users.back') }} </a>

    </div>
</form>

<script>
    Livewire.on('goBack', () => {
        window.history.back();
    });
</script>
