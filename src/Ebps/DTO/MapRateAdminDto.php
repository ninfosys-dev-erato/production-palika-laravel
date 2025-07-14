<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapRate;

class MapRateAdminDto
{
   public function __construct(
        public string $rateable_type,
        public string $rateable_id,
        public string $rate
    ){}

public static function fromLiveWireModel(MapRate $mapRate):MapRateAdminDto{
    return new self(
        rateable_type: $mapRate->rateable_type,
        rateable_id: $mapRate->rateable_id,
        rate: $mapRate->rate
    );
}
}
