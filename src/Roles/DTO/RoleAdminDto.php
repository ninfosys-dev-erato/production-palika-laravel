<?php

namespace Src\Roles\DTO;

use Src\Roles\Models\Role;

class RoleAdminDto
{
    public function __construct(
        public string $name,
        public string $guard_name
    ) {}

    public static function fromLiveWireModel(Role $role): RoleAdminDto
    {
        return new self(
            name: $role->name,
            guard_name: $role->guard_name
        );
    }
}
