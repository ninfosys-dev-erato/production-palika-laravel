<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\Priotity;

class PriotityAdminDto
{
   public function __construct(
        public string $name,
        public string $position
    ){}

public static function fromLiveWireModel(Priotity $priotity):PriotityAdminDto{
    return new self(
        name: $priotity->name,
        position: $priotity->position
    );
}
}
