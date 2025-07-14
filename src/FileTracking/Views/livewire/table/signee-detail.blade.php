<div>
    @if ($row)
        @if ($row->signee_name && $row->signee_name !== 'N/A')
            <strong>{{ __('filetracking::filetracking.name') }}:</strong> {{ $row->signee_name ?? 'N/A' }} <br>
        @endif

        @if ($row->signee_position && $row->signee_position !== 'N/A')
            <strong>{{ __('filetracking::filetracking.position') }}:</strong> {{ $row->signee_position ?? 'N/A' }} <br>
        @endif

        @if ($row->signee_department && $row->signee_department !== 'N/A')
            <strong>{{ __('filetracking::filetracking.department') }}:</strong> <a
                href="tel:{{ $row->signee_department }}">{{ $row->signee_department }}</a> <br>
        @endif
    @else
        {{ 'Anonymous User' }} <br>
    @endif
</div>
