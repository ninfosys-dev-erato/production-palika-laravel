<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapPassGroupMapStep;

class MapPassGroupMapStepAdminDto
{
   public function __construct(
        public string $map_step_id,
        public string $map_pass_group_id,
        public string $type,
        public string $position
    ){}

public static function fromLiveWireModel(MapPassGroupMapStep $mapPassGroupMapStep):MapPassGroupMapStepAdminDto{
    return new self(
        map_step_id: $mapPassGroupMapStep->map_step_id,
        map_pass_group_id: $mapPassGroupMapStep->map_pass_group_id,
        type: $mapPassGroupMapStep->type,
        position: $mapPassGroupMapStep->position
    );
}
}
