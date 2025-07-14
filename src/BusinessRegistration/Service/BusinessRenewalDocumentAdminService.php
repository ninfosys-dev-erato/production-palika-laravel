<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessRenewalDocumentAdminDto;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;

class BusinessRenewalDocumentAdminService
{
    public function store(BusinessRenewalDocumentAdminDto $businessRenewalDocumentAdminDto)
    {
        return BusinessRenewalDocument::create([
            'business_registration_id' => $businessRenewalDocumentAdminDto->business_registration_id,
            'business_renewal' => $businessRenewalDocumentAdminDto->business_renewal,
            'document_name' => $businessRenewalDocumentAdminDto->document_name,
            'document' => $businessRenewalDocumentAdminDto->document,
            'document_details' => $businessRenewalDocumentAdminDto->document_details,
            'document_status' => $businessRenewalDocumentAdminDto->document_status,
            'comment_log' => $businessRenewalDocumentAdminDto->comment_log,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(BusinessRenewalDocument $businessRenewalDocument, BusinessRenewalDocumentAdminDto $businessRenewalDocumentAdminDto)
    {
        return tap($businessRenewalDocument)->update([
            'business_registration_id' => $businessRenewalDocumentAdminDto->business_registration_id,
            'business_renewal' => $businessRenewalDocumentAdminDto->business_renewal,
            'document_name' => $businessRenewalDocumentAdminDto->document_name,
            'document' => $businessRenewalDocumentAdminDto->document,
            'document_details' => $businessRenewalDocumentAdminDto->document_details,
            'document_status' => $businessRenewalDocumentAdminDto->document_status,
            'comment_log' => $businessRenewalDocumentAdminDto->comment_log,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(BusinessRenewalDocument $businessRenewalDocument)
    {
        return tap($businessRenewalDocument)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BusinessRenewalDocument::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function saveDocument(int $documentId = 0 ,BusinessRenewalDocumentAdminDto $businessRenewalDocumentAdminDto){
        return BusinessRenewalDocument::updateOrCreate([
            'id'=>$documentId],[
            'document_name'=>$businessRenewalDocumentAdminDto->document_name,
            'business_registration_id'=>$businessRenewalDocumentAdminDto->business_registration_id,
            'business_renewal'=>$businessRenewalDocumentAdminDto->business_renewal,
            'document_status'=>$businessRenewalDocumentAdminDto->document_status,
            'document'=>$businessRenewalDocumentAdminDto->document,
        ]);
    }
}


