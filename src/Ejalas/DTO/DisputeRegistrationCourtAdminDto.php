<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\DisputeRegistrationCourt;

class DisputeRegistrationCourtAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $registrar_id,
        public string $status,
        public ?bool $is_details_provided,
        public string $decision_date,
        public ?string $registration_indicator,
    ) {}

    public static function fromLiveWireModel(DisputeRegistrationCourt $disputeRegistrationCourt): DisputeRegistrationCourtAdminDto
    {
        return new self(
            complaint_registration_id: $disputeRegistrationCourt->complaint_registration_id,
            registrar_id: $disputeRegistrationCourt->registrar_id,
            status: $disputeRegistrationCourt->status,
            is_details_provided: $disputeRegistrationCourt->is_details_provided ?? false,
            decision_date: $disputeRegistrationCourt->decision_date,
            registration_indicator: $disputeRegistrationCourt->registration_indicator,
        );
    }
}
