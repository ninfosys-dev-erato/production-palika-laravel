<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\WrittenResponseRegistration;

class WrittenResponseRegistrationAdminDto
{
    public function __construct(
        public string $response_registration_no,
        public string $complaint_registration_id,
        public string $registration_date,
        public string $fee_amount,
        public string $fee_receipt_no,
        public string $fee_paid_date,
        public string $description,
        public string $claim_request,
        public ?string $submitted_within_deadline,
        public ?string $fee_receipt_attached,
        public string $status,
        public ?string $registration_indicator
    ) {}

    public static function fromLiveWireModel(WrittenResponseRegistration $writtenResponseRegistration): WrittenResponseRegistrationAdminDto
    {
        return new self(
            response_registration_no: $writtenResponseRegistration->response_registration_no,
            complaint_registration_id: $writtenResponseRegistration->complaint_registration_id,
            registration_date: $writtenResponseRegistration->registration_date,
            fee_amount: $writtenResponseRegistration->fee_amount,
            fee_receipt_no: $writtenResponseRegistration->fee_receipt_no,
            fee_paid_date: $writtenResponseRegistration->fee_paid_date,
            description: $writtenResponseRegistration->description,
            claim_request: $writtenResponseRegistration->claim_request,
            submitted_within_deadline: $writtenResponseRegistration->submitted_within_deadline,
            fee_receipt_attached: $writtenResponseRegistration->fee_receipt_attached,
            status: $writtenResponseRegistration->status,
            registration_indicator: $writtenResponseRegistration->registration_indicator,

        );
    }
}
