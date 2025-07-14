<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='normType.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('normType.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='authority_name'>{{ __('yojana::yojana.authority_name') }}</label>
                    <input wire:model='normType.authority_name' name='authority_name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_authority_name') }}">
                    <div>
                        @error('normType.authority_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='year'>{{ __('yojana::yojana.year') }}</label>
                    <input wire:model='normType.year' name='year' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_year') }}">
                    <div>
                        @error('normType.year')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <button class="btn btn-danger" wire:loading.attr="disabled" data-bs-dismiss="modal"
            onclick="resetForm()">{{ __('yojana::yojana.back') }}</button>
    </div>
</form>
