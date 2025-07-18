<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Enums\BusinessDocumentStatusEnum;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;

class BusinessRenewalDocumentAdminDto
{
    public function __construct(
        public ?string $business_registration_id,
        public ?string $business_renewal,
        public ?string $document_name,
        public ?string $document,
        public ?string $document_status,
    ) {}

    public static function fromLiveWireModel(BusinessRenewalDocument $businessRenewalDocument): BusinessRenewalDocumentAdminDto
    {
        return new self(
            business_registration_id: $businessRenewalDocument->business_registration_id,
            business_renewal: $businessRenewalDocument->business_renewal,
            document_name: $businessRenewalDocument->document_name,
            document: $businessRenewalDocument->document,
            document_status: $businessRenewalDocument->document_status,
        );
    }
    public static function fromLiveWireArray(array $businessRenewalDocument, $businessRenewal): BusinessRenewalDocumentAdminDto
    {
        return new self(
            business_registration_id: $businessRenewal['business_registration_id'],
            business_renewal: $businessRenewal['id'],
            document_name: $businessRenewalDocument['document_name'],
            document: $businessRenewalDocument['document'] ?? null,
            document_status: $businessRenewalDocument['document_status'] ?? BusinessDocumentStatusEnum::REQUESTED->value,
        );
    }
}
