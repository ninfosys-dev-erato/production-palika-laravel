<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectGrantDetail;

class ProjectGrantDetailAdminDto
{
   public function __construct(
        public string $project_id,
        public string $grant_source,
        public string $asset_name,
        public string $quantity,
        public string $asset_unit
    ){}

public static function fromLiveWireModel(ProjectGrantDetail $projectGrantDetail):ProjectGrantDetailAdminDto{
    return new self(
        project_id: $projectGrantDetail->project_id,
        grant_source: $projectGrantDetail->grant_source,
        asset_name: $projectGrantDetail->asset_name,
        quantity: $projectGrantDetail->quantity,
        asset_unit: $projectGrantDetail->asset_unit
    );
}
}
