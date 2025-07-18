<div>

    @if ($row->entity_name && $row->entity_name !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.entity_name') }}:</strong> {{ $row->entity_name }}
        <br>
    @endif

    @if ($row->application_date && $row->application_date !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.application_date') }}:</strong>
        {{ $row->application_date }} <br>
    @endif

    @if ($row->registration_date && $row->registration_date !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.registration_date') }}:</strong>
        {{ $row->registration_date }} <br>
    @endif

    @if ($row->registration_number && $row->registration_number !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.registration_number') }}:</strong>
        {{ replaceNumbers($row->registration_number, true) }} <br>
    @endif
</div>
