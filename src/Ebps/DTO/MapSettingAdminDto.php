<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapSetting;

class MapSettingAdminDto
{
   public function __construct(
        public string $rate_according
    ){}

public static function fromLiveWireModel(MapSetting $mapSetting):MapSettingAdminDto{
    return new self(
        rate_according: $mapSetting->rate_according
    );
}
}
