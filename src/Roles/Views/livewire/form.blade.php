<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='name'>{{ __('Name') }}</label>
                    <input wire:model='role.name' name='name' type='text'
                        class="form-control {{ $errors->has('role.name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('role.name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('Enter Name') }}">
                    <div>
                        @error('role.name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='guard_name'>{{ __('Guard Name') }}</label>
                    <input wire:model='role.guard_name' name='guard_name' type='text'
                        class="form-control {{ $errors->has('role.guard_name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('role.guard_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('Enter Guard Name') }}">
                    <div>
                        @error('role.guard_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.roles.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
