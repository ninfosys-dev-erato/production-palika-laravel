<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\BuildingConstructionType;

class BuildingConstructionTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(BuildingConstructionType $buildingConstructionType):BuildingConstructionTypeAdminDto{
    return new self(
        title: $buildingConstructionType->title
    );
}
}
