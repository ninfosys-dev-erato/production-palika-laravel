<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\StructureType;

class StructureTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(StructureType $structureType):StructureTypeAdminDto{
    return new self(
        title: $structureType->title
    );
}
}
