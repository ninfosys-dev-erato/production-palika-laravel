<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='configuration.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('configuration.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='amount'>{{ __('yojana::yojana.amount') }}</label>
                    <input wire:model='configuration.amount' name='amount' type='number' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_amount') }}" min="0">
                    <div>
                        @error('configuration.amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='rate'>{{ __('yojana::yojana.rate') }}</label>
                    <input wire:model='configuration.rate' name='rate' type='number' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_rate') }}" min="0">
                    <div>
                        @error('configuration.rate')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='type'>{{ __('yojana::yojana.type') }}</label>
                    <select wire:model='configuration.type_id' name="type" class="form-control">
                        <option value="" hidden>{{ __('yojana::yojana.select_type') }}</option>
                        @foreach ($types as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('configuration.type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-space-around mt-4">
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <input wire:model='configuration.use_in_cost_estimation' name='use_in_cost_estimation'
                            type='checkbox'>
                        <label class="form-label" for='use_in_cost_estimation'>{{ __('yojana::yojana.use_in_cost_estimation') }}</label>
                        <div>
                            @error('configuration.use_in_cost_estimation')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <input wire:model='configuration.use_in_payment' name='use_in_payment' type='checkbox'>
                        <label class="form-label" for='use_in_payment'>{{ __('yojana::yojana.use_in_payment') }}</label>
                        <div>
                            @error('configuration.use_in_payment')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
    </div>
</form>
