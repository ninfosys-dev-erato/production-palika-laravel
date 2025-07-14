<?php

namespace Src\Profile\DTO;


class ProfilePasswordAdminDto
{
    public function __construct(
        public string $current_password,
        public string $password,
    )
    {
    }

    public static function fromLiveWireModel(array $user): ProfilePasswordAdminDto
    {
        return new self(
            current_password: $user['current_password'],
            password: $user['password'],
        );
    }
}
