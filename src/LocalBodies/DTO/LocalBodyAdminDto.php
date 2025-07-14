<?php

namespace Src\LocalBodies\DTO;

use Src\LocalBodies\Models\LocalBody;

class LocalBodyAdminDto
{
   public function __construct(
        public string $district_id,
        public string $title,
        public string $title_en,
        public string $wards
    ){}

public static function fromLiveWireModel(LocalBody $localBody):LocalBodyAdminDto{
    return new self(
        district_id: $localBody->district_id,
        title: $localBody->title,
        title_en: $localBody->title_en,
        wards: $localBody->wards
    );
}
}
