<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div>
                <div class='form-group'>
                    <label class="form-label" for='level_name'>{{ __('yojana::yojana.level_name') }}</label>
                    <input wire:model='planLevel.level_name' name='level_name' type='text'
                        class="form-control {{ $errors->has('planLevel.level_name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('planLevel.level_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('yojana::yojana.enter_level_name') }}">
                    <div>
                        @error('planLevel.level_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
    </div>
</form>
