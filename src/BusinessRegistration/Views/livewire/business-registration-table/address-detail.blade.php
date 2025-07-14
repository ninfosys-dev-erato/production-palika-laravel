<div>

    @if ($row->businessProvince || ($row->business_ward && $row->businessProvince !== 'N/A'))
        <strong>{{ __('businessregistration::businessregistration.province') }}:</strong>
        {{ $row->businessProvince?->title }} - {{ $row->business_ward }} <br>
    @endif

    @if ($row->business_local_body && $row->business_local_body !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.local_body') }}:</strong>
        {{ $row->businessLocalBody?->title }} <br>
    @endif

    @if ($row->business_district && $row->business_district !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.district') }}:</strong>
        {{ $row->businessDistrict?->title }} <br>
    @endif



</div>
