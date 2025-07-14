<form wire:submit.prevent="save">

    <div class="card-body">
        <div class="row">
            <div>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='budgetHead.title' name='title' type='text'
                        class="form-control {{ $errors->has('budgetHead.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('budgetHead.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='{{ __('yojana::yojana.enter_title') }}'>
                    <div>
                        @error('budgetHead.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer ">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
    </div>
</form>
