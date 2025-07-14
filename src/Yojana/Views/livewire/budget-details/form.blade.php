<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='ward_id'>{{__('yojana::yojana.ward')}}</label>
                    <select wire:model='budgetDetail.ward_id' name='ward_id' type='text'
                            class='form-control {{ $errors->has('budgetDetail.ward_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden >{{__('yojana::yojana.select_ward')}}</option>
                        @foreach($wards as $ward)
                            <option value="{{$ward}}">{{replaceNumbersWithLocale($ward, true)}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('budgetDetail.ward_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='program'>{{__('yojana::yojana.program')}}</label>
                    <input wire:model='budgetDetail.program' name='program' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_program')}}">
                    <div>
                        @error('budgetDetail.program')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='amount'>{{__('yojana::yojana.amount')}}</label>
                    <input wire:model='budgetDetail.amount' name='amount' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_amount')}}">
                    <div>
                        @error('budgetDetail.amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
</form>
