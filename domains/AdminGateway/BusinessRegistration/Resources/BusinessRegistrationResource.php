<?php
namespace Domains\AdminGateway\BusinessRegistration\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessRegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'entity_name' => $this->entity_name,
            'registration_number' => $this->registration_number,
            'certificate_number' => $this->certificate_number,
            'application_status' => $this->application_status,
            'application_status_nepali' => $this->application_status_nepali,
            'business_status' => $this->business_status,
            'business_status_nepali' => $this->business_status_nepali,
            'application_date' => $this->application_date,
            'registration_date' => $this->registration_date,
            'mobile_no' => $this->mobile_no,
            'applicant_name' => $this->applicant_name,

            // Related models
            'registration_type' => new RegistrationTypeResource($this->whenLoaded('registrationType')),
            'province' => new ProvinceResource($this->whenLoaded('province')),
            'district' => new DistrictResource($this->whenLoaded('district')),
            'local_body' => new LocalBodyResource($this->whenLoaded('localBody')),
        ];
    }
}
