<!-- resources/views/livewire/task-table.blade.php -->

<div>
    <!-- Search -->
    <input type="text" wire:model="searchTerm" placeholder="Search tasks" class="form-control mb-3">

    <!-- Bulk Actions -->
    {{-- <div class="mb-3">
        <button class="btn btn-primary" wire:click="exportSelected">Export Selected</button>
        <button class="btn btn-danger" wire:click="deleteSelected">Delete Selected</button>
    </div> --}}

    <!-- Task Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" wire:model="selectedTasks" value="all"></th>
                <th>Project</th>
                <th>Task Type</th>
                <th>Task No</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assignee</th>
                <th>Reporter</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td><input type="checkbox" wire:model="selectedTasks" value="{{ $task->id }}"></td>
                    <td>{{ $task->project_id }}</td>
                    <td>{{ $task->task_type_id }}</td>
                    <td>{{ $task->task_no }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->assignee_id }}</td>
                    <td>{{ $task->reporter_id }}</td>
                    <td>{{ $task->start_date }}</td>
                    <td>{{ $task->end_date }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            wire:click="openModal({{ $task->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" wire:click="delete({{ $task->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Edit Modal -->
    @if ($isModalOpen)
        <div class="modal fade" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">
                            @if (isset($task))
                                {{ __('tasktracking::tasktracking.edit_task') }}
                            @else
                                {{ __('tasktracking::tasktracking.add_task') }}
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            @if (isset($task))
                                <livewire:task_tracking.task_form :$action :$task />
                            @else
                                <livewire:task_tracking.task_form :$action />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
