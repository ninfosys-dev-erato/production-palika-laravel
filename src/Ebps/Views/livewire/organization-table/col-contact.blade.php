<div>
    @if ($row->org_email && $row->org_email !== 'N/A')
        <strong>{{ __('ebps::ebps.email') }}:</strong> {{ $row->org_email }} <br>
    @endif

    @if ($row->org_contact && $row->org_contact !== 'N/A')
        <strong>{{ __('ebps::ebps.phone') }}:</strong> {{ $row->org_contact }} <br>
    @endif

    <!-- Address Slot -->
   
</div>
