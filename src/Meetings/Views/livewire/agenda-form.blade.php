<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <x-form.text-input
                    label="{{__('Proposal')}}"
                    id="proposal"
                    name="agenda.proposal"
                />
            </div>

            <div class='col-md-12'>
                <x-form.textarea-input
                    label="{{__('Description')}}"
                    id="description"
                    name="agenda.description"
                />
            </div>
            <div class='col-md-6'>
                <x-form.radio-input
                    label="{{__('Is Final')}}"
                    id="is_final"
                    name="agenda.is_final"
                    :options="['is_final' => 'Is Final', ]"
                />
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('Save')}}</button>
        <a href="{{route('admin.meetings.manage', $meetingId)}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('Back')}}</a>
    </div>
</form>