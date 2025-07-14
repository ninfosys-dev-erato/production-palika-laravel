<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='form-group'>
                <x-form.ck-editor-input label="{{ __('Minute') }}" id="minute_description" name="minute.description"
                    :value="$minute?->description ?? ''" />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.meetings.manage', $meetingId) }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>