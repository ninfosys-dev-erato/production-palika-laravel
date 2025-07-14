<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('tasktracking::tasktracking.title') }}</label>
                    <input wire:model='project.title' name='title' type='text'
                        class="form-control {{ $errors->has('project.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('project.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('tasktracking::tasktracking.enter_title') }}">
                    <div>
                        @error('project.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='description'>{{ __('tasktracking::tasktracking.description') }}</label>
                    <input wire:model='project.description' name='description' type='text'
                        class="form-control {{ $errors->has('project.description') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('project.description') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('tasktracking::tasktracking.enter_description') }}">
                    <div>
                        @error('project.description')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('tasktracking::tasktracking.save') }}</button>
        <a href="{{ route('admin.task.projects.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('tasktracking::tasktracking.back') }}</a>
    </div>
</form>
