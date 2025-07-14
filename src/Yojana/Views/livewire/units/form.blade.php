<form wire:submit.prevent="save">
{{--    <div class="card-body" wire:loading.class="invisible">--}}
    <div class="card-body" >
        <div class="row" >
            <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='type_id'>{{__('yojana::yojana.type')}}</label>
                <select wire:model='unit.type_id' name='type_id' type='text'
                        class='form-control {{ $errors->has('unit.type_id') ? 'is-invalid' : '' }}'
                        placeholder='{{__('yojana::yojana.enter_type_id')}}'>
                    <option value="" hidden >{{__('yojana::yojana.select_measurement_type')}}</option>
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->title}}</option>
                    @endforeach
                </select>
                <div>
                    @error('unit.type_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
                <input wire:model='unit.title' name='title' type='text'
                       class="form-control {{ $errors->has('unit.title') ? 'is-invalid' : '' }}"
                       placeholder='{{__('yojana::yojana.enter_title')}}'>
                <div>
                    @error('unit.title')
                    <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='title_ne'>{{__('yojana::yojana.nepali_title')}}</label>
                <input wire:model='unit.title_ne' name='title_ne' type='text'
                       class="form-control {{ $errors->has('unit.title_ne') ? 'is-invalid' : '' }}"
                       placeholder='{{__('yojana::yojana.enter_nepali_title')}}'>
                <div>
                    @error('unit.title_ne')
                    <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='symbol'>{{__('yojana::yojana.symbol')}}</label>
                <input wire:model='unit.symbol' name='symbol' type='text'
                       class='form-control {{ $errors->has('unit.symbol') ? 'is-invalid' : '' }}'
                       placeholder='{{__('yojana::yojana.enter_symbol')}}'>
                <div>
                    @error('unit.symbol')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 m-2'>
            <div class='form-group'>
                <label class="form-label" for='will_be_in_use'>{{__('yojana::yojana.will_be_in_use')}}</label>
                <input wire:model="willBeInUse" name="will_be_in_use" type="checkbox"
                       class="form-check-input m-1"
                       id="will_be_in_use">
                <div>
                    @error('willBeInUse')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
{{--    <div class="card-footer" wire:loading.class="invisible">--}}
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
</form>
