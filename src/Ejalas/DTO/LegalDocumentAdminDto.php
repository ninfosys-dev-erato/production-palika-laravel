<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\LegalDocument;

class LegalDocumentAdminDto
{
    public function __construct(
        public string $complaint_registration_id,
        public ?string $party_name,
        public ?string $document_writer_name,
        public ?string $document_date,
        public ?string $document_details
    ) {}

    public static function fromLiveWireModel(LegalDocument $legalDocument): LegalDocumentAdminDto
    {
        return new self(
            complaint_registration_id: $legalDocument->complaint_registration_id,
            party_name: $legalDocument->party_name,
            document_writer_name: $legalDocument->document_writer_name,
            document_date: $legalDocument->document_date,
            document_details: $legalDocument->document_details
        );
    }
}
