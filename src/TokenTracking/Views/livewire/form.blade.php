<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='fiscal_year'>{{ __('tokentracking::tokentracking.fiscal_year') }}</label>
                    <input wire:model='registerToken.fiscal_year' name='fiscal_year' type='text' class='form-control'
                        placeholder="{{ __('tokentracking::tokentracking.enter_fiscal_year') }}" readonly>
                    <div>
                        @error('registerToken.fiscal_year')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='date'>{{ __('tokentracking::tokentracking.date') }}</label>
                    <input wire:model='registerToken.date' id="date" name='date' type='text'
                        class='form-control' placeholder="{{ __('tokentracking::tokentracking.enter_date') }}" readonly>
                    <div>
                        @error('registerToken.date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('tokentracking::tokentracking.visit_purpose_details') }}</div>
            </div>
            <div class='col-md-12 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='token'>{{ __('tokentracking::tokentracking.token') }}</label>
                    <input wire:model='registerToken.token' name='token' type='text' class='form-control'
                        placeholder="{{ __('tokentracking::tokentracking.enter_token') }}">
                    <div>
                        @error('registerToken.token')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='token_purpose'>{{ __('tokentracking::tokentracking.token_purpose') }}</label>
                    <select wire:model='registerToken.token_purpose' name='token_purpose' class='form-control'>
                        <option value="">{{ __('tokentracking::tokentracking.select_token_purpose') }}</option>
                        @foreach (\Src\TokenTracking\Enums\TokenPurposeEnum::getValuesWithLabels() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('registerToken.token_purpose')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='current_branch'>{{ __('tokentracking::tokentracking.current_branch') }}</label>
                    <select wire:model='registerToken.current_branch' name='registerToken.current_branch'
                        class='form-control'>
                        <option value="">{{ __('tokentracking::tokentracking.select_current_branch') }}</option>
                        @foreach ($currentBranches as $branch)
                            <option value="{{ $branch['id'] }}">{{ $branch['title'] }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('registerToken.current_branch')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='entry_time'>{{ __('tokentracking::tokentracking.entry_time') }}</label>
                    <input wire:model='registerToken.entry_time' name='entry_time' type='time' class='form-control'
                        placeholder="{{ __('tokentracking::tokentracking.enter_entry_time') }}">
                    <div>
                        @error('registerToken.entry_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='exit_time'>{{ __('tokentracking::tokentracking.exit_time') }}</label>
                    <input wire:model='registerToken.exit_time' name='exit_time' type='time' class='form-control'
                        placeholder="{{ __('tokentracking::tokentracking.enter_exit_time') }}">
                    <div>
                        @error('registerToken.exit_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div> --}}
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label class="form-label" for='estimated_time'>{{ __('tokentracking::tokentracking.estimated_time') }}</label>
                    <input wire:model='registerToken.estimated_time' name='estimated_time' type='number'
                        class='form-control' placeholder="{{ __('tokentracking::tokentracking.enter_estimated_time') }}">
                    <div>
                        @error('registerToken.estimated_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="divider divider-primary text-start text-primary font-14">
            <div class="divider-text ">{{ __('tokentracking::tokentracking.visitor_details') }}</div>
        </div>
        <livewire:phone_search />
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
                        <input wire:model='tokenHolder.mobile_no' name='mobile_no' type='text'
                            class='form-control' placeholder="{{ __('tokentracking::tokentracking.enter_mobile_no') }}">
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
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('tokentracking::tokentracking.save') }}</button>
        <a href="{{ route('admin.register_tokens.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('tokentracking::tokentracking.back') }}</a>
    </div>
</form>
