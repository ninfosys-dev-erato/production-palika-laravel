<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text  fw-bold fs-6  mb-3">
                    {{ __('yojana::yojana.basic_details') }}
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='type' class='form-label'>{{ __('yojana::yojana.type') }}</label>
                    {{--                    <input wire:model='organization.type' name='type' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_type')}}"> --}}
                    <select wire:model='organization.type' name='type' type='text' class='form-control'>
                        <option hidden> {{ __('yojana::yojana.select_organization_type') }}</option>

                        @foreach ($organizations as $value => $label)
                            <option value="{{ $value }}"> {{ __($label) }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('organization.type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='name' class='form-label'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='organization.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('organization.name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='address' class='form-label'>{{ __('yojana::yojana.address') }}</label>
                    <input wire:model='organization.address' name='address' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_address') }}">
                    <div>
                        @error('organization.address')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='pan_number' class='form-label'>{{ __('yojana::yojana.pan_number') }}</label>
                    <input wire:model='organization.pan_number' name='pan_number' type='number' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_pan_number') }}">
                    <div>
                        @error('organization.pan_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='phone_number' class='form-label'>{{ __('yojana::yojana.phone_number') }}</label>
                    <input wire:model='organization.phone_number' name='phone_number' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_phone_number') }}">
                    <div>
                        @error('organization.phone_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text  fw-bold fs-6  mb-3">
                    {{ __('yojana::yojana.bank_details') }}
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='bank_name' class='form-label'>{{ __('yojana::yojana.bank_name') }}</label>
                    <input wire:model='organization.bank_name' name='bank_name' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_bank_name') }}">
                    <div>
                        @error('organization.bank_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='branch' class='form-label'>{{ __('yojana::yojana.branch') }}</label>
                    <input wire:model='organization.branch' name='branch' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_branch') }}">
                    <div>
                        @error('organization.branch')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='account_number' class='form-label'>{{ __('yojana::yojana.account_number') }}</label>
                    <input wire:model='organization.account_number' name='account_number' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_account_number') }}">
                    <div>
                        @error('organization.account_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text  fw-bold fs-6  mb-3">
                    {{ __("yojana::yojana.representative_details") }}
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='representative' class='form-label'>{{ __("yojana::yojana.representative_name") }}</label>
                    <input wire:model='organization.representative' name='representative' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_representative') }}">
                    <div>
                        @error('organization.representative')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='post' class='form-label'>{{ __('yojana::yojana.post') }}</label>
                    <input wire:model='organization.post' name='post' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_post') }}">
                    <div>
                        @error('organization.post')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='representative_address'
                        class='form-label'>{{ __("yojana::yojana.representative_address") }}</label>
                    <input wire:model='organization.representative_address' name='representative_address'
                        type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_representative_address') }}">
                    <div>
                        @error('organization.representative_address')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='mobile_number' class='form-label'>{{ __('yojana::yojana.mobile_number') }}</label>
                    <input wire:model='organization.mobile_number' name='mobile_number' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_mobile_number') }}">
                    <div>
                        @error('organization.mobile_number')
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
        <a href="{{ route('admin.organizations.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
