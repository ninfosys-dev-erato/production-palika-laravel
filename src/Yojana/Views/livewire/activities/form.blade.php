<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='activity.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('activity.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='group_id'>{{ __('yojana::yojana.group_name') }}</label>
                    <select wire:model='activity.group_id' name='group_id' class="form-control">
                        <option value=""hidden>{{ __('yojana::yojana.select_group_name') }}</option>
                        @foreach ($projectActivityGroups as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='activity.group_id' name='group_id' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_group_id') }}"> --}}
                    <div>
                        @error('activity.group_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='activity.code' name='code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_code') }}">
                    <div>
                        @error('activity.code')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='ref_code'>{{ __('yojana::yojana.ref_code') }}</label>
                    <input wire:model='activity.ref_code' name='ref_code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_ref_code') }}">
                    <div>
                        @error('activity.ref_code')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='unit_id'>{{ __('yojana::yojana.unit') }}</label>
                    <select wire:model='activity.unit_id' name='unit_id' class="form-control">
                        <option value=""hidden>{{ __('yojana::yojana.select_unit') }}</option>
                        @foreach ($units as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='activity.unit_id' name='unit_id' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_unit_id') }}"> --}}
                    <div>
                        @error('activity.unit_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='qty_for'>{{ __('yojana::yojana.qty_for') }}</label>
                    <input wire:model='activity.qty_for' name='qty_for' type='number' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_qty_for') }}">
                    <div>
                        @error('activity.qty_for')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mt-3'>
                <div class='form-group'>
                    <label class="form-label" for='will_be_in_use'>{{ __('yojana::yojana.will_be_in_use') }}</label>
                    <input wire:model='activity.will_be_in_use' name='will_be_in_use' type='checkbox'
                        class="form-check-input border-dark p-2 mt-1" placeholder="{{ __('yojana::yojana.enter_will_be_in_use') }}">
                    <div>
                        @error('activity.will_be_in_use')
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
