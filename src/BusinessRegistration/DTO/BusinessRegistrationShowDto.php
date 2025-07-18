<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\BusinessRegistration;

class BusinessRegistrationShowDto
{
    public function __construct(
        public ?string $bill,
        public ?string $rejected_by,
        public ?string $rejected_at,
        public ?string $application_rejection_reason,
    )
    {
    }

    public static function fromModel(BusinessRegistration $businessRegistration): self
    {
        return new self(
            bill: $businessRegistration->bill,
            rejected_by: $businessRegistration->rejected_by,
            rejected_at: $businessRegistration->rejected_at,
            application_rejection_reason: $businessRegistration->application_rejection_reason,
        );
    }
}
