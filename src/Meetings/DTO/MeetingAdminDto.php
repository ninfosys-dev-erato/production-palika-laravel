<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Enums\RecurrenceTypeEnum;
use Src\Meetings\Models\Meeting;

class MeetingAdminDto
{
    public function __construct(
        public int    $fiscal_year_id,
        public int    $committee_id,
        public string $meeting_name,
        public string|RecurrenceTypeEnum $recurrence,
        public string $start_date,
        public string $end_date,
        public string $en_start_date,
        public string $en_end_date,
        public string $recurrence_end_date,
        public string $en_recurrence_end_date,
        public string $description,
        public ?array $agendas,
        public ?array $invitedMembers,
    )
    {
    }

    public static function fromLiveWireModel(Meeting $meeting): MeetingAdminDto
    {
        return new self(
            fiscal_year_id: $meeting->fiscal_year_id,
            committee_id: $meeting->committee_id,
            meeting_name: $meeting->meeting_name,
            recurrence: $meeting->recurrence,
            start_date: $meeting->start_date,
            en_start_date: $meeting->en_start_date,
            end_date: $meeting->end_date,
            en_end_date: $meeting->en_end_date,
            recurrence_end_date: $meeting->recurrence_end_date,
            en_recurrence_end_date: $meeting->en_recurrence_end_date,
            description: $meeting->description,
            agendas: $meeting->agendas?->toArray(),
            invitedMembers: $meeting->invitedMembers?->toArray(),
        );
    }

    public static function fromLiveWireArray(array $meeting): MeetingAdminDto
    {
        return new self(
            fiscal_year_id: $meeting['fiscal_year_id'],
            committee_id: $meeting['committee_id'],
            meeting_name: $meeting['meeting_name'],
            recurrence: $meeting['recurrence'],
            start_date: $meeting['start_date'],
            en_start_date: $meeting['en_start_date'],
            end_date: $meeting['end_date'],
            en_end_date: $meeting['en_end_date'],
            recurrence_end_date: $meeting['recurrence_end_date'],
            en_recurrence_end_date: $meeting['en_recurrence_end_date'],
            description: $meeting['description'],
            agendas: $meeting['agendas'] ?? [],
            invitedMembers: $meeting['invitedMembers'] ?? [],
        );
    }
}
