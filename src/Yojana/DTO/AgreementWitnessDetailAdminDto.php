<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementWitnessDetail;

class AgreementWitnessDetailAdminDto
{
    public function __construct(
        public string $agreement_id,
        public ?string $employee_id,
    ){
    }

    public static function fromModel(AgreementWitnessDetail $model): AgreementWitnessDetailAdminDto
    {
        return new self(
            agreement_id: $model->agreement_id,
            employee_id: $model->employee_id,
        );
    }

    public static function fromArrayData(array $data): AgreementWitnessDetailAdminDto
    {
        return new self(
            agreement_id: $data['agreement_id'] ?? null,
            employee_id: $data['employee_id'] ?? null,
        );
    }
}
