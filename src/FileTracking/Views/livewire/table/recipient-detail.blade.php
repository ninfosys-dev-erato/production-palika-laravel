<div>
    @if ($row)
        @if ($row->recipient_name && $row->recipient_name !== 'N/A')
            <strong>{{ __('filetracking::filetracking.name') }}:</strong> {{ $row->recipient_name ?? 'N/A' }} <br>
        @endif

        @if ($row->recipient_position && $row->recipient_position !== 'N/A')
            <strong>{{ __('filetracking::filetracking.position') }}:</strong> {{ $row->recipient_position ?? 'N/A' }} <br>
        @endif

        @if ($row->recipient_department && $row->recipient_department !== 'N/A')
            <strong>{{ __('filetracking::filetracking.department') }}:</strong> <a
                href="tel:{{ $row->recipient_department }}">{{ $row->recipient_department }}</a> <br>
        @endif
    @else
        {{ 'Anonymous User' }} <br>
    @endif
</div>
