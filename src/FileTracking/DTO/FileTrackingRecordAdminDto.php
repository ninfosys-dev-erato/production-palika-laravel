<?php

namespace Src\FileTracking\DTO;

use Illuminate\Database\Eloquent\Model;
use Src\Customers\Models\Customer;
use Src\FileTracking\Models\FileRecord;

class FileTrackingRecordAdminDto
{
   public function __construct(
       public string $title,
       public string $applicant_name,
       public string $applicant_mobile_no,
       public string $ward,
       public string $local_body_id,
       public bool $is_chalani,
       public $file,
       public array $departments,
       public $recipient_name,	
       public $recipient_position,
       public $signee_name,
       public $signee_position,
       public $document_level
    ){}

    public static function fromLiveWireModel(FileRecord $fileRecord, $applicant_id):FileTrackingRecordAdminDto{
        $customer = Customer::where('id', $applicant_id)->with('kyc')->first();
        $departments = collect([$fileRecord->signee_department, $fileRecord->recipient_department])
        ->filter()   
        ->unique() 
        ->values()
        ->all();

        return new self(
            title: $fileRecord->title,
            applicant_name: $customer->name,
            applicant_mobile_no: $customer->mobile_no,
            ward: $customer->kyc->permanent_ward,
            local_body_id: $customer->kyc->permanent_local_body_id,
            is_chalani: $fileRecord->is_chalani,
            file: $fileRecord->file,
            departments: $departments,
            recipient_name:$fileRecord->recipient_name ,	
            recipient_position: $fileRecord->recipient_position,
            signee_name: $fileRecord->signee_name,
            signee_position: $fileRecord->signee_position,
            document_level:$fileRecord->document_level ,
        );
    }

}
