<div>
    <div class="row">
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='name'>{{ __('tokentracking::tokentracking.name') }}</label>
                <input wire:model='tokenHolder.name' name='name' type='text' class='form-control'
                    placeholder="{{ __('tokentracking::tokentracking.enter_name') }}">
                <div>
                    @error('tokenHolder.name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='email'>{{ __('tokentracking::tokentracking.email') }}</label>
                <input wire:model='tokenHolder.email' name='email' type='text' class='form-control'
                    placeholder="{{ __('tokentracking::tokentracking.enter_email') }}">
                <div>
                    @error('tokenHolder.email')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='mobile_no'>{{ __('tokentracking::tokentracking.mobile_no') }}</label>
                <input wire:model='tokenHolder.mobile_no' name='mobile_no' type='text' class='form-control'
                    placeholder="{{ __('tokentracking::tokentracking.enter_mobile_no') }}">
                <div>
                    @error('tokenHolder.mobile_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='address'>{{ __('tokentracking::tokentracking.address') }}</label>
                <input wire:model='tokenHolder.address' name='address' type='text' class='form-control'
                    placeholder="{{ __('tokentracking::tokentracking.enter_address') }}">
                <div>
                    @error('tokenHolder.address')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</div>
