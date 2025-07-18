<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectAgreementTerm;

class ProjectAgreementTermAdminDto
{
   public function __construct(
        public string $project_id,
        public string $data
    ){}

public static function fromLiveWireModel(ProjectAgreementTerm $projectAgreementTerm):ProjectAgreementTermAdminDto{
    return new self(
        project_id: $projectAgreementTerm->project_id,
        data: $projectAgreementTerm->data
    );
}
}
