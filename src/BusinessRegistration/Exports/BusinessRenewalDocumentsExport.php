<?php

namespace Src\BusinessRegistration\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;

class BusinessRenewalDocumentsExport implements FromCollection
{
    public $business_renewal_documents;

    public function __construct($business_renewal_documents)
    {
        $this->business_renewal_documents = $business_renewal_documents;
    }

    public function collection()
    {
        return BusinessRenewalDocument::select([
            'business_registration_id',
            'business_renewal',
            'document_name',
            'document',
            'document_details',
            'document_status',
            'comment_log'
        ])
            ->whereIn('id', $this->business_renewal_documents)->get();
    }
}


