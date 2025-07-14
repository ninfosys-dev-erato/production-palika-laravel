<div style="width: 100%; position: relative">
    <select class="border-light w-full"
            wire:confirm="Are you sure?"
            wire:change.live="updateStatus({{ $row->id }}, $event.target.value)"
            style="width: 100%; text-align: center; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding: 8px;">
        <option value="{{\Src\TaskTracking\Enums\TaskStatus::TODO}}" {{ $row->status === 'todo' ? 'selected' : '' }} style="text-align: center;">
            {{ __('tasktracking::tasktracking.to_do') }}
        </option>
        <option value="{{\Src\TaskTracking\Enums\TaskStatus::INPROGRESS}}" {{ $row->status === 'in_progress' ? 'selected' : '' }} style="text-align: center;">
            {{ __('tasktracking::tasktracking.in_progress') }}
        </option>
        <option value="{{\Src\TaskTracking\Enums\TaskStatus::COMPLETED}}" {{ $row->status === 'Complete' ? 'selected' : '' }} style="text-align: center;">
            {{ __('tasktracking::tasktracking.completed') }}
        </option>
    </select>
</div>
