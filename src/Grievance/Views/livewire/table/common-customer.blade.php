<div>
    @if ($row)
        @if ($row->name && $row->name !== 'N/A')
            <strong>{{ __('grievance::grievance.name') }}:</strong> {{ $row->name ?? 'Anonymous User' }} <br>
        @endif

        @if ($row->email && $row->email !== 'N/A')
            <strong>{{ __('grievance::grievance.email') }}:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a> <br>
        @endif

        @if ($row->mobile_no && $row->mobile_no !== 'N/A')
            <strong>{{ __('grievance::grievance.mobile_no') }}:</strong> <a href="tel:{{ $row->mobile_no }}">{{ $row->mobile_no }}</a> <br>
        @endif
    @else
        {{ 'Anonymous User' }} <br>
    @endif
</div>