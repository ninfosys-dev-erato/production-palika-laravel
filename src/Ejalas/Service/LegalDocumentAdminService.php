<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\LegalDocumentAdminDto;
use Src\Ejalas\Models\LegalDocument;

class LegalDocumentAdminService
{
    public function store(LegalDocumentAdminDto $legalDocumentAdminDto)
    {
        return LegalDocument::create([
            'complaint_registration_id' => $legalDocumentAdminDto->complaint_registration_id,
            'party_name' => $legalDocumentAdminDto->party_name,
            'document_writer_name' => $legalDocumentAdminDto->document_writer_name,
            'document_date' => $legalDocumentAdminDto->document_date,
            'document_details' => $legalDocumentAdminDto->document_details,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(LegalDocument $legalDocument, LegalDocumentAdminDto $legalDocumentAdminDto)
    {
        return tap($legalDocument)->update([
            'complaint_registration_id' => $legalDocumentAdminDto->complaint_registration_id,
            'party_name' => $legalDocumentAdminDto->party_name,
            'document_writer_name' => $legalDocumentAdminDto->document_writer_name,
            'document_date' => $legalDocumentAdminDto->document_date,
            'document_details' => $legalDocumentAdminDto->document_details,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(LegalDocument $legalDocument)
    {
        return tap($legalDocument)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        LegalDocument::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
