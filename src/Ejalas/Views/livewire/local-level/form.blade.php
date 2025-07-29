<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ejalas::ejalas.ejalashlocallevellisttitle') }}</label>
                    <input wire:model='localLevel.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_title') }}">
                    <div>
                        @error('localLevel.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='short_title'>{{ __('ejalas::ejalas.ejalashlocallevellistsurname') }}</label>
                    <input wire:model='localLevel.short_title' name='short_title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_short_title') }}">
                    <div>
                        @error('localLevel.short_title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='type'>{{ __('ejalas::ejalas.ejalashlocallevellisttype') }}</label>
                    <select wire:model='localLevel.type' name='type' type='text' class='form-control'>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_level') }}</option>
                        @foreach ($localLevelTypes as $localLevelType)
                            <option value="{{ $localLevelType->value }}">{{ $localLevelType->value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='localLevel.type' name='type' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_type') }}"> --}}
                    <div>
                        @error('localLevel.type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='province_id'>{{ __('ejalas::ejalas.province') }}</label>
                    <select wire:model='localLevel.province_id' name='province_id' type='text' class='form-control'
                        wire:change='getDistrict'>
                        <option value=""hidden>{{ __('ejalas::ejalas.select_a_province') }}</option>
                        @foreach ($provinces as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='localLevel.province_id' name='province_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_province_id') }}"> --}}
                    <div>
                        @error('localLevel.province_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='district_id'>{{ __('ejalas::ejalas.district') }}</label>
                    <select wire:model='localLevel.district_id' name='district_id' type='text' class='form-control'
                        wire:change='getLocalBody'>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_district') }}</option>
                        @foreach ($districts as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='localLevel.district_id' name='district_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_district_id') }}"> --}}
                    <div>
                        @error('localLevel.district_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='local_body_id'>{{ __('ejalas::ejalas.local_body') }}</label>
                    <select wire:model='localLevel.local_body_id' name='local_body_id' type='text'
                        class='form-control'>
                        <option value=""hidden>{{ __('ejalas::ejalas.select_a_local_body') }}</option>
                        @foreach ($localBodies as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='localLevel.local_body_id' name='local_body_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_local_body_id') }}"> --}}
                    <div>
                        @error('localLevel.local_body_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='mobile_no'>{{ __('ejalas::ejalas.mobile_no') }}</label>
                    <input wire:model='localLevel.mobile_no' name='mobile_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_mobile_no') }}">
                    <div>
                        @error('localLevel.mobile_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='email'>{{ __('ejalas::ejalas.email') }}</label>
                    <input wire:model='localLevel.email' name='email' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_email') }}">
                    <div>
                        @error('localLevel.email')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='website'>{{ __('ejalas::ejalas.website') }}</label>
                    <input wire:model='localLevel.website' name='website' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_website') }}">
                    <div>
                        @error('localLevel.website')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='position'>{{ __('ejalas::ejalas.position') }}</label>
                    <input wire:model='localLevel.position' name='position' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_position') }}">
                    <div>
                        @error('localLevel.position')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.local_levels.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
