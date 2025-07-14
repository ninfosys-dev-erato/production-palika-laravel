<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\CantileverDetail;

class CantileverDetailAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $direction,
        public ?string $distance,
        public ?string $minimum
    ){}

public static function fromLiveWireModel(CantileverDetail $cantileverDetail):CantileverDetailAdminDto{
    return new self(
        map_apply_id: $cantileverDetail->map_apply_id,
        direction: $cantileverDetail->direction,
        distance: $cantileverDetail->distance,
        minimum: $cantileverDetail->minimum
    );
}

public static function fromArray(array $data): self
{
    return new self(
        $data['map_apply_id'],
        $data['direction'],
        $data['distance'],
        $data['minimum']
    );
}
}
