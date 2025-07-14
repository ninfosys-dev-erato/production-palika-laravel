<?php

namespace Src\Users\DTO;

class UserWardDto
{
    public function __construct(
        public int $local_body_id,
        public int $ward
    ) {}

    public static function fromInputs(int $local_body_id, array $selected_wards): array
    {
        return array_map(function ($ward) use ($local_body_id) {
            return new self(local_body_id: $local_body_id, ward: $ward);
        }, $selected_wards);
    }
}
