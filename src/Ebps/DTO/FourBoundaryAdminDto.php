<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\FourBoundary;

class FourBoundaryAdminDto
{
   public function __construct(
        public string $land_detail_id,
        public string $title,
        public string $direction,
        public int|string|null $distance,
        public int|string|null $lot_no
    ){}

    public static function fromLiveWireModel(FourBoundary $fourBoundary):FourBoundaryAdminDto{
        return new self(
            land_detail_id: $fourBoundary->land_detail_id,
            title: $fourBoundary->title,
            direction: $fourBoundary->direction,
            distance: $fourBoundary->distance,
            lot_no: $fourBoundary->lot_no
        );
    }
    public static function fromArray(array $data): FourBoundaryAdminDto
    {
        
        return new self(
            land_detail_id: (string) ($data['land_detail_id'] ?? ''),
            title: $data['title'] ?? '',
            direction: $data['direction'] ?? '',
            distance: (string) ($data['distance'] ?? '0'),
            lot_no: (string) ($data['lot_no'] ?? '0')
        );
    }


}
