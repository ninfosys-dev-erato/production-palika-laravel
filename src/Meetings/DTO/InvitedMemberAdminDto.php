<?php

namespace Src\Meetings\DTO;

use Src\Meetings\Models\InvitedMember;

class InvitedMemberAdminDto
{
   public function __construct(
        public string $name,
        public string $meeting_id,
        public string $designation,
        public string $phone,
        public string $email
    ){}

    public static function fromLiveWireModel(InvitedMember $invitedMember):InvitedMemberAdminDto{
        return new self(
            name: $invitedMember->name,
            meeting_id: $invitedMember->meeting_id,
            designation: $invitedMember->designation,
            phone: $invitedMember->phone,
            email: $invitedMember->email
        );
    }
}