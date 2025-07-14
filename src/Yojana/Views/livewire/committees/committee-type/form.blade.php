<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='name'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='committeeType.name' name='name' type='text'
                        class="form-control {{ $errors->has('committeeType.name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('committeeType.name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('committeeType.name')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='committee_no'>{{ __('yojana::yojana.committee_no') }}</label>
                    <input wire:model='committeeType.committee_no' name='committee_no' type='number' min="0"
                        class="form-control {{ $errors->has('committeeType.committee_no') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('committeeType.committee_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('yojana::yojana.enter_committee_no') }}">
                    <div>
                        @error('committeeType.committee_no')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.committee-types.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
