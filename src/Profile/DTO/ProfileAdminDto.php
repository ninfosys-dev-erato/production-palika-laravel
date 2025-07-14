<?php

namespace Src\Profile\DTO;

use App\Models\User;

class ProfileAdminDto
{
   public function __construct(
        public string $name,
        public string $email,
        public string $signature,
    ){}

public static function fromLiveWireModel(User $user): ProfileAdminDto
{
    return new self(
        name: $user->name,
        email: $user->email,
        signature: $user->signature
    );
}
}
