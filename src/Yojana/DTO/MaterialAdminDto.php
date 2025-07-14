<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Material;

class MaterialAdminDto
{
   public function __construct(
        public string $material_type_id,
        public string $unit_id,
        public string $title,
        public string $density
    ){}

public static function fromLiveWireModel(Material $material):MaterialAdminDto{
    return new self(
        material_type_id: $material->material_type_id,
        unit_id: $material->unit_id,
        title: $material->title,
        density: $material->density
    );
}
}
