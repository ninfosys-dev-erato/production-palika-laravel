<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\OrganizationUser;

class OrganizationUserAdminDto
{
   public function __construct(
        public string $name,
        public string $email,
        public string $photo,
        public string $phone,
        public string $password,
        public string $is_active,
        public string $is_organization,
        public string $organizations_id,
        public string $can_work,
        public string $status,
        public string $comment
    ){}

public static function fromLiveWireModel(OrganizationUser $organizationUser):OrganizationUserAdminDto{
    return new self(
        name: $organizationUser->name,
        email: $organizationUser->email,
        photo: $organizationUser->photo,
        phone: $organizationUser->phone,
        password: $organizationUser->password,
        is_active: $organizationUser->is_active,
        is_organization: $organizationUser->is_organization,
        organizations_id: $organizationUser->organizations_id,
        can_work: $organizationUser->can_work,
        status: $organizationUser->status,
        comment: $organizationUser->comment
    );
}
}
