<form wire:submit.prevent="save">
    <div class="card-body ">
        <div class="row">
            <div class='col-md'>
            <div class='form-group'>
                <label class="form-label" for='area_name'>{{__('yojana::yojana.area_name')}}</label>
                <input wire:model='planArea.area_name' name='area_name' type='text' class='form-control' placeholder='{{__('yojana::yojana.enter_area_name')}}'>
                <div>
                    @error('planArea.area_name')
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
