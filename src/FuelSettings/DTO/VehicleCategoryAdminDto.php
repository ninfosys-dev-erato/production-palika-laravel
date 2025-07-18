<?php

namespace Src\FuelSettings\DTO;

use Src\FuelSettings\Models\VehicleCategory;

class VehicleCategoryAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en
    ){}

public static function fromLiveWireModel(VehicleCategory $vehicleCategory):VehicleCategoryAdminDto{
    return new self(
        title: $vehicleCategory->title,
        title_en: $vehicleCategory->title_en
    );
}
}
