<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\DocumentType;

class DocumentTypeAdminDto
{
    public function __construct(
        public ?string $name_eng,
        public string $name_nep,
        public ?string $remarks = null,
    ) {}

    public static function fromLiveWireModel(DocumentType $documentType): DocumentTypeAdminDto
    {
        return new self(
            name_eng: $documentType->name_eng,
            name_nep: $documentType->name_nep,
            remarks: $documentType->remarks,
        );
    }

    public static function fromRequest(array $data): DocumentTypeAdminDto
    {
        return new self(
            name_eng: $data['name_eng'] ?? null,
            name_nep: $data['name_nep'],
            remarks: $data['remarks'] ?? null,
        );
    }

    public static function fromModel(DocumentType $documentType): DocumentTypeAdminDto
    {
        return new self(
            name_eng: $documentType->name_eng,
            name_nep: $documentType->name_nep,
            remarks: $documentType->remarks,
        );
    }

    public function toArray(): array
    {
        return [
            'name_eng' => $this->name_eng,
            'name_nep' => $this->name_nep,
            'remarks' => $this->remarks,
        ];
    }
}
