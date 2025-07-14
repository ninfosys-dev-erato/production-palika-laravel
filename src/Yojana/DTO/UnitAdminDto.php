<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Unit;

class UnitAdminDto
{
   public function __construct(
        public string $symbol,
        public string $title,
        public string $title_ne,
        public string $type_id,
        public bool $will_be_in_use
    ){}

public static function fromLiveWireModel(Unit $unit):UnitAdminDto{
    return new self(
        symbol: $unit->symbol,
        title: $unit->title,
        title_ne: $unit->title_ne,
        type_id: $unit->type_id,
        will_be_in_use: $unit->will_be_in_use ?? false
    );
}
}
