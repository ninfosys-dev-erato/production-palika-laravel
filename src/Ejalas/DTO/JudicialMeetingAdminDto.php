<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\JudicialMeeting;

class JudicialMeetingAdminDto
{
    public function __construct(
        public string $fiscal_year_id,
        public string $meeting_date,
        public string $meeting_time,
        public string $meeting_number,
        public string $decision_number,
        public ?string $invited_employee_id,
        public ?string $members_present_id,
        public string $meeting_topic,
        public string $decision_details
    ) {}

    public static function fromLiveWireModel(JudicialMeeting $judicialMeeting): JudicialMeetingAdminDto
    {
        return new self(
            fiscal_year_id: $judicialMeeting->fiscal_year_id,
            meeting_date: $judicialMeeting->meeting_date,
            meeting_time: $judicialMeeting->meeting_time,
            meeting_number: $judicialMeeting->meeting_number,
            decision_number: $judicialMeeting->decision_number,
            invited_employee_id: $judicialMeeting->invited_employee_id,
            members_present_id: $judicialMeeting->members_present_id,
            meeting_topic: $judicialMeeting->meeting_topic,
            decision_details: $judicialMeeting->decision_details
        );
    }
}
