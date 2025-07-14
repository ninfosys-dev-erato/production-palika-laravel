<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-4'>
                <x-form.text-input label="{{ __('Chairman') }}" id="chairman" name="decision.chairman" />
            </div>

            <div class='col-md-4'>
                <x-form.nepali-date-input label="{{ __('Date') }}" id="date" name="decision.date" />
            </div>

            <div class='col-md-12'>
                <x-form.ck-editor-input label="{{ __('Description') }}" id="decision_description"
                    name="decision.description" :value="$decision->description ?? ''" />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.meetings.manage', $meetingId) }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
