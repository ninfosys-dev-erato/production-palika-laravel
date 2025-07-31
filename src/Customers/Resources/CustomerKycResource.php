<?php

namespace Src\Customers\Resources;

use App\Facades\ImageServiceFacade;
use Domains\AdminGateway\Grievance\Resources\ClientRes;
use Domains\CustomerGateway\Grievance\Resources\GrievanceAssignHistoryResource;
use Domains\CustomerGateway\Grievance\Resources\GrievanceBranchResource;
use Domains\CustomerGateway\Grievance\Resources\GrievanceFileResource;
use Domains\CustomerGateway\Grievance\Resources\GrievanceTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerKycResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'nepali_date_of_birth' => $this->nepali_date_of_birth,
            'english_date_of_birth' => $this->english_date_of_birth,
            'grandfather_name' => $this->grandfather_name,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'spouse_name' => $this->spouse_name,
            'document_type' => $this->document_type,
            'document_issued_at' => $this->citizenshipIssueDistrict->title ?? __('Not Provided'),
            'document_number' => $this->document_number,
            'document_image1' => ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'),$this->document_image1,getStorageDisk('private')),
            'document_image2' => ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'),$this->document_image2,getStorageDisk('private')),
            'document_issued_date_nepali' => $this->document_issued_date_nepali,
            'document_issued_date_english' => $this->document_issued_date_english,
            'expiry_date_nepali' => $this->expiry_date_nepali,
            'expiry_date_english' => $this->expiry_date_english,
            'status' => $this->status,
            'verified_by' => $this->verifiedBy?->name,
            'rejected_by' => $this->rejectedBy?->name,
            'reason_to_reject' => $this->reason_to_reject,

            'permanent_address' => implode(', ', [
                $this->permanentProvince->title ?? __('Not Provided'),
                $this->permanentDistrict->title ?? __('Not Provided'),
                $this->permanentLocalBody->title ?? __('Not Provided'),
                ($this->permanent_ward ? "Ward {$this->permanent_ward}" : __('Not Provided')),
                $this->permanent_tole ?? __('Not Provided'),
            ]),

            'temporary_address' => implode(', ', [
                $this->temporaryProvince->title ?? __('Not Provided'),
                $this->temporaryDistrict->title ?? __('Not Provided'),
                $this->temporaryLocalBody->title ?? __('Not Provided'),
                ($this->temporary_ward ? "Ward {$this->temporary_ward}" : __('Not Provided')),
                $this->temporary_tole ?? __('Not Provided'),
            ]),
        ];
    }
}
