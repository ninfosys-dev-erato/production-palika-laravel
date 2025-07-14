<div>

    @if ($row->registration?->province || ($row->registration?->ward_no && $row->registration?->province !== 'N/A'))
        <strong>{{ __('businessregistration::businessregistration.province') }}:</strong>
        {{ $row->registration?->province->title }} - {{ $row->registration?->ward_no }} <br>
    @endif

    @if ($row->registration?->local_body_id && $row->registration?->local_body_id !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.local_body') }}:</strong>
        {{ $row->registration?->localBody->title }} <br>
    @endif

    @if ($row->registration?->district_id && $row->registration?->district_id !== 'N/A')
        <strong>{{ __('businessregistration::businessregistration.district') }}:</strong>
        {{ $row->registration?->district->title }} <br>
    @endif


</div>
