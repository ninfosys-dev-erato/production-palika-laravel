<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='projectGroup.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('projectGroup.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='group_id'>{{ __('yojana::yojana.project_group') }}</label>
                    <select wire:model='projectGroup.group_id' name='group_id' class='form-control'>
                        <option value="" hidden>{{ __('yojana::yojana.select_project_group_name') }}</option>
                        @foreach ($projectGroups as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    {{-- <input wire:model='projectGroup.group_id' name='group_id' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_group_id') }}"> --}}
                    <div>
                        @error('projectGroup.group_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='area_id'>{{ __('yojana::yojana.area_name') }}</label>
                    <select wire:model='projectGroup.area_id' name="area_id" class='form-control'>
                        <option value=""hidden>{{ __('yojana::yojana.select_area_name') }}</option>
                        @foreach ($planAreas as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='projectGroup.area_id' name='area_id' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_area_id') }}"> --}}
                    <div>
                        @error('projectGroup.area_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='projectGroup.code' name='code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_code') }}">
                    <div>
                        @error('projectGroup.code')
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
