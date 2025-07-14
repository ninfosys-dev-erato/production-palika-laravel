<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\LegalDocument;

class LegalDocumentDetailAdminDto
{
    public function __construct(
        public string $legal_document_id,
        public string $party_name,
        public string $document_writer_name,
        public string $document_date,
        public string $document_details,
        public string $statement_giver
    ) {}

    public static function fromLiveWireModel(LegalDocument $legalDocument): LegalDocumentDetailAdminDto
    {
        return new self(
            legal_document_id: $legalDocument->legal_document_id,
            party_name: $legalDocument->party_name,
            document_writer_name: $legalDocument->document_writer_name,
            document_date: $legalDocument->document_date,
            document_details: $legalDocument->document_details,
            statement_giver: $legalDocument->statement_giver
        );
    }
}
