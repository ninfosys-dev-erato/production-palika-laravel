<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\DocumentTypeAdminDto;
use Src\Beruju\Models\DocumentType;

class DocumentTypeAdminService
{
    public function store(DocumentTypeAdminDto $documentTypeAdminDto){
        return DocumentType::create([
            'name_eng' => $documentTypeAdminDto->name_eng,
            'name_nep' => $documentTypeAdminDto->name_nep,
            'remarks' => $documentTypeAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(DocumentType $documentType, DocumentTypeAdminDto $documentTypeAdminDto){
        return tap($documentType)->update([
            'name_eng' => $documentTypeAdminDto->name_eng,
            'name_nep' => $documentTypeAdminDto->name_nep,
            'remarks' => $documentTypeAdminDto->remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(DocumentType $documentType){
        return tap($documentType)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        DocumentType::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
