<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementCost;

class AgreementCostAdminDto
{
   public function __construct(
        public string $agreement_id,
        public string $total_amount,
        public string $total_vat_amount,
        public string $total_with_vat,
    ){}

public static function fromLiveWireModel(AgreementCost $agreementCost):AgreementCostAdminDto{
    return new self(
        agreement_id: $agreementCost->agreement_id,
        total_amount: $agreementCost->total_amount ?? 0,
        total_vat_amount: $agreementCost->total_vat_amount ?? 0,
        total_with_vat: $agreementCost->total_with_vat ?? 0,
    );
}
}
