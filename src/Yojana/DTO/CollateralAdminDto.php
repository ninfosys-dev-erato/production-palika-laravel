<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Collateral;

class CollateralAdminDto
{
   public function __construct(
        public string $plan_id,
        public string $party_type,
        public string $party_id,
        public string $deposit_type,
        public string $deposit_number,
        public string $contract_number,
        public string $bank,
        public string $issue_date,
        public string $validity_period,
        public string $amount
    ){}

public static function fromLiveWireModel(Collateral $collateral):CollateralAdminDto{
    return new self(
        plan_id: $collateral->plan_id,
        party_type: $collateral->party_type,
        party_id: $collateral->party_id,
        deposit_type: $collateral->deposit_type,
        deposit_number: $collateral->deposit_number,
        contract_number: $collateral->contract_number,
        bank: $collateral->bank,
        issue_date: $collateral->issue_date,
        validity_period: $collateral->validity_period,
        amount: $collateral->amount
    );
}
}
