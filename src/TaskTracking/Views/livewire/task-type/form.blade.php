<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='type_name'>{{ __('tasktracking::tasktracking.type_name') }}</label>
                    <input wire:model='taskType.type_name' name='type_name' type='text'
                        class="form-control {{ $errors->has('taskType.type_name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('taskType.type_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('tasktracking::tasktracking.enter_type_name') }}">
                    <div>
                        @error('taskType.type_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('tasktracking::tasktracking.save')}}</button>
        <a href="{{ route('admin.task-types.index') }}" wire:loading.attr="disabled" class="btn btn-danger">{{__('tasktracking::tasktracking.back')}}</a>
    </div>
</form>
