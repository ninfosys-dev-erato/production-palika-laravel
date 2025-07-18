<form wire:submit.prevent="save">

        <select
            label="{{ __('grievance::grievance.set_priority') }}"
            id="status"
            id="priority" name="grievanceDetail.priority"
            class="form-control"
            wire:model="grievanceDetail.priority"
        >
            <option value="" hidden>{{ __('grievance::grievance.choose_priority') }}</option>
            @foreach(\Src\Grievance\Enums\GrievancePriorityEnum::cases() as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>

    <div class="mt-3">
        <button type="submit" wire:confirm="Are you sure you want to assign the grievance?"
            class="btn btn-primary">{{ __('grievance::grievance.save') }}</button>
    </div>
</form>
