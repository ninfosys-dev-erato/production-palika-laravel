<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementBeneficiary;

class AgreementBeneficiaryAdminDto
{
   public function __construct(
        public string $agreement_id,
        public string $beneficiary_id,
        public string $total_count,
        public string $men_count,
        public string $women_count
    ){}

public static function fromLiveWireModel(AgreementBeneficiary $agreementBeneficiary):AgreementBeneficiaryAdminDto{
    return new self(
        agreement_id: $agreementBeneficiary->agreement_id,
        beneficiary_id: $agreementBeneficiary->beneficiary_id,
        total_count: $agreementBeneficiary->total_count,
        men_count: $agreementBeneficiary->men_count,
        women_count: $agreementBeneficiary->women_count
    );
}

    public static function fromArrayData(array $data): AgreementBeneficiaryAdminDto
    {
        return new self(
            agreement_id: $data['agreement_id'] ?? null,
            beneficiary_id: $data['beneficiary_id'] ?? null,
            total_count: $data['total_count'] ?? 0,
            men_count: $data['men_count'] ?? 0,
            women_count: $data['women_count'] ?? 0
        );
    }

}
