<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\DisputeMatter;

class DisputeMatterAdminDto
{
   public function __construct(
        public string $title,
        public string $dispute_area_id
    ){}

public static function fromLiveWireModel(DisputeMatter $disputeMatter):DisputeMatterAdminDto{
    return new self(
        title: $disputeMatter->title,
        dispute_area_id: $disputeMatter->dispute_area_id
    );
}
}
