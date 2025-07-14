<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\SettlementDetail;

class SettlementDetailAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $party_id,
        public string $deadline_set_date,
        public string $detail,
    ) {}


    public static function fromLiveWireModel(SettlementDetail $settlementDetail): SettlementDetailAdminDto
    {
        return new self(
            complaint_registration_id: $settlementDetail->complaint_registration_id,
            party_id: $settlementDetail->party_id,
            deadline_set_date: $settlementDetail->deadline_set_date,
            detail: $settlementDetail->detail,
        );
    }
}
