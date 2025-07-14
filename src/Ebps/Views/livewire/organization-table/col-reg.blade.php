<div>
    @if ($row->org_registration_no && $row->org_registration_no !== 'N/A')
        <strong>{{ __('ebps::ebps.number') }}:</strong> {{ $row->org_registration_no }} <br>
    @endif

    @if ($row->org_registration_date && $row->org_registration_date !== 'N/A')
        <strong>{{ __('ebps::ebps.date') }}:</strong> {{ $row->org_registration_date }} <br>
    @endif
</div>
