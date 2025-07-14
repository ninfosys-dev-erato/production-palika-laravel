<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='cooperative_id'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.cooperative_id') }}</label>
                    <input wire:model='cooperativeFarmer.cooperative_id' name='cooperative_id' type='text'
                        class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_cooperative_id') }}">
                    <div>
                        @error('cooperativeFarmer.cooperative_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='farmer_id'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.farmer_id') }}</label>
                    <input wire:model='cooperativeFarmer.farmer_id' name='farmer_id' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_farmer_id') }}">
                    <div>
                        @error('cooperativeFarmer.farmer_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
        <a href="{{ route('admin.cooperative_farmers.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
    </div>
</form>
