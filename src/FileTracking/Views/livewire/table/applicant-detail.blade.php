<div>
    @if ($row)
        @if ($row->applicant_name && $row->applicant_name !== 'N/A')
            <strong>{{ __('filetracking::filetracking.name') }}:</strong> {{ $row->applicant_name ?? 'N/A' }} <br>
        @endif

        @if ($row->applicant_address && $row->applicant_address !== 'N/A')
            <strong>{{ __('filetracking::filetracking.address') }}:</strong> {{ $row->applicant_address ?? 'N/A' }} <br>
        @endif

        @if ($row->applicant_mobile_no && $row->applicant_mobile_no !== 'N/A')
            <strong>{{ __('filetracking::filetracking.mobile_no') }}:</strong> <a
                href="tel:{{ $row->applicant_mobile_no }}">{{ $row->applicant_mobile_no }}</a> <br>
        @endif
    @else
        {{ 'Anonymous User' }} <br>
    @endif
</div>
