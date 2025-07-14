<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Affiliation;

class AffiliationAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(Affiliation $affiliation):AffiliationAdminDto{
    return new self(
        title: $affiliation->title,
        title_en: $affiliation->title_en
    );
}
}
