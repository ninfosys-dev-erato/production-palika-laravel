<div>
<form wire:submit.prevent="saveConfiguration">
    <div class="card-body" >
        <div class="row" >
            </div>
            <div class="row" >
                <div class='col-md-8 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='configuration'>{{__('yojana::yojana.configuration')}}</label>
                        <select wire:model='configuration' name='configuration' type='text' wire:change="updateRate($event.target.value)"
                                class='form-control {{ $errors->has('configuration') ? 'is-invalid' : '' }}'>
                            <option value="" hidden >{{__('yojana::yojana.select_configuration')}}</option>
                            @foreach($configurations as $configuration)
                                <option value="{{$configuration->id}}">{{$configuration->title}}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('configuration')
                            <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='rate'>{{__('yojana::yojana.rate')}}(%)</label>
                        <input wire:model='rate' name='rate' type='number'
                               class='form-control {{ $errors->has('rate') ? 'is-invalid' : '' }}' {{ $customConfiguration ? '' : 'disabled' }}>
                        <div>
                            @error('rate')
                            <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        <div class="row" >

        <div class='col-md-8 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='based_on'>{{__('yojana::yojana.amount_based_on')}}</label>
                    <select wire:model='based_on' name='based_on' type='text' wire:change="updateBaseValue($event.target.value)"
                            class='form-control {{ $errors->has('based_on') ? 'is-invalid' : '' }}' >
                        <option value="" hidden >{{__('yojana::yojana.select_amount_basis')}}</option>
                        @foreach($amountBasis as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('based_on')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='base_value'>{{__('yojana::yojana.base_value')}}</label>
                    <input wire:model='base_value' name='base_value' type='number'
                           class='form-control {{ $errors->has('base_value') ? 'is-invalid' : '' }}' {{ $customConfiguration ? '' : 'disabled' }}>
                    <div>
                        @error('base_value')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class='col-md-8 mb-3'>

                <div class='form-group'>
                    <label class="form-label">{{ __('yojana::yojana.operation_type') }}</label>
                    <div class="d-flex align-items-center">
                        <div class="form-check me-3">
                            <input wire:model="operation_type" type="radio" id="add" value="add" name="operation_type" class="form-check-input">
                            <label class="form-check-label" for="add">(+) {{__('yojana::yojana.add')}}</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="deduct">(-) {{__('yojana::yojana.deduct')}}</label>
                            <input wire:model="operation_type" type="radio" id="deduct" value="deduct" name="operation_type" class="form-check-input">
                        </div>
                    </div>
                    @error('operation_type')
                    <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='amount'>{{__('yojana::yojana.amount')}}</label>
                    <input wire:model='amount' name='amount' type='number'
                           class='form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}' {{ $customConfiguration ? '' : 'disabled' }}>
                    <div>
                        @error('amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" wire:click="addConfigRecords" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
</form>
</div>
