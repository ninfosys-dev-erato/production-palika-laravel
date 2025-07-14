<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='benefitedMember.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('benefitedMember.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 '>
                <div class='form-group'>
                    <label class="form-label" for='is_population'>{{ __('yojana::yojana.is_population') }}</label>
                    <input wire:model='benefitedMember.is_population' name='is_population' type='checkbox'
                        class="form-check-input border-dark p-2 mt-1" placeholder="{{ __('yojana::yojana.enter_is_population') }}">
                    <div>
                        @error('benefitedMember.is_population')
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
