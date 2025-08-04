<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title' class='form-label'>{{ __('grantmanagement::grantmanagement.title') }}</label>
                    <input wire:model='grantType.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_title') }}">
                    <div>
                        @error('grantType.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title_en'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.title_en') }}</label>
                    <input wire:model='grantType.title_en' name='title_en' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_title_en') }}">
                    <div>
                        @error('grantType.title_en')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='amount' class='form-label'>{{ __('grantmanagement::grantmanagement.amount') }}</label>
                    <input wire:model='grantType.amount' name='amount' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_amount') }}">
                    <div>
                        @error('grantType.amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='department'
                        class='form-label'>{{ __('grantmanagement::grantmanagement.department') }}</label>
                    {{-- <input wire:model='grantType.department' name='department' type='text' class='form-control'
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_department') }}"> --}}
                    <select wire:model='grantType.department' name='department' class='form-select'>
                        <option value="" hidden>{{ __('grantmanagement::grantmanagement.select_branch') }}
                        </option>
                        @foreach ($branches as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('grantType.department')
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
        <a href="{{ route('admin.grant_types.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
    </div>
</form>
