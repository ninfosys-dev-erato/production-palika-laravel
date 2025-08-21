<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='reconciliation_center_title'>{{ __('ejalas::ejalas.ejalasheconciliationcentername') }}</label>
                    <input wire:model='reconciliationCenter.reconciliation_center_title'
                        name='reconciliation_center_title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_reconciliation_center_title') }}">
                    <div>
                        @error('reconciliationCenter.reconciliation_center_title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='surname'>{{ __('ejalas::ejalas.sub_name') }}</label>
                    <input wire:model='reconciliationCenter.surname' name='surname' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_surname') }}">
                    <div>
                        @error('reconciliationCenter.surname')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='ward_id'>{{ __('ejalas::ejalas.ward_no') }}</label>
                    <input wire:model='reconciliationCenter.ward_id' name='ward_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_ward_no') }}">
                    <div>
                        @error('reconciliationCenter.ward_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='established_date'>{{ __('ejalas::ejalas.established_date') }}</label>
                    <input wire:model='reconciliationCenter.established_date' name='established_date' type='text'
                        class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_established_date') }}">
                    <div>
                        @error('reconciliationCenter.established_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.reconciliation_centers.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
