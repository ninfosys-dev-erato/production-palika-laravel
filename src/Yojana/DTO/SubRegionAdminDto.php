<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\SubRegion;

class SubRegionAdminDto
{
    public function __construct(
        public string $name,
        public string $code,
        public string $area_id,
        public ?bool $in_use
    ) {}

    public static function fromLiveWireModel(SubRegion $subRegion): SubRegionAdminDto
    {
        return new self(
            name: $subRegion->name,
            code: $subRegion->code,
            area_id: $subRegion->area_id,
            in_use: $subRegion->in_use ?? false
        );
    }
}
