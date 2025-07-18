<?php

namespace Src\Customers\DTO;

use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Models\CustomerKyc;

class CustomerKycDto
{
    public function __construct(
        public readonly ?KycStatusEnum $status,
        public readonly ?array $reason_to_reject, 
    ) {}

    public static function buildFromValidatedRequest(CustomerKyc $customerKyc, array $reason_to_reject): CustomerKycDto
    {
        return new self(
            status: $customerKyc->status ?? null,
            reason_to_reject: $customerKyc->status->value === 'rejected' ? $reason_to_reject : null, 
        );
    }
}
