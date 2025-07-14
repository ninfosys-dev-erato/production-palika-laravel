<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementGrant;

class AgreementGrantAdminDto
{
   public function __construct(
        public string $agreement_id,
        public string $source_type_id,
        public string $material_name,
        public string $unit,
        public string $amount
    ){}

public static function fromLiveWireModel(AgreementGrant $agreementGrant):AgreementGrantAdminDto{
    return new self(
        agreement_id: $agreementGrant->agreement_id,
        source_type_id: $agreementGrant->source_type_id,
        material_name: $agreementGrant->material_name,
        unit: $agreementGrant->unit,
        amount: $agreementGrant->amount
    );
}

    public static function fromArrayData(array $data): self
    {
        return new self(
            agreement_id: $data['agreement_id'] ?? null,
            source_type_id: $data['source_type_id'],
            material_name: $data['material_name'],
            unit: $data['unit'],
            amount: $data['amount']
        );
    }


}
