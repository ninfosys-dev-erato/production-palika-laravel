<?php

namespace Src\Permissions\DTO;

use Src\Permissions\Models\Permission;

class PermissionAdminDto
{
    public function __construct(
        public string $name,
        public string $guard_name
    ) {}

    public static function fromLiveWireModel(Permission $permission): PermissionAdminDto
    {
        return new self(
            name: $permission->name,
            guard_name: $permission->guard_name
        );
    }
}
