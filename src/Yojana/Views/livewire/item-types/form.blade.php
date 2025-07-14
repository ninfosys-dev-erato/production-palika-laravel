<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='itemType.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('itemType.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='code'>{{__('yojana::yojana.code')}}</label>
        <input wire:model='itemType.code' name='code' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_code')}}">
        <div>
            @error('itemType.code')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='group'>{{__('yojana::yojana.group')}}</label>
        <input wire:model='itemType.group' name='group' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_group')}}">
        <div>
            @error('itemType.group')
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
