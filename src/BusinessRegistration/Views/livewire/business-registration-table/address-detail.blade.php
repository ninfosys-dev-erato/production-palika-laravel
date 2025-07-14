<div>

    @if ($row->province || ($row->ward_no && $row->province !== 'N/A'))
        <strong>{{ __('businessregistration::businessregistration.province') }}:</strong> {{ $row->province->title }} - {{ $row->ward_no }} <br>
    @endif

    @if ($row->local_body_id && $row->local_body_id !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.local_body') }}:</strong> {{ $row->localBody->title }} <br>
    @endif

    @if ($row->district_id && $row->district_id !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.district') }}:</strong> {{ $row->district->title }} <br>
    @endif


</div>
