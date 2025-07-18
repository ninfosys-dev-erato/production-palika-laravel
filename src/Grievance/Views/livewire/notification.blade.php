<div class="container mx-auto mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.manage_notification_settings') }}</h5>
    </div>
    <div class="card">

        <div class="card-body">
            <p class="text-dark mb-4">
                {{__('grievance::grievance.select_the_channels_through_which_you_want_to_receive_updates')}}
            </p>
            <div class="form-check mb-3">
                <input dusk="grievance-settings.mail-field" type="checkbox" wire:model="settings.mail" id="email-notifications" class="form-check-input">
                <label for="email-notifications" class="form-check-label">
                   {{__('grievance::grievance.email_notifications')}}
                </label>
            </div>

            <div class="form-check mb-3">
                <input dusk="grievance-settings.sms-field" type="checkbox" wire:model="settings.sms" id="sms-notifications" class="form-check-input">
                <label for="sms-notifications" class="form-check-label">
                    {{__('grievance::grievance.sms_notifications')}}
                </label>
            </div>

            <div class="form-check mb-3">
                <input dusk="grievance-settings.fcm-field" type="checkbox" wire:model="settings.fcm" id="fcm-notifications" class="form-check-input" disabled>
                <label for="fcm-notifications" class="form-check-label">
                   {{__('grievance::grievance.mobile_notifications')}}
                </label>
            </div>

            <button wire:click="saveSettings" class="btn btn-primary">
                {{__('grievance::grievance.save')}} 
            </button>
        </div>
    </div>
</div>
