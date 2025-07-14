<div>
    {{
        ($customer->kyc->permanentProvince->title ?? '') ||
        ($customer->kyc->permanentDistrict->title ?? '') ||
        ($customer->kyc->permanentLocalBody->title ?? '') ||
        ($customer->kyc->permanent_ward ?? '') ||
        ($customer->kyc->permanent_tole ?? '')
        ? ($customer->kyc->permanentProvince->title ?? '') . ', ' .
          ($customer->kyc->permanentDistrict->title ?? '') . ', ' .
          ($customer->kyc->permanentLocalBody->title ?? '') . ' - ' .
          ($customer->kyc->permanent_ward ?? '') . ', ' .
          ($customer->kyc->permanent_tole ?? '')
        : ''
    }}
</div>
