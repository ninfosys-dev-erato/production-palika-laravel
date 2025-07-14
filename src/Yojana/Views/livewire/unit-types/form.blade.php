<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='unitType.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('unitType.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='title_en'>{{__('yojana::yojana.title_en')}}</label>
        <input wire:model='unitType.title_en' name='title_en' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title_en')}}">
        <div>
            @error('unitType.title_en')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='display_order'>{{__('yojana::yojana.display_order')}}</label>
        <input wire:model='unitType.display_order' name='display_order' type='number' class='form-control' placeholder="{{__('yojana::yojana.enter_display_order')}}">
        <div>
            @error('unitType.display_order')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 m-2'>
    <div class='form-group'>
        <label class="form-label" for='will_be_in_use'>{{__('yojana::yojana.will_be_in_use')}}</label>
{{--        <input wire:model='unitType.will_be_in_use' name='will_be_in_use' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_will_be_in_use')}}">--}}
        <input wire:model="willBeInUse" name="will_be_in_use" type="checkbox"
               class="form-check-input m-1"
               id="will_be_in_use">
        <div>
        <div>
            @error('unitType.will_be_in_use')
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
    </div>
</form>
