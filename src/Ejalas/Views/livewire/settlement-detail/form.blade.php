<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='party_id' class="form-label">{{ __('ejalas::ejalas.party') }}</label>
                    <input wire:model='settlementDetail.party_id' name='party_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_party_id') }}">
                    <div>
                        @error('settlementDetail.party_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deadline_set_date' class="form-label">{{ __('ejalas::ejalas.deadline_date') }}</label>
                    <input wire:model='settlementDetail.deadline_set_date' name='deadline_set_date' type='date'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.select_deadline_date') }}">
                    <div>
                        @error('settlementDetail.deadline_set_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-10 mb-3'>
                <div class='form-group'>
                    <label for='detail' class="form-label">{{ __('ejalas::ejalas.detail') }}</label>
                    <textarea wire:model='settlementDetail.detail' name='detail' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_detail') }}" rows="5"></textarea>
                    <div>
                        @error('settlementDetail.detail')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.settlement_details.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>