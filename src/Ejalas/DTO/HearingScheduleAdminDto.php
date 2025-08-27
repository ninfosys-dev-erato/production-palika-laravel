<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\HearingSchedule;

class HearingScheduleAdminDto
{
    public function __construct(
        public string $hearing_paper_no,
        public string $fiscal_year_id,
        public string $complaint_registration_id,
        public string $hearing_date,
        public string $hearing_time,
        public ?string $reference_no,
        public string $reconciliation_center_id
    ) {}

    public static function fromLiveWireModel(HearingSchedule $hearingSchedule): HearingScheduleAdminDto
    {
        return new self(
            hearing_paper_no: $hearingSchedule->hearing_paper_no,
            fiscal_year_id: $hearingSchedule->fiscal_year_id,
            hearing_date: $hearingSchedule->hearing_date,
            hearing_time: $hearingSchedule->hearing_time,
            reference_no: $hearingSchedule->reference_no,
            reconciliation_center_id: $hearingSchedule->reconciliation_center_id->value,
            complaint_registration_id: $hearingSchedule->complaint_registration_id,

        );
    }
}
