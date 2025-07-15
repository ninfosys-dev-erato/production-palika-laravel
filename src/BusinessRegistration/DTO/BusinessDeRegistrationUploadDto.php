<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\BusinessDeRegistration;

class BusinessDeRegistrationUploadDto
{
    public function __construct(
        public ?string $bill,
        public ?string $rejected_by,
        public ?string $rejected_at,
        public ?string $application_rejection_reason,
    ) {}

    public static function fromModel(BusinessDeRegistration $businessDeRegistration): self
    {
        return new self(
            bill: $businessDeRegistration->bill,
            rejected_by: $businessDeRegistration->rejected_by,
            rejected_at: $businessDeRegistration->rejected_at,
            application_rejection_reason: $businessDeRegistration->application_rejection_reason,
        );
    }
}
