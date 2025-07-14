<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='bankDetail.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('bankDetail.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 mb-3'>
    <div class='form-group'>
        <label class="form-label" for='branch'>{{__('yojana::yojana.branch')}}</label>
        <input wire:model='bankDetail.branch' name='branch' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_branch')}}">
        <div>
            @error('bankDetail.branch')
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
