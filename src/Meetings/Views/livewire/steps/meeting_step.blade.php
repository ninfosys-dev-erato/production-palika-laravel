<div class="row">
    <div class='col-md-6'>
        <x-form.select-input
            label="{{__('Fiscal Year')}}"
            id="fiscal_year_id"
            name="meeting.fiscal_year_id"
            :options="\Src\Settings\Models\FiscalYear::get()->pluck('year', 'id')->toArray()"
            placeholder="{{__('Choose Fiscal Year')}}"
        />
    </div>

    <div class='col-md-6'>
        <x-form.select-input
            label="{{__('Committee')}}"
            id="committee_id"
            name="meeting.committee_id"
            :options="\Src\Yojana\Models\Committee::get()->pluck('committee_name', 'id')->toArray()"
            placeholder="Choose Committee"
        />
    </div>

    <div class='col-md-6'>
        <x-form.text-input
            label="{{__('Meeting')}}"
            id="meeting_name"
            name="meeting.meeting_name"
        />
    </div>

    <div class='col-md-6'>
        <x-form.text-input
            type="date"
            label="{{__('Start Date')}}"
            id="start_date"
            name="meeting.start_date"
        />
    </div>

    <div class='col-md-6'>
        <x-form.text-input
            label="{{__('End Date')}}"
            type="date"
            id="end_date"
            name="meeting.end_date"
        />
    </div>
    <div class='col-md-6'>
        <x-form.select-input
            label="{{__('Recurrence Type')}}"
            id="recurrence"
            name="meeting.recurrence"
            :options="\Src\Meetings\Enums\RecurrenceTypeEnum::getValuesWithLabels()"
            placeholder="Choose Recurrence Type"
        />
    </div>

    <div class='col-md-6'>
        <x-form.text-input
            label="{{__('Recurrence End Date')}}"
            id="recurrence_end_date"
            type="date"
            name="meeting.recurrence_end_date"
        />
    </div>
    <h6 class="mb-1 mt-2">Copy:</h6>
    <div class='col-md-12 d-flex gap-2'>
        <button class="btn btn-secondary btn-sm" data-bs-copiable="meeting_title" type="button">Meeting Title
        </button>
        <button class="btn btn-secondary btn-sm" data-bs-copiable="state_date" type="button">Meeting Start Date
        </button>
        <button class="btn btn-secondary btn-sm" data-bs-copiable="end_date" type="button">Meeting End Date
        </button>
        <button class="btn btn-secondary btn-sm" data-bs-copiable="committee_name" type="button">Committee Name
        </button>
    </div>

    <div class='col-md-12'>
        <x-form.textarea-input
            label="{{__('Message')}}"
            id="description"
            name="meeting.description"
        />
    </div>

</div>
