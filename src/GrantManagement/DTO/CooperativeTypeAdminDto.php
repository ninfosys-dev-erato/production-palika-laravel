<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\CooperativeType;

class CooperativeTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(CooperativeType $cooperativeType):CooperativeTypeAdminDto{
    return new self(
        title: $cooperativeType->title,
        title_en: $cooperativeType->title_en
    );
}
}
