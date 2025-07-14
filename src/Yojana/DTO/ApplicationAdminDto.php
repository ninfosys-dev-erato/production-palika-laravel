<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Application;

class ApplicationAdminDto
{
    public function __construct(
        public string $applicant_name,
        public string $address,
        public string $mobile_number,
        public string $bank_id,
        public string $account_number,
        public ?bool $is_employee
    ) {}

    public static function fromLiveWireModel(Application $application): ApplicationAdminDto
    {
        return new self(
            applicant_name: $application->applicant_name,
            address: $application->address,
            mobile_number: $application->mobile_number,
            bank_id: $application->bank_id,
            account_number: $application->account_number,
            is_employee: $application->is_employee ?? false
        );
    }
}
