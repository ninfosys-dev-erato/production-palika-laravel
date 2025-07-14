<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-12'>
            <div class='form-group'>
                <label class="form-label" for='title'>{{__('yojana::yojana.title')}}</label>
                <input wire:model='type.title' name='title' type='text' class='form-control
                {{ $errors->has('type.title') ? 'is-invalid' : '' }}'
                       placeholder='{{__('yojana::yojana.enter_title')}}'>
                <div>
                    @error('type.title')
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
