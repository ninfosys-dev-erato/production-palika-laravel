<?php

namespace Src\Provinces\DTO;

use Src\Provinces\Models\Province;

class ProvinceAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(Province $province):ProvinceAdminDto{
    return new self(
        title: $province->title,
        title_en: $province->title_en
    );
}
}
