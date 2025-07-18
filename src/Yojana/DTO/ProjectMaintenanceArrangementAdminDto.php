<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectMaintenanceArrangement;

class ProjectMaintenanceArrangementAdminDto
{
   public function __construct(
        public string $project_id,
        public string $office_name,
        public string $public_service,
        public string $service_fee,
        public string $from_fee_donation,
        public string $others
    ){}

public static function fromLiveWireModel(ProjectMaintenanceArrangement $projectMaintenanceArrangement):ProjectMaintenanceArrangementAdminDto{
    return new self(
        project_id: $projectMaintenanceArrangement->project_id,
        office_name: $projectMaintenanceArrangement->office_name,
        public_service: $projectMaintenanceArrangement->public_service,
        service_fee: $projectMaintenanceArrangement->service_fee,
        from_fee_donation: $projectMaintenanceArrangement->from_fee_donation,
        others: $projectMaintenanceArrangement->others
    );
}
}
