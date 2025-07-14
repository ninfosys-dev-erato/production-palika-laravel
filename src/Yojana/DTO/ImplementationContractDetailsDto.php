<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ImplementationContractDetails;

class ImplementationContractDetailsDto
{
    public function __construct(
        public string $implementation_agency_id,
        public string $contract_number,
        public string $notice_date,
        public string $bid_acceptance_date,
        public string $bid_amount,
        public string $deposit_amount,
    ) {}

    public static function fromLiveWireModel(ImplementationContractDetails $implementationContractDetails): ImplementationContractDetailsDto
    {
        return new self(
            implementation_agency_id: $implementationContractDetails->implementation_agency_id,
            contract_number: $implementationContractDetails->contract_number,
            notice_date: $implementationContractDetails->notice_date,
            bid_acceptance_date: $implementationContractDetails->bid_acceptance_date,
            bid_amount: $implementationContractDetails->bid_amount,
            deposit_amount: $implementationContractDetails->deposit_amount,
        );
    }

    public static function fromArrayData(array $data): ImplementationContractDetailsDto
    {
        return new self(
            implementation_agency_id: $data['implementation_agency_id'],
            contract_number: $data['contract_number'],
            notice_date: $data['notice_date'],
            bid_acceptance_date: $data['bid_acceptance_date'],
            bid_amount: $data['bid_amount'],
            deposit_amount: $data['deposit_amount'],
        );
    }
}
