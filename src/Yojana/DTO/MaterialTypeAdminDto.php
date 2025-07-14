<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\MaterialType;

class MaterialTypeAdminDto
{
   public function __construct(
        public string $title
    ){}

public static function fromLiveWireModel(MaterialType $materialType):MaterialTypeAdminDto{
    return new self(
        title: $materialType->title
    );
}
}
