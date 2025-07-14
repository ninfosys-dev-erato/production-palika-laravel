<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='projectActivityGroup.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('projectActivityGroup.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='projectActivityGroup.code' name='code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_code') }}">
                    <div>
                        @error('projectActivityGroup.code')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='group_id'>{{ __('yojana::yojana.project_group_name') }}</label>
                    <select wire:model='projectActivityGroup.group_id' name="group_id" class='form-control'>
                        <option value="" hidden>{{ __('yojana::yojana.select_project_group') }}</option>
                        @foreach ($projectActivityGroups as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='projectActivityGroup.group_id' name='group_id' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_group_id') }}"> --}}
                    <div>
                        @error('projectActivityGroup.group_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='norms_type'>{{ __('yojana::yojana.norms_type') }}</label>
                    <select wire:model='projectActivityGroup.norms_type' name='norms_type'class='form-control'>
                        <option value=""hidden>{{ __('yojana::yojana.select_norm_types') }}</option>
                        @foreach ($normTypes as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='projectActivityGroup.norms_type' name='norms_type' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_norms_type') }}"> --}}
                    <div>
                        @error('projectActivityGroup.norms_type')
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
