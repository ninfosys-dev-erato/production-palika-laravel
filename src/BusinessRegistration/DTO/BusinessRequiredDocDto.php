<?php

namespace Src\BusinessRegistration\DTO;

class BusinessRequiredDocDto
{
    public function __construct(
        public int $businessRegistrationId,
        public string $documentField,
        public string $documentLabelEn,
        public string $documentLabelNe,
        public string $documentFilename
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            businessRegistrationId: $data['business_registration_id'],
            documentField: $data['document_field'],
            documentLabelEn: $data['document_label_en'],
            documentLabelNe: $data['document_label_ne'],
            documentFilename: $data['document_filename']
        );
    }

    public function toArray(): array
    {
        return [
            'business_registration_id' => $this->businessRegistrationId,
            'document_field' => $this->documentField,
            'document_label_en' => $this->documentLabelEn,
            'document_label_ne' => $this->documentLabelNe,
            'document_filename' => $this->documentFilename,
        ];
    }
}
