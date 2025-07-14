<div>
    @if ($row->registration?->renew_date && $row->registration?->renew_date !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.renewal_date') }}:</strong>
        {{ $row->registration->renew_date }} <br>
    @endif

    @if ($row->registration?->registration_date && $row->registration?->registration_date !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.registration_date') }}:</strong>
        {{ $row->registration->registration_date }} <br>
    @endif

    @if ($row->registration?->registration_number && $row->registration?->registration_number !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.registration_number') }}:</strong>
        {{ $row->registration->registration_number }} <br>
    @endif

</div>
