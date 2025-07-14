<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\Road;

class RoadAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $direction,
        public ?string $width,
        public ?string $dist_from_middle,
        public ?string $min_dist_from_middle,
        public ?string $dist_from_side,
        public ?string $min_dist_from_side,
        public ?string $dist_from_right,
        public ?string $min_dist_from_right,
        public ?string $setback,
        public ?string $min_setback
    ){}

public static function fromLiveWireModel(Road $road):RoadAdminDto{
    return new self(
        map_apply_id: $road->map_apply_id,
        direction: $road->direction,
        width: $road->width,
        dist_from_middle: $road->dist_from_middle,
        min_dist_from_middle: $road->min_dist_from_middle,
        dist_from_side: $road->dist_from_side,
        min_dist_from_side: $road->min_dist_from_side,
        dist_from_right: $road->dist_from_right,
        min_dist_from_right: $road->min_dist_from_right,
        setback: $road->setback,
        min_setback: $road->min_setback
    );
}

public static function fromArray(array $data): self
{
    return new self(
        $data['map_apply_id'],
        $data['direction'],
        $data['width'],
        $data['dist_from_middle'],
        $data['min_dist_from_middle'],
        $data['dist_from_side'],
        $data['min_dist_from_side'],
        $data['dist_from_right'],
        $data['min_dist_from_right'],
        $data['setback'],
        $data['min_setback'],
    );
}
}
