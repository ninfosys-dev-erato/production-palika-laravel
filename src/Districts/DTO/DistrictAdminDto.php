<?php

namespace Src\Districts\DTO;

use Src\Districts\Models\District;

class DistrictAdminDto
{
   public function __construct(
        public string $province_id,
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(District $district):DistrictAdminDto{
    return new self(
        province_id: $district->province_id,
        title: $district->title,
        title_en: $district->title_en
    );
}
}
