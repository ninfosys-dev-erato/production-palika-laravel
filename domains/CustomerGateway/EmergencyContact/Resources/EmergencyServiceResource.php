<?php

namespace Domains\CustomerGateway\EmergencyContact\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $imagePath = config('src.EmergencyContacts.emergencyContact.icon_path');
        return [
            'id' => (int) $this->id,
            'emergency_id' => (int) $this->emergency_id,
            'contact_person' => $this->contact_person,
            'contact_person_ne' => $this->contact_person_ne,
            'address' => $this->address,
            'address_ne' => $this->address_ne,
            'contact_numbers' => $this->contact_numbers,
            'site_map' => $this->site_map,
            'website_url' => $this->website_url,
            'facebook_url' => $this->facebook_url,
            'image' => (string)$this->image? ImageServiceFacade::getImage($imagePath, $this->image) : null,
        ];

    }

   
}
