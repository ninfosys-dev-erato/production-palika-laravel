<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row justify-content-center">
            <div>
                <div class='form-group mb-3'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='expenseHead.title' name='title' type='text'
                        class="form-control {{ $errors->has('expenseHead.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('expenseHead.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='{{ __('yojana::yojana.enter_title') }}'>
                    <div>
                        @error('expenseHead.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <div class='form-group mb-3'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='expenseHead.code' name='code' type='text'
                        class="form-control {{ $errors->has('expenseHead.code') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('expenseHead.code') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='{{ __('yojana::yojana.enter_code') }}'>
                    <div>
                        @error('expenseHead.code')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <div class='form-group mb-3'>
                    <label class="form-label" for='type'>{{ __('yojana::yojana.type') }}</label>
                    <input wire:model='expenseHead.type' name='type' type='text'
                           class="form-control {{ $errors->has('expenseHead.type') ? 'is-invalid' : '' }}"
                           style="{{ $errors->has('expenseHead.type') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                           placeholder='{{ __('yojana::yojana.enter_type') }}'>
                    <div>
                        @error('expenseHead.type')
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
