<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\BuildingRoofType;

class BuildingRoofTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(BuildingRoofType $buildingRoofType):BuildingRoofTypeAdminDto{
    return new self(
        title: $buildingRoofType->title
    );
}
}
