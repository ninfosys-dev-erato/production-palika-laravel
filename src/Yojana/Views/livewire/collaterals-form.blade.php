<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
                       <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='party_type' class='form-label'>{{ __('yojana::yojana.party_type') }}</label>
                    <input wire:model='collateral.party_type' name='party_type' type='text' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.party_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='party_id' class='form-label'>{{ __('yojana::yojana.party') }}</label>
                    <input wire:model='collateral.party_id' name='party_id' type='text' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.party_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deposit_type' class='form-label'>{{ __('yojana::yojana.deposit_type') }}</label>
                    <input wire:model='collateral.deposit_type' name='deposit_type' type='text' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.deposit_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deposit_number' class='form-label'>{{ __('yojana::yojana.deposit_number') }}</label>
                    <input wire:model='collateral.deposit_number' name='deposit_number' type='number' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.deposit_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='contract_number' class='form-label'>{{ __('yojana::yojana.contract_number') }}</label>
                    <input wire:model='collateral.contract_number' name='contract_number' type='number' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.contract_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='bank' class='form-label'>{{ __('yojana::yojana.bank') }}</label>
                    <input wire:model='collateral.bank' name='bank' type='text' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.bank')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='issue_date' class='form-label'>{{ __('yojana::yojana.issue_date') }}</label>
                    <input wire:model='collateral.issue_date' name='issue_date' type='date' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.issue_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='validity_period' class='form-label'>{{ __('yojana::yojana.validity_period') }}</label>
                    <input wire:model='collateral.validity_period' name='validity_period' type='text' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.validity_period')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='amount' class='form-label'>{{ __('yojana::yojana.amount') }}</label>
                    <input wire:model='collateral.amount' name='amount' type='number' class='form-control' placeholder="{{ __('') }}">
                    <div>
                        @error('collateral.amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('Save')}}</button>
    </div>
</form>
