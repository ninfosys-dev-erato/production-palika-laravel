<div>

    @if ($row->org_name_ne && $row->org_name_ne !== 'N/A')
        <strong>{{ __('ebps::ebps.nepali') }}:</strong> {{ $row->org_name_ne }} <br>
    @endif

    @if ($row->org_name_en && $row->org_name_en !== 'N/A')
        <strong>{{ __('ebps::ebps.english') }}:</strong> {{ $row->org_name_en }} <br>
    @endif

    <div class="address-slot">
        <strong>{{ __('ebps::ebps.address') }}:</strong>
        @php
            $addressParts = [];
            if ($row->province->title ?? false) {
                $addressParts[] = $row->province->title;
            }
            if ($row->district->title ?? false) {
                $addressParts[] = $row->district->title;
            }
            if ($row->localBody->title ?? false) {
                $addressParts[] = $row->localBody->title;
            }
            $address = count($addressParts) ? implode(', ', $addressParts) : '';
            if ($row->ward) {
                $address .= ($address ? ' - ' : '') . $row->ward;
            }
        @endphp
        {{ $address }}
    </div>

</div>
