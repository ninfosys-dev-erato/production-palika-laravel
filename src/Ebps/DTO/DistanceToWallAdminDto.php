<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\DistanceToWall;

class DistanceToWallAdminDto
{
   public function __construct(
        public ?string $map_apply_id,
        public ?string $direction,
        public ?string $has_road,
        public ?string $does_have_wall_door,
        public ?string $dist_left,
        public ?string $min_dist_left
    ){}

public static function fromLiveWireModel(DistanceToWall $distanceToWall):DistanceToWallAdminDto{
    return new self(
        map_apply_id: $distanceToWall->map_apply_id,
        direction: $distanceToWall->direction,
        has_road: $distanceToWall->has_road,
        does_have_wall_door: $distanceToWall->does_have_wall_door,
        dist_left: $distanceToWall->dist_left,
        min_dist_left: $distanceToWall->min_dist_left
    );
}

public static function fromArray(array $data): self
{
    
    return new self(
        $data['map_apply_id'],
        $data['direction'],
        $data['has_road'],
        $data['does_have_wall_door'],
        $data['dist_left'],
        $data['min_dist_left'],
    );
}
}
