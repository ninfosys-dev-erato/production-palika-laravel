<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\UnitType;

class UnitTypeAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en,
        public string $display_order,
        public ?bool $will_be_in_use
    ){}

public static function fromLiveWireModel(UnitType $unitType):UnitTypeAdminDto{
    return new self(
        title: $unitType->title,
        title_en: $unitType->title_en,
        display_order: $unitType->display_order,
        will_be_in_use: $unitType->will_be_in_use??false
    );
}
}
