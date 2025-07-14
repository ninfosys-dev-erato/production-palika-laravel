<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\MeasurementUnit;

class MeasurementUnitAdminDto
{
   public function __construct(
        public string $type_id,
        public string $title
    ){}

public static function fromLiveWireModel(MeasurementUnit $measurementUnit):MeasurementUnitAdminDto{
    return new self(
        type_id: $measurementUnit->type_id,
        title: $measurementUnit->title
    );
}
}
