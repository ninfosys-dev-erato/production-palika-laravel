<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\AgreementSignatureDetail;

class AgreementSignatureDetailAdminDto
{
   public function __construct(
        public string $agreement_id,
        public ?string $signature_party,
        public string $name,
        public string $position,
        public string $address,
        public string $contact_number,
        public string $date
    ){}

    public static function fromLiveWireModel(AgreementSignatureDetail $agreementSignatureDetail):AgreementSignatureDetailAdminDto{
        return new self(
            agreement_id: $agreementSignatureDetail->agreement_id,
            signature_party: $agreementSignatureDetail->signature_party,
            name: $agreementSignatureDetail->name,
            position: $agreementSignatureDetail->position,
            address: $agreementSignatureDetail->address,
            contact_number: $agreementSignatureDetail->contact_number,
            date: $agreementSignatureDetail->date
        );
    }

    public static function fromArrayData(array $data): AgreementSignatureDetailAdminDto
    {
        return new self(
            agreement_id: $data['agreement_id'] ?? null,
            signature_party: $data['signature_party'] ?? 0,
            name: $data['name'] ?? null,
            position: $data['position'] ?? null,
            address: $data['address'] ?? null,
            contact_number: $data['contact_number'] ?? null,
            date: $data['date'] ?? null
        );
    }

}
