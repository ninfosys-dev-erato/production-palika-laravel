<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\StoreyDetail;

class StoreyDetailAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $storey_id,
        public ?string $purposed_area,
        public ?string $former_area,
        public ?string $height,
        public ?string $remarks
    ){}

public static function fromLiveWireModel(StoreyDetail $storeyDetail):StoreyDetailAdminDto{
    return new self(
        map_apply_id: $storeyDetail->map_apply_id,
        storey_id: $storeyDetail->storey_id,
        purposed_area: $storeyDetail->purposed_area,
        former_area: $storeyDetail->former_area,
        height: $storeyDetail->height,
        remarks: $storeyDetail->remarks
    );
}

public static function fromArray(array $data): self
{
    return new self(
        $data['map_apply_id'],
        $data['storey_id'],
        $data['purposed_area'],
        $data['former_area'],
        $data['height'],
        $data['remarks'],
    );
}
}
