<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ImplementationQuotation;

class ImplementationQuotationAdminDto
{
    public function __construct(
        public string $implementation_agency_id,
        public string $name,
        public string $address,
        public string $amount,
        public string $date,
        public string $percentage,
    ) {}

    public static function fromLiveWireModel(ImplementationQuotation $implementationQuotation): ImplementationQuotationAdminDto
    {
        return new self(
            implementation_agency_id: $implementationQuotation->implementation_agency_id,
            name: $implementationQuotation->name,
            address: $implementationQuotation->address,
            amount: $implementationQuotation->amount,
            date: $implementationQuotation->date,
            percentage: $implementationQuotation->percentage,
        );
    }

    public static function fromArrayData(array $data): ImplementationQuotationAdminDto
    {
        return new self(
            implementation_agency_id: $data['implementation_agency_id'],
            name: $data['name'],
            address: $data['address'],
            amount: $data['amount'],
            date: $data['date'],
            percentage: $data['percentage'],
        );
    }
}
