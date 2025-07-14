<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='item.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('item.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='type_id'>{{__('yojana::yojana.type')}}</label>
        <select wire:model='item.type_id' name='type_id' type='text'
                class='form-control {{ $errors->has('item.type_id') ? 'is-invalid' : '' }}'>
            <option value="" hidden >{{__('yojana::yojana.select_item_type')}}</option>
            @foreach($types as $type)
                <option value="{{$type->id}}">{{$type->title}}</option>
            @endforeach
        </select>
        <div>
            @error('item.type_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='code'>{{__('yojana::yojana.code')}}</label>
        <input wire:model='item.code' name='code' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_code')}}">
        <div>
            @error('item.code')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='unit_id'>{{__('yojana::yojana.unit')}}</label>
        <select wire:model='item.unit_id' name='unit_id' type='text'
                class='form-control {{ $errors->has('item.unit_id') ? 'is-invalid' : '' }}'>
            <option value="" hidden >{{__('yojana::yojana.select_unit')}}</option>
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->title}}</option>
            @endforeach
        </select>
        <div>
            @error('item.unit_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='remarks'>{{__('yojana::yojana.remarks')}}</label>
        <input wire:model='item.remarks' name='remarks' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_remarks')}}">
        <div>
            @error('item.remarks')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.items.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
