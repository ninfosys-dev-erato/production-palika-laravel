<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\ComplaintRegistration;

class ComplaintRegistrationAdminDto
{
    public function __construct(
        public string $fiscal_year_id,
        public string $reg_no,
        public ?string $old_reg_no,
        public string $reg_date,
        public string $reg_address,
        public ?string $complainer_id,
        public ?string $defender_id,
        public string $priority_id,
        public string $dispute_matter_id,
        public string $subject,
        public string $description,
        public string $claim_request,
        public ?string $reconciliation_center_id,
        public ?bool $status,
        public ?string $reconciliation_reg_no,
        public ?string $ward_no

    ) {}

    public static function fromLiveWireModel(ComplaintRegistration $complaintRegistration): ComplaintRegistrationAdminDto
    {
        return new self(
            fiscal_year_id: $complaintRegistration->fiscal_year_id,
            reg_no: $complaintRegistration->reg_no,
            old_reg_no: $complaintRegistration->old_reg_no,
            reg_date: $complaintRegistration->reg_date,
            reg_address: $complaintRegistration->reg_address->value,
            complainer_id: $complaintRegistration->complainer_id,
            defender_id: $complaintRegistration->defender_id,
            priority_id: $complaintRegistration->priority_id,
            dispute_matter_id: $complaintRegistration->dispute_matter_id,
            subject: $complaintRegistration->subject,
            description: $complaintRegistration->description,
            claim_request: $complaintRegistration->claim_request,
            status: $complaintRegistration->status,
            reconciliation_center_id: $complaintRegistration->reconciliation_center_id,
            reconciliation_reg_no: $complaintRegistration->reconciliation_reg_no,
            ward_no: $complaintRegistration->ward_no,
        );
    }
}
