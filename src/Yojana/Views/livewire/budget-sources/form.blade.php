<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('yojana::yojana.title') }}</label>
                    <input wire:model='budgetSource.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_title') }}">
                    <div>
                        @error('budgetSource.title')
                            <small class='text-danger'>{{ __(__($message)) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='code'>{{ __('yojana::yojana.code') }}</label>
                    <input wire:model='budgetSource.code' name='code' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_code') }}">
                    <div>
                        @error('budgetSource.code')
                            <small class='text-danger'>{{ __(__($message)) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='level_id'>{{ __('yojana::yojana.level') }}</label>
                    <select wire:model='budgetSource.level_id' name="level_id" class="form-control">
                        <option value="" hidden>{{ __('yojana::yojana.select_an_level') }}</option>
                        @foreach ($levels as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='budgetSource.level_id' name='level_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_level_id')}}"> --}}
                    <div>
                        @error('budgetSource.level_id')
                            <small class='text-danger'>{{ __(__($message)) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <button class="btn btn-danger" wire:loading.attr="disabled" type="button" data-bs-dismiss="modal"
            onclick="resetForm()">{{ __('yojana::yojana.back') }}</button>
    </div>
</form>
