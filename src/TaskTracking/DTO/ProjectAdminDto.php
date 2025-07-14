<?php

namespace Src\TaskTracking\DTO;

use Src\TaskTracking\Models\Project;

class ProjectAdminDto
{
   public function __construct(
        public string $title,
        public string $description
    ){}

public static function fromLiveWireModel(Project $project):ProjectAdminDto{
    return new self(
        title: $project->title,
        description: $project->description
    );
}
}
