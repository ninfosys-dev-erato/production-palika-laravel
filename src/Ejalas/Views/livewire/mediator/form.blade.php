<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='fiscal_year_id'>{{ __('ejalas::ejalas.fiscal_year_id') }}</label>
                    <select wire:model='mediator.fiscal_year_id' name='fiscal_year_id' class='form-control'>
                        <option value="">{{ __('ejalas::ejalas.select_fiscal_year') }}</option>
                        @foreach ($fiscalYears as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mediator.fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='listed_no'>{{ __('ejalas::ejalas.listed_no') }}</label>
                    <input wire:model='mediator.listed_no' name='listed_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_listed_no') }}">
                    <div>
                        @error('mediator.listed_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='mediator_name'>{{ __('ejalas::ejalas.mediator_name') }}</label>
                    <input wire:model='mediator.mediator_name' name='mediator_name' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_mediator_name') }}">
                    <div>
                        @error('mediator.mediator_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='mediator_address'>{{ __('ejalas::ejalas.mediator_address') }}</label>
                    <input wire:model='mediator.mediator_address' name='mediator_address' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_mediator_address') }}">
                    <div>
                        @error('mediator.mediator_address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='ward_id'>{{ __('ejalas::ejalas.ward_no') }}</label>
                    <select wire:model='mediator.ward_id' name='ward_id' type='text' class='form-control'>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_ward') }}</option>
                        @foreach ($wards as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='mediator.ward_id' name='ward_id' type='text' class='form-control'
                        placeholder="{{__('ejalas::ejalas.enter_ward_no')}}"> --}}
                    <div>
                        @error('mediator.ward_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='training_detail'>{{ __('ejalas::ejalas.training_detail') }}</label>
                    <input wire:model='mediator.training_detail' name='training_detail' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_training_detail') }}">
                    <div>
                        @error('mediator.training_detail')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='mediator_phone_no'>{{ __('ejalas::ejalas.mediator_phone_no') }}</label>
                    <input wire:model='mediator.mediator_phone_no' name='mediator_phone_no' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_mediator_phone_no') }}">
                    <div>
                        @error('mediator.mediator_phone_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='mediator_email'>{{ __('ejalas::ejalas.mediator_email') }}</label>
                    <input wire:model='mediator.mediator_email' name='mediator_email' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_mediator_email') }}">
                    <div>
                        @error('mediator.mediator_email')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='municipal_approval_date'>{{ __('ejalas::ejalas.municipal_approval_date') }}</label>
                    <input id="municipal_approval_date" wire:model='mediator.municipal_approval_date'
                        name='municipal_approval_date' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_municipal_approval_date') }}">
                    <div>
                        @error('mediator.municipal_approval_date')
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
        <a href="{{ route('admin.ejalas.mediators.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

@script
    <script>
        const nepaliDob = $('#municipal_approval_date');

        nepaliDob.nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        });



        nepaliDob.on('dateSelect', function(e) {
            let selectedDob = $(this).val();
            @this.set('mediator.municipal_approval_date', selectedDob);
        })

        // $wire.on('customer-created', () => {
        //     window.location.reload();
        // });
    </script>
@endscript
