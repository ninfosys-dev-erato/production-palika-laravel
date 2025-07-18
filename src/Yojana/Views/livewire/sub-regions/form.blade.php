<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='subRegion.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('subRegion.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='subRegion.code' name='code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_code') }}">
                    <div>
                        @error('subRegion.code')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='area_id'>{{ __('yojana::yojana.area') }}</label>
                    <select wire:model='subRegion.area_id' name="area_id" class="form-control">
                        <option value="" hidden>{{ __('yojana::yojana.select_an_area') }}</option>
                        @foreach ($planAreas as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('subRegion.area_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 mt-3'>
                <div class='form-group'>
                    <label class="form-label" for='in_use'>{{ __('yojana::yojana.in_use') }}</label>
                    <input wire:model='subRegion.in_use' name='in_use' type='checkbox'
                        placeholder="{{ __('yojana::yojana.enter_in_use') }}" class="form-check-input border-dark p-2 mt-1">
                    <div>
                        @error('subRegion.in_use')
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
