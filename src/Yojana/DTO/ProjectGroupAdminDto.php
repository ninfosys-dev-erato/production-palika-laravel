<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectGroup;

class ProjectGroupAdminDto
{
    public function __construct(
        public string $title,
        public ?string $group_id,
        public string $area_id,
        public string $code
    ) {}

    public static function fromLiveWireModel(ProjectGroup $projectGroup): ProjectGroupAdminDto
    {
        return new self(
            title: $projectGroup->title,
            group_id: $projectGroup->group_id,
            area_id: $projectGroup->area_id,
            code: $projectGroup->code
        );
    }
}
