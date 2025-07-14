<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\RegistrationCategory;

class RegistrationCategoryAdminDto
{
    public function __construct(
        public string $title,
        public string $title_ne,
    )
    {
    }

    public static function fromLiveWireModel(RegistrationCategory $category)
    {
        return new self(
            title: $category->title,
            title_ne: $category->title_ne,
        );
    }
}
