<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\ConstructionType;

class ConstructionTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(ConstructionType $constructionType):ConstructionTypeAdminDto{
    return new self(
        title: $constructionType->title
    );
}
}
