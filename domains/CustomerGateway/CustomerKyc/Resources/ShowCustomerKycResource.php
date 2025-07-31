<?php

namespace Domains\CustomerGateway\CustomerKyc\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Domains\CustomerGateway\CustomerDetail\Resources\ShowCustomerDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCustomerKycResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $documentPath = config('src.CustomerKyc.customerKyc.path');
        
        return [
            'id' => $this->id,
            'nepali_date_of_birth' => $this->nepali_date_of_birth,
            'english_date_of_birth' => $this->english_date_of_birth,
            'grandfather_name' => $this->grandfather_name,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'spouse_name' => $this->spouse_name,
            'permanent_province' => [
                'id' => $this->permanentProvince->id,
                'name' => $this->permanentProvince->title,
                'name_en' => $this->permanentProvince->title_en,
            ],
            'permanent_district' =>  [
                'id' => $this->permanentDistrict->id,
                'name' => $this->permanentDistrict->title,
                'name_en' => $this->permanentDistrict->title_en,
            ],
            'permanent_local_body' =>[
               'id' => $this->permanentLocalBody->id,
                'name' => $this->permanentLocalBody->title,
                'name_en' => $this->permanentLocalBody->title_en
            ],
            'permanent_ward' => $this->permanent_ward,
            'permanent_tole' => $this->permanent_tole,
            'temporary_province' => [
                'id' => $this->temporaryProvince->id,
                'name' => $this->temporaryProvince->title,
                'name_en' => $this->temporaryProvince->title_en,
            ],
            'temporary_district' =>  [
                'id' => $this->temporaryDistrict->id,
                'name' => $this->temporaryDistrict->title,
                'name_en' => $this->temporaryDistrict->title_en,
            ],
            'temporary_local_body' =>[
               'id' => $this->temporaryLocalBody->id,
                'name' => $this->temporaryLocalBody->title,
                'name_en' => $this->temporaryLocalBody->title_en
            ],
            'temporary_ward' => $this->temporary_ward,
            'temporary_tole' => $this->temporary_tole,
            'status' => $this->status,
            'document_type' => $this->document_type,
            'document_issued_date_nepali' => $this->document_issued_date_nepali,
            'document_issued_date_english' => $this->document_issued_date_english,
            'document_issued_at' => $this->document_issued_at,
            'document_number' => $this->document_number,
            'document_image1' => ImageServiceFacade::getImage($documentPath, $this->document_image1, getStorageDisk('private')),
            'document_image2' => ImageServiceFacade::getImage($documentPath, $this->document_image2, getStorageDisk('private')),
            'expiry_date_nepali' => $this->expiry_date_nepali,
            'expiry_date_english' => $this->expiry_date_english,
            'reason_to_reject' => $this->reason_to_reject,
        ];
    }
}
