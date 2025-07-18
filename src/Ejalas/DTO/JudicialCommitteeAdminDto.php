<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\JudicialCommittee;

class JudicialCommitteeAdminDto
{
   public function __construct(
        public string $committees_title,
        public string $short_title,
        public string $title,
        public string $subtitle,
        public string $formation_date,
        public string $phone_no,
        public string $email
    ){}

public static function fromLiveWireModel(JudicialCommittee $judicialCommittee):JudicialCommitteeAdminDto{
    return new self(
        committees_title: $judicialCommittee->committees_title,
        short_title: $judicialCommittee->short_title,
        title: $judicialCommittee->title,
        subtitle: $judicialCommittee->subtitle,
        formation_date: $judicialCommittee->formation_date,
        phone_no: $judicialCommittee->phone_no,
        email: $judicialCommittee->email
    );
}
}
