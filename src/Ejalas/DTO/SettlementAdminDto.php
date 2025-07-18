<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\Settlement;

class SettlementAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $discussion_date,
        public string $settlement_date,
        public ?string $present_members,
        public ?string $reconciliation_center_id,
        public string $settlement_details,
        public bool $is_settled
    ) {}

    public static function fromLiveWireModel(Settlement $settlement): SettlementAdminDto
    {
        return new self(
            complaint_registration_id: $settlement->complaint_registration_id,
            discussion_date: $settlement->discussion_date,
            settlement_date: $settlement->settlement_date,
            present_members: $settlement->present_members,
            settlement_details: $settlement->settlement_details,
            reconciliation_center_id: $settlement->reconciliation_center_id,
            is_settled: $settlement->is_settled ?? false
        );
    }
}
