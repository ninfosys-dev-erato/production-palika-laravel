<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='applicant_name' class='form-label'>{{ __('yojana::yojana.applicant_name') }}</label>
                    <input wire:model='application.applicant_name' name='applicant_name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_applicant_name') }}">
                    <div>
                        @error('application.applicant_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='address' class='form-label'>{{ __('yojana::yojana.address') }}</label>
                    <input wire:model='application.address' name='address' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_address') }}">
                    <div>
                        @error('application.address')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='mobile_number' class='form-label'>{{ __('yojana::yojana.mobile_number') }}</label>
                    <input wire:model='application.mobile_number' name='mobile_number' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_mobile_number') }}">
                    <div>
                        @error('application.mobile_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='bank_id' class='form-label'>{{ __('yojana::yojana.bank') }}</label>
                    {{-- <input wire:model='application.bank_id' name='bank_id' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_bank_id') }}"> --}}
                    <select name="" id="" class="form-select" wire:model='application.bank_id'>
                        <option value=""hidden>{{ __('yojana::yojana.select_an_option') }}
                        </option>
                        @foreach ($banks as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('application.bank_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='account_number' class='form-label'>{{ __('yojana::yojana.account_number') }}</label>
                    <input wire:model='application.account_number' name='account_number' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_account_number') }}">
                    <div>
                        @error('application.account_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mt-4'>
                <div class='form-group'>
                    <label for='is_employee' class='form-label'>{{ __('yojana::yojana.is_employee') }}</label>
                    <input wire:model='application.is_employee' name='is_employee' type='checkbox'
                        class='form-check-input ms-3 mt-1 p-2'
                        placeholder="{{ __('yojana::yojana.enter_is_employee') }}">
                    <div>
                        @error('application.is_employee')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.applications.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
