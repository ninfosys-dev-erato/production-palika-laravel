<div>
    <div>
        <label class="switch">
            <input type="checkbox" wire:click="save" {{ $grievanceDetail->is_visible_to_public ? 'checked' : '' }}
                wire:confirm="{{ __('grievance::grievance.are_you_sure_you_want_to_change_the_status') }}">
            <span class="slider round"></span>
        </label>
        <span>{{ __('grievance::grievance.currently_visible_to_users_uncheck_to_hide') }}</span>
    </div>
</div>