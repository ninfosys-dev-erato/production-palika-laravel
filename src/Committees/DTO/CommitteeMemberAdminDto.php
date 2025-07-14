<?php

namespace Src\Committees\DTO;

use Src\Committees\Models\CommitteeMember;

class CommitteeMemberAdminDto
{
   public function __construct(
        public string $committee_id,
        public string $name,
        public string $designation,
        public string $phone,
        public ?string $photo,
        public string $email,
        public string $province_id,
        public string $district_id,
        public string $local_body_id,
        public ?int $ward_no,
        public string $tole,
        public int $position,
    ){}

public static function fromLiveWireModel(CommitteeMember $committeeMember):CommitteeMemberAdminDto{
    return new self(
        committee_id: $committeeMember->committee_id,
        name: $committeeMember->name,
        designation: $committeeMember->designation,
        phone: $committeeMember->phone,
        photo: $committeeMember->photo,
        email: $committeeMember->email,
        province_id: $committeeMember->province_id,
        district_id: $committeeMember->district_id,
        local_body_id: $committeeMember->local_body_id,
        ward_no: $committeeMember->ward_no,
        tole: $committeeMember->tole,
        position: $committeeMember->position,
    );
}
}
