<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\DisputeDeadline;

class DisputeDeadlineAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public string $registrar_id,
        public string $deadline_set_date,
        public string $deadline_extension_period
    ) {}

    public static function fromLiveWireModel(DisputeDeadline $disputeDeadline): DisputeDeadlineAdminDto
    {
        return new self(
            complaint_registration_id: $disputeDeadline->complaint_registration_id,
            registrar_id: $disputeDeadline->registrar_id,
            deadline_set_date: $disputeDeadline->deadline_set_date,
            deadline_extension_period: $disputeDeadline->deadline_extension_period
        );
    }
}
