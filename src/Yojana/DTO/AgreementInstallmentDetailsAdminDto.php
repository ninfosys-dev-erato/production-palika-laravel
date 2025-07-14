<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Activity;
use Src\Yojana\Models\AgreementInstallmentDetails;

class AgreementInstallmentDetailsAdminDto
{
    public function __construct(
        public int $agreement_id,
        public ?int $installment_number,
        public ?string $release_date,
        public ?int $cash_amount,
        public ?int $goods_amount,
        public ?int $percentage,

    ) {}

    public static function fromLiveWireModel(AgreementInstallmentDetails $agreementInstallmentDetails): AgreementInstallmentDetailsAdminDto
    {
        return new self(
            agreement_id: $agreementInstallmentDetails->agreement_id,
            installment_number: $agreementInstallmentDetails->installment_number,
            release_date: $agreementInstallmentDetails->release_date,
            cash_amount: $agreementInstallmentDetails->cash_amount,
            goods_amount: $agreementInstallmentDetails->goods_amount,
            percentage: $agreementInstallmentDetails->percentage,

        );
    }

    public static function fromArrayData(array $data): AgreementInstallmentDetailsAdminDto
    {
        return new self(
            agreement_id: $data['agreement_id'] ?? null,
            installment_number: $data['installment_number'] ,
            release_date: $data['release_date'] ?? '',
            cash_amount: $data['cash_amount'] ?? 0,
            goods_amount: $data['goods_amount'] ?? 0,
            percentage: $data['percentage'] ?? 0

        );
    }
}
