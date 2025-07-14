<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\GrantDetail;

class GrantDetailAdminDto
{
   public function __construct(
        public string $grant_id,
        public string $grant_for,
        public string $model_type,
        public string $model_id,
        public string $personal_investment,
        public string $is_old,
        public string $prev_fiscal_year_id,
        public string $investment_amount,
        public string $remarks,
        public string $local_body_id,
        public string $ward_no,
        public string $village,
        public string $tole,
        public string $plot_no,
        public string $contact_person,
        public string $contact,
        public string $user_id
    ){}

public static function fromLiveWireModel(GrantDetail $grantDetail):GrantDetailAdminDto{
    return new self(
        grant_id: $grantDetail->grant_id,
        grant_for: $grantDetail->grant_for,
        model_type: $grantDetail->model_type,
        model_id: $grantDetail->model_id,
        personal_investment: $grantDetail->personal_investment,
        is_old: $grantDetail->is_old,
        prev_fiscal_year_id: $grantDetail->prev_fiscal_year_id,
        investment_amount: $grantDetail->investment_amount,
        remarks: $grantDetail->remarks,
        local_body_id: $grantDetail->local_body_id,
        ward_no: $grantDetail->ward_no,
        village: $grantDetail->village,
        tole: $grantDetail->tole,
        plot_no: $grantDetail->plot_no,
        contact_person: $grantDetail->contact_person,
        contact: $grantDetail->contact,
        user_id: $grantDetail->user_id
    );
}
}
