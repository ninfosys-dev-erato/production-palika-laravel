<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\JudicialMember;

class JudicialMemberAdminDto
{
    public function __construct(
        public string $title,
        public string $member_position,
        public string $elected_position,
        public ?bool $status
    ) {}

    public static function fromLiveWireModel(JudicialMember $judicialMember): JudicialMemberAdminDto
    {
        return new self(
            title: $judicialMember->title,
            member_position: $judicialMember->member_position->value,
            elected_position: $judicialMember->elected_position->value,
            status: $judicialMember->status ?? false
        );
    }
}
