<?php

namespace Frontend\CustomerPortal\Ebps\DTO;

use Src\Ebps\Models\FourBoundary;

class FourBoundaryDto
{
   public function __construct(
        public string $land_detail_id,
        public string $title,
        public string $direction,
        public int|string|null $distance,
        public int|string|null $lot_no
    ){}

public static function fromLiveWireModel(FourBoundary $fourBoundary):FourBoundaryDto{
    return new self(
        land_detail_id: $fourBoundary->land_detail_id,
        title: $fourBoundary->title,
        direction: $fourBoundary->direction,
        distance: $fourBoundary->distance,
        lot_no: $fourBoundary->lot_no
    );
}
}
