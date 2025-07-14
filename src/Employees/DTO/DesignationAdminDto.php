<?php

namespace Src\Employees\DTO;

use Src\Employees\Models\Designation;

class DesignationAdminDto
{
    public function __construct(
        public string $title,
        public string $title_en,
    ){}

    public static function fromLiveWireModel(Designation $designation):DesignationAdminDto{
        return new self(
            title: $designation->title,
            title_en: $designation->title_en,
        );
    }
}
