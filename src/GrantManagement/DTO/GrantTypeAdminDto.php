<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\GrantType;

class GrantTypeAdminDto
{
    public function __construct(
        public string $title,
        public string $title_en,
        public ?string $amount,
        public ?string $department
    ) {}

    public static function fromLiveWireModel(GrantType $grantType): GrantTypeAdminDto
    {
        return new self(
            title: $grantType->title,
            title_en: $grantType->title_en,
            amount: $grantType->amount,
            department: $grantType->department
        );
    }
}
