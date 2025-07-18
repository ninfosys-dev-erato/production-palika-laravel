<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectDeadlineExtension;

class ProjectDeadlineExtensionAdminDto
{
   public function __construct(
        public string $project_id,
        public string $extended_date,
        public string $en_extended_date,
        public string $submitted_date,
        public string $en_submitted_date,
        public string $remarks
    ){}

public static function fromLiveWireModel(ProjectDeadlineExtension $projectDeadlineExtension):ProjectDeadlineExtensionAdminDto{
    return new self(
        project_id: $projectDeadlineExtension->project_id,
        extended_date: $projectDeadlineExtension->extended_date,
        en_extended_date: $projectDeadlineExtension->en_extended_date,
        submitted_date: $projectDeadlineExtension->submitted_date,
        en_submitted_date: $projectDeadlineExtension->en_submitted_date,
        remarks: $projectDeadlineExtension->remarks
    );
}
}
