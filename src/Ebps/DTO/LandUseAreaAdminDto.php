<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\LandUseArea;

class LandUseAreaAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(LandUseArea $landUseArea):LandUseAreaAdminDto{
    return new self(
        title: $landUseArea->title
    );
}
}
