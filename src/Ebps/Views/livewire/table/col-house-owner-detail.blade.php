<div>
    @php
        $houseOwnerDetail = Src\Ebps\Models\HouseOwnerDetail::where('id', $row->house_owner_id)
            ->with('localBody')
            ->first();
            
    @endphp
    <strong>{{ __('ebps::ebps.name') }}:</strong> {{ $houseOwnerDetail->owner_name ?? 'N/A' }}</a> <br>
    @if ($houseOwnerDetail?->mobile_no && $houseOwnerDetail?->mobile_no !== 'N/A')
        <strong>{{ __('ebps::ebps.mobile_no') }}:</strong> <a
            href="tel:{{ $houseOwnerDetail->mobile_no }}">{{ $houseOwnerDetail->mobile_no }}</a>
        <br>
    @endif

    @if ($houseOwnerDetail?->province_id && $houseOwnerDetail?->ward_no)
        <strong>{{ __('ebps::ebps.address') }}:</strong>
        {{ "{$houseOwnerDetail->localBody?->title}-{$houseOwnerDetail->ward_no}" }} <br>
    @endif
</div>
