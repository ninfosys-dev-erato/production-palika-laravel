<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='dispute_title'>{{ __('ejalas::ejalas.dispute_matter') }}</label>
                    <input wire:model='registrationIndicator.dispute_title' name='dispute_title' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_dispute_title') }}">
                    <div>
                        @error('registrationIndicator.dispute_title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='indicator_type'>{{ __('ejalas::ejalas.indicator_type') }}</label>

                    <select wire:model='registrationIndicator.indicator_type' name='indicator_type' class="form-select">
                        <option value=""hidden>{{ __('ejalas::ejalas.select_an_option') }}</option>
                        @foreach ($partyTypes as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('registrationIndicator.indicator_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.registration_indicators.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
