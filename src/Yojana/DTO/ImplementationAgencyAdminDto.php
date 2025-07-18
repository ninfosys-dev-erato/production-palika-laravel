<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ImplementationAgency;

class ImplementationAgencyAdminDto
{
    public function __construct(
        public string $plan_id,
        public ?string $consumer_committee_id,
        public ?string $organization_id,
        public ?string $application_id,
        public string $model,
        public ?string $comment,
        public string $agreement_application,
        public string $agreement_recommendation_letter,
        public string $deposit_voucher
    ) {}

    public static function fromLiveWireModel(ImplementationAgency $implementationAgency): ImplementationAgencyAdminDto
    {
        return new self(
            plan_id: $implementationAgency->plan_id,
            consumer_committee_id: $implementationAgency->consumer_committee_id,
            organization_id: $implementationAgency->organization_id,
            application_id: $implementationAgency->application_id,
            model: $implementationAgency->model,
            comment: $implementationAgency->comment,
            agreement_application: $implementationAgency->agreement_application ?? '',
            agreement_recommendation_letter: $implementationAgency->agreement_recommendation_letter ?? '',
            deposit_voucher: $implementationAgency->deposit_voucher ?? ''
        );
    }
}
