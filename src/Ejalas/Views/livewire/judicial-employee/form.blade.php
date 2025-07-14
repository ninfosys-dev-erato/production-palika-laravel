<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='name'>{{ __('ejalas::ejalas.ejalashemployeename') }}</label>
                    <input wire:model='judicialEmployee.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_name') }}">
                    <div>
                        @error('judicialEmployee.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='local_level_id'>{{ __('ejalas::ejalas.local_level') }}</label>
                    <select wire:model='judicialEmployee.local_level_id' name='local_level_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_local_level') }}</option>
                        @foreach ($localLevels as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='judicialEmployee.local_level_id' name='local_level_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_local_level_id') }}"> --}}
                    <div>
                        @error('judicialEmployee.local_level_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='ward_id'>{{ __('ejalas::ejalas.ward') }}</label>
                    <select wire:model='judicialEmployee.ward_id' name='ward_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_ward') }}</option>
                        @foreach ($wards as $ward)
                            <option value="{{ $ward }}">{{ $ward }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='judicialEmployee.ward_id' name='ward_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_ward_no') }}"> --}}
                    <div>
                        @error('judicialEmployee.ward_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='level_id'>{{ __('ejalas::ejalas.level_id') }}</label>
                    <select wire:model='judicialEmployee.level_id' name='level_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_level') }}</option>
                        @foreach ($levels as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='judicialEmployee.level_id' name='level_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_level_id') }}"> --}}
                    <div>
                        @error('judicialEmployee.level_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='designation_id'>{{ __('ejalas::ejalas.designation') }}</label>
                    <select wire:model='judicialEmployee.designation_id' name='designation_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_designation') }}</option>
                        @foreach ($designations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='judicialEmployee.designation_id' name='designation_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_designation_id') }}"> --}}
                    <div>
                        @error('judicialEmployee.designation_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='join_date'>{{ __('ejalas::ejalas.ejalashemployeerestorationdate') }}</label>
                    <input wire:model='judicialEmployee.join_date' name='join_date' type='date' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_join_date') }}">
                    <div>
                        @error('judicialEmployee.join_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='phone_no'>{{ __('ejalas::ejalas.phone_no') }}</label>
                    <input wire:model='judicialEmployee.phone_no' name='phone_no' type='number' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_phone_no') }}">
                    <div>
                        @error('judicialEmployee.phone_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='email'>{{ __('ejalas::ejalas.email') }}</label>
                    <input wire:model='judicialEmployee.email' name='email' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_email') }}">
                    <div>
                        @error('judicialEmployee.email')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.judicial_employees.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>