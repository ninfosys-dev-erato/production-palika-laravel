<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Models\Participant;

class ParticipantAdminDto
{
   public function __construct(
        public string $meeting_id,
        public string $committee_member_id,
        public string $name,
        public string $designation,
        public string $phone,
        public string $email
    ){}

    public static function fromLiveWireModel(Participant $participant):ParticipantAdminDto{
        return new self(
            meeting_id: $participant->meeting_id,
            committee_member_id: $participant->committee_member_id,
            name: $participant->name,
            designation: $participant->designation,
            phone: $participant->phone,
            email: $participant->email
        );
    }
}