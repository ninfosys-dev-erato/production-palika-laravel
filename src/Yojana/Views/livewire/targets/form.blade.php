<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='target.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('target.title')
                <small class='text-danger'>{{ __(__($message)) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='code'>{{__('yojana::yojana.code')}}</label>
        <input wire:model='target.code' name='code' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_code')}}">
        <div>
            @error('target.code')
                <small class='text-danger'>{{ __(__($message)) }}</small>
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
