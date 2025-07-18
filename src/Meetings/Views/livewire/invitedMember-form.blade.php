<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <livewire:phone_search />
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Name') }}" id="name" name="invitedMember.name" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Designation') }}" id="designation" name="invitedMember.designation" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Phone') }}" id="phone" name="invitedMember.phone" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Email') }}" id="email" name="invitedMember.email" />
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.meetings.manage', $meetingId) }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>