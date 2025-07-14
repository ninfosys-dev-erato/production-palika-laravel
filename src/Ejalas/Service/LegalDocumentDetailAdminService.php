<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\LegalDocumentAdminDto;
use Src\Ejalas\DTO\LegalDocumentDetailAdminDto;
use Src\Ejalas\Models\LegalDocument;
use Src\Ejalas\Models\LegalDocumentDetail;

class LegalDocumentDetailAdminService
{
    public function store(LegalDocumentDetailAdminDto $legalDocumentDetailAdminDto)
    {
        return LegalDocumentDetail::create([
            'party_name' => $legalDocumentDetailAdminDto->party_name,
            'document_writer_name' => $legalDocumentDetailAdminDto->document_writer_name,
            'document_date' => $legalDocumentDetailAdminDto->document_date,
            'document_details' => $legalDocumentDetailAdminDto->document_details,
            'statement_giver' => $legalDocumentDetailAdminDto->statement_giver,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'legal_document_id' => $legalDocumentDetailAdminDto->legal_document_id,

        ]);
    }
    public function update(LegalDocumentDetail $legalDocument, LegalDocumentDetailAdminDto $legalDocumentDetailAdminDto)
    {
        return tap($legalDocument)->update([
            'party_name' => $legalDocumentDetailAdminDto->party_name,
            'document_writer_name' => $legalDocumentDetailAdminDto->document_writer_name,
            'document_date' => $legalDocumentDetailAdminDto->document_date,
            'document_details' => $legalDocumentDetailAdminDto->document_details,
            'statement_giver' => $legalDocumentDetailAdminDto->statement_giver,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'legal_document_id' => $legalDocumentDetailAdminDto->legal_document_id,
        ]);
    }
    public function delete(LegalDocumentDetail $legalDocumentDetail)
    {
        return tap($legalDocumentDetail)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        LegalDocumentDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
