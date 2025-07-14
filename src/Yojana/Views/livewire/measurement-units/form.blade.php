<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='type_id'>{{__('yojana::yojana.measurement_type')}}</label>
                <select wire:model='measurementUnit.type_id' name='type_id' type='text' class='form-control
                {{ $errors->has('measurementUnit.type_id') ? 'is-invalid' : '' }}' >
                    <option value=""  hidden >{{__('yojana::yojana.select_measurement_type')}}</option>
                @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->title}}</option>
                    @endforeach
                </select>
                <div>
                    @error('measurementUnit.type_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
                <input wire:model='measurementUnit.title' name='title' type='text' class='form-control
                {{ $errors->has('measurementUnit.title') ? 'is-invalid' : '' }}'
                placeholder='{{__('yojana::yojana.enter_title')}}'>
                <div>
                    @error('measurementUnit.title')
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
