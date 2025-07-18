<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Agreement;

class AgreementAdminDto
{
   public function __construct(
        public string $plan_id,
        public string $consumer_committee_id,
        public string $implementation_method_id,
        public string $plan_start_date,
        public string $plan_completion_date,
        public string $experience,
        public string $deposit_number
    ){}

public static function fromLiveWireModel(Agreement $agreement):AgreementAdminDto{
    return new self(
        plan_id: $agreement->plan_id,
        consumer_committee_id: $agreement->consumer_committee_id,
        implementation_method_id: $agreement->implementation_method_id,
        plan_start_date: $agreement->plan_start_date,
        plan_completion_date: $agreement->plan_completion_date,
        experience: $agreement->experience,
        deposit_number: $agreement->deposit_number
    );
}
}
