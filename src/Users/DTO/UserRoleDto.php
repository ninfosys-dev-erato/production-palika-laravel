<?php

namespace Src\Users\DTO;

class UserRoleDto
{
    public function __construct(public int $role_id) {}

    public static function fromInputs(array $selected_roles): array
    {
        return array_map(fn($role_id) => new self($role_id), $selected_roles);
    }
}
