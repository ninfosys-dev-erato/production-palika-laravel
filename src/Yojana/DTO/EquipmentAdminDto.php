<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Equipment;

class EquipmentAdminDto
{
   public function __construct(
        public string $title,
        public string $activity,
        public string $is_used_for_transport,
        public string $capacity,
        public string $speed_with_out_load
    ){}

public static function fromLiveWireModel(Equipment $equipment):EquipmentAdminDto{
    return new self(
        title: $equipment->title,
        activity: $equipment->activity,
        is_used_for_transport: $equipment->is_used_for_transport,
        capacity: $equipment->capacity,
        speed_with_out_load: $equipment->speed_with_out_load
    );
}
}
