<?php

namespace Src\Users\DTO;

use App\Models\User;

class UserAdminDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $email_verified_at,
        public string $password,
        public string $remember_token,
        public bool $active,
        public string $mobile_no,
        public ?string $signature = null,
    ) {}

    public static function fromLiveWireModel(User $user): UserAdminDto
    {
        return new self(
            name: $user->name ?? '',
            email: $user->email ?? '',
            email_verified_at: $user->email_verified_at ?? '',
            mobile_no: $user->mobile_no ?? '',
            password: $user->password ?: "",
            remember_token: $user->remember_token ?? '',
            active: true,
            signature: $user->signature ?? null,
        );
    }

    public static function fromEmployeeLivewireModel(User $user)
    {
        return new self(
            name: $user->name ?? '',
            email: $user->email ?? '',
            email_verified_at: $user->email_verified_at ?? '',
            mobile_no: $user->mobile_no ?? '',
            password: $user->password ?: "",
            remember_token: $user->remember_token ?? '',
            active: true
        );
    }
}
