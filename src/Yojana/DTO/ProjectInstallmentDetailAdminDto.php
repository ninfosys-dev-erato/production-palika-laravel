<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ProjectInstallmentDetail;

class ProjectInstallmentDetailAdminDto
{
   public function __construct(
        public string $project_id,
        public string $installment_type,
        public string $date,
        public string $amount,
        public string $construction_material_quantity,
        public string $remarks
    ){}

public static function fromLiveWireModel(ProjectInstallmentDetail $projectInstallmentDetail):ProjectInstallmentDetailAdminDto{
    return new self(
        project_id: $projectInstallmentDetail->project_id,
        installment_type: $projectInstallmentDetail->installment_type,
        date: $projectInstallmentDetail->date,
        amount: $projectInstallmentDetail->amount,
        construction_material_quantity: $projectInstallmentDetail->construction_material_quantity,
        remarks: $projectInstallmentDetail->remarks
    );
}
}
