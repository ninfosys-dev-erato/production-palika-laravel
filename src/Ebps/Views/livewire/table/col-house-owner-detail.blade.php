<div>
    <strong>{{ __('ebps::ebps.name') }}:</strong> {{ $row->full_name ?? 'N/A' }}</a> <br>
    @if ($row->mobile_no && $row->mobile_no !== 'N/A')
        <strong>{{ __('ebps::ebps.mobile_no') }}:</strong> <a href="tel:{{ $row->mobile_no }}">{{ $row->mobile_no }}</a> <br>
    @endif

    @if ($row->province_id && $row->ward_no)
        <strong>{{ __('ebps::ebps.address') }}:</strong> {{ "{$row->localBody?->title}-{$row->ward_no}" }} <br>
    @endif
</div>
