<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='installment' class='form-label'>{{ __('yojana::yojana.installment') }}</label>
                    {{--        <input wire:model='advancePayment.installment' name='installment' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_installment')}}"> --}}
                    <select wire:model='advancePayment.installment' name='installment' class="form-select">
                        <option value="" hidden>{{ __('yojana::yojana.select_an_option') }}</option>
                        @foreach ($installments as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('advancePayment.installment')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='date' class='form-label'>{{ __('yojana::yojana.date') }}</label>
                    <input wire:model='advancePayment.date' name='date' type='text' id="payment_date"
                        class='form-control nepali-date' placeholder="{{ __('yojana::yojana.enter_date') }}">
                    <div>
                        @error('advancePayment.date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='clearance_date' class='form-label'>{{ __('yojana::yojana.clearance_date') }}</label>
                    <input wire:model='advancePayment.clearance_date' name='clearance_date' type='text'
                        id="clearance_date" class='form-control nepali-date'
                        placeholder="{{ __('yojana::yojana.enter_clearance_date') }}">
                    <div>
                        @error('advancePayment.clearance_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='advance_deposit_number'
                        class='form-label'>{{ __('yojana::yojana.advance_deposit_number') }}</label>
                    <input wire:model='advancePayment.advance_deposit_number' name='advance_deposit_number'
                        type='number' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_advance_deposit_number') }}">
                    <div>
                        @error('advancePayment.advance_deposit_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='paid_amount' class='form-label'>{{ __('yojana::yojana.paid_amount') }}</label>
                    <input wire:model='advancePayment.paid_amount' name='paid_amount' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_paid_amount') }}">
                    <div>
                        @error('advancePayment.paid_amount')
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
        <a href="{{ route('admin.advance_payments.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
