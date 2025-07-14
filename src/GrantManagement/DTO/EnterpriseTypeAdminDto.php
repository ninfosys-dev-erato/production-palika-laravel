<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\EnterpriseType;

class EnterpriseTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(EnterpriseType $enterpriseType):EnterpriseTypeAdminDto{
    return new self(
        title: $enterpriseType->title,
        title_en: $enterpriseType->title_en
    );
}
}
