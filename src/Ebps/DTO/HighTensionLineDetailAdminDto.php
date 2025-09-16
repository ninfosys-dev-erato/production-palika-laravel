<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\HighTensionLineDetail;

class HighTensionLineDetailAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $direction,
        public ?string $distance,
        public ?string $minimum
    ){}

public static function fromLiveWireModel(HighTensionLineDetail $highTensionLineDetail):HighTensionLineDetailAdminDto{
    return new self(
        map_apply_id: $highTensionLineDetail->map_apply_id,
        direction: $highTensionLineDetail->direction,
        distance: $highTensionLineDetail->distance,
        minimum: $highTensionLineDetail->minimum
    );
}
public static function fromArray(array $data): self
{
    return new self(
        $data['map_apply_id'] ?? null,
        $data['direction'] ?? null,
        $data['distance'] ?? null,
        $data['minimum'] ?? $data['minimun'] ?? null
    );
}
}
