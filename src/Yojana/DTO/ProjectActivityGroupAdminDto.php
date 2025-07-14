<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectActivityGroup;

class ProjectActivityGroupAdminDto
{
    public function __construct(
        public string $title,
        public string $code,
        public ?string $group_id,
        public ?string $norms_type
    ) {}

    public static function fromLiveWireModel(ProjectActivityGroup $projectActivityGroup): ProjectActivityGroupAdminDto
    {
        return new self(
            title: $projectActivityGroup->title,
            code: $projectActivityGroup->code,
            group_id: $projectActivityGroup->group_id,
            norms_type: $projectActivityGroup->norms_type
        );
    }
}
