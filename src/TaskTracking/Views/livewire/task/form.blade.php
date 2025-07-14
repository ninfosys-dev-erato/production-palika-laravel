<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="project_id">{{ __('tasktracking::tasktracking.choose_project') }}</label>
                    <select wire:model="task.project_id" name="project_id" wire:change='assignTaskNo'
                        class="form-control {{ $errors->has('task.project_id') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.project_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="">-- {{ __('tasktracking::tasktracking.select_project') }} --</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('task.project_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label" for="task_no">{{ __('tasktracking::tasktracking.task_no') }}</label>
                    <input wire:model="task.task_no" name="task_no" type="text"
                        class="form-control {{ $errors->has('task.task_no') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.task_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        readonly placeholder="{{ __('tasktracking::tasktracking.task_no') }}">
                    <div>
                        @error('task.task_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="task_type_id">{{ __('tasktracking::tasktracking.choose_task_type') }}</label>
                    <select wire:model="task.task_type_id" name="task_type_id"
                        class="form-control {{ $errors->has('task.task_no') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.task_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="">-- {{ __('tasktracking::tasktracking.select_task_type') }} --</option>
                        @foreach ($taskTypes as $taskType)
                            <option value="{{ $taskType->id }}">{{ $taskType->type_name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('task.task_type_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label" for="status">{{ __('tasktracking::tasktracking.status') }}</label>
                    <select wire:model="task.status" name="status"
                        class="form-control {{ $errors->has('task.status') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.status') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="">-- {{ __('tasktracking::tasktracking.select_status') }} --</option>
                        @foreach (\Src\TaskTracking\Enums\TaskStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('task.status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('tasktracking::tasktracking.title') }}</label>
                    <input wire:model='task.title' name='title' type='text'
                        class="form-control {{ $errors->has('task.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('tasktracking::tasktracking.enter_title') }}">
                    <div>
                        @error('task.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <x-form.ck-editor-input label="{{ __('tasktracking::tasktracking.task_description') }}"
                        id="task_description" name="task.description" :value="$task->description ?? ''" />
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="assignee_type">{{ __('tasktracking::tasktracking.assignee_type') }}</label>
                    <select wire:model="task.assignee_type" name="assignee_type" id="assignee_type"
                        class="form-control {{ $errors->has('task.assignee_type') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.assignee_type') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        wire:change="loadAssigne" class="form-control">
                        <option value="">-- {{ __('tasktracking::tasktracking.select_assignee_type') }} --
                        </option>
                        @foreach ($availableAssigneeTypes as $model => $label)
                            <option value="{{ $model }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('task.assignee_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3 ">
                <div class="form-group" wire:ignore>
                    <label class="form-label" for="assignee_id">{{ __('tasktracking::tasktracking.assignee') }}</label>
                    <select id="assignee_id" wire:model="task.assignee_id" name="task.assignee_id" class="form-control">
                    </select>

                    <div>
                        @error('task.assignee_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='reporter_type'>{{ __('tasktracking::tasktracking.reporter_type') }}</label>
                    <select wire:model='task.reporter_type' name='reporter_type' type='text'
                        class="form-control {{ $errors->has('task.reporter_type') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('task.reporter_type') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        wire:change="loadReporter" class='form-control' placeholder='Enter Reporter Type'>
                        <option value="">-- {{ __('tasktracking::tasktracking.select_reporter_type') }} --
                        </option>
                        @foreach ($availableReporterTypes as $model => $label)
                            <option value="{{ $model }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('task.reporter_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class='col-md-6 mb-3'>
                <div class='form-group' wire:ignore>
                    <label class="form-label"
                        for='reporter_id'>{{ __('tasktracking::tasktracking.reporter') }}</label>
                    <select id="reporter_id" wire:model='task.reporter_id' name='task.reporter_id' type='text'
                        class='form-control'>
                    </select>
                    <div>
                        @error('task.reporter_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="start_date">{{ __('tasktracking::tasktracking.start_date') }}</label>
                <input type="text" name="task.start_date" id="start_date"
                    class="form-control {{ $errors->has('task.start_date') ? 'is-invalid' : '' }} nepali-date"
                    style="{{ $errors->has('task.start_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    wire:model="task.start_date"
                    placeholder="{{ __('tasktracking::tasktracking.select_start_date') }}" />

                @error('task.start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="end_date">{{ __('tasktracking::tasktracking.end_date') }}</label>
                <input type="text" name="task.end_date" id="end_date"
                    class="form-control {{ $errors->has('task.end_date') ? 'is-invalid' : '' }} nepali-date"
                    style="{{ $errors->has('task.end_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    wire:model="task.end_date"
                    placeholder="{{ __('tasktracking::tasktracking.select_end_date') }}" />

                @error('task.end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="mb-3">
            <div class="form-group">
                <label class="form-label"
                    for="files">{{ __('tasktracking::tasktracking.upload_attachments') }}</label>
                <input wire:model="files" name="files" type="file" class="form-control"
                    accept=".pdf,.doc,.docx,image/*" multiple>
                @error('files.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('tasktracking::tasktracking.save') }}</button>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            initializeSelect2();
        });

        function initializeSelect2() {
            $('#assignee_id').select2({
                placeholder: {{ __('tasktracking::tasktracking._select_assignee_') }},
            }).on('change', function() {
                @this.set('task.assignee_id', $(this).val());
            });

            $('#reporter_id').select2({
                placeholder: {{ __('tasktracking::tasktracking._select_reporter_') }},
            }).on('change', function() {
                @this.set('task.reporter_id', $(this).val());
            });

            $wire.on('assignee_type-change', () => {
                var users = JSON.parse(JSON.stringify(@this.users));
                var transformedData = $.map(users, function(obj) {
                    obj.id = obj.id || obj.pk;
                    obj.text = obj.text || obj.name;
                    return obj;
                });

                $('#assignee_id').select2({
                    placeholder: {{ __('tasktracking::tasktracking._select_assignee_') }},
                    data: transformedData
                });
                $('#assignee_id').val(@this.task.assignee_id).trigger('change');
            });

            $wire.on('reporter_type-change', () => {
                var reporters = JSON.parse(JSON.stringify(@this.reporters));
                var transformedReporterData = $.map(reporters, function(obj) {
                    obj.id = obj.id || obj.pk;
                    obj.text = obj.text || obj.name;
                    return obj;
                });

                $('#reporter_id').select2({
                    placeholder: {{ __('tasktracking::tasktracking._select_reporter_') }},
                    data: transformedReporterData
                });
                $('#reporter_id').val(@this.task.reporter_id).trigger('change');
            });
        }
    </script>
@endscript
