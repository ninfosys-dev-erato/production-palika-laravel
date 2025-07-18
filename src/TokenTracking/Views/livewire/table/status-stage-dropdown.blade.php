<div class="space-y-4 w-full">
    {{-- Stage Selector --}}
    <div class="w-full">
        <label for="stage-{{ $row->id }}" class="block text-sm font-medium text-gray-700 text-center mb-1">
            {{ __('tokentracking::tokentracking.stage') }}
        </label>
        <select id="stage-{{ $row->id }}"
            class="form-select w-full text-center px-4 py-2 border-gray-300 rounded-md focus:ring focus:ring-blue-200"
            wire:change.defer="updateStage({{ $row->id }}, $event.target.value)"
            @if ($row->exit_time) disabled @endif>
            <option value="{{ \Src\TokenTracking\Enums\TokenStageEnum::ENTRY }}" @selected($row->stage === 'entry')>
                {{ __('tokentracking::tokentracking.entry') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStageEnum::TOKEN_ORDER }}" @selected($row->stage === 'token_order')>
                {{ __('tokentracking::tokentracking.token_order') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStageEnum::REGISTRATION }}" @selected($row->stage === 'registration')>
                {{ __('tokentracking::tokentracking.registration') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStageEnum::VERIFICATION }}" @selected($row->stage === 'verification')>
                {{ __('tokentracking::tokentracking.verification') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStageEnum::COMPLETION }}" @selected($row->stage === 'completion')>
                {{ __('tokentracking::tokentracking.completion') }}</option>
        </select>
    </div>

    {{-- Status Selector --}}
    <div class="w-full">
        <label for="status-{{ $row->id }}" class="block text-sm font-medium text-gray-700 text-center mb-1">
            {{ __('tokentracking::tokentracking.status') }}
        </label>
        <select id="status-{{ $row->id }}"
            class="form-select w-full text-center px-4 py-2 border-gray-300 rounded-md focus:ring focus:ring-blue-200"
            wire:change="updateStatus({{ $row->id }}, $event.target.value)"
            @if ($row->exit_time) disabled @endif>
            <option value="{{ \Src\TokenTracking\Enums\TokenStatusEnum::SKIPPING }}" @selected($row->status === 'skipping')>
                {{ __('tokentracking::tokentracking.skipping') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStatusEnum::PROCESSING }}" @selected($row->status === 'processing')>
                {{ __('tokentracking::tokentracking.processing') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStatusEnum::REJECTED }}" @selected($row->status === 'rejected')>
                    {{ __('tokentracking::tokentracking.rejected') }}</option>
            <option value="{{ \Src\TokenTracking\Enums\TokenStatusEnum::COMPLETE }}" @selected($row->status === 'complete')>
                {{ __('tokentracking::tokentracking.complete') }}</option>
        </select>
    </div>
</div>
