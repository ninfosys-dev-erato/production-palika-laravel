<?php

namespace Domains\CustomerGateway\CustomerDetail\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Domains\CustomerGateway\CustomerKyc\Resources\ShowCustomerKycResource;

class ShowCustomerDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatarPath = config('src.Customers.customer.avatar_path');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'avatar' => $this->avatar? ImageServiceFacade::getImage($avatarPath, $this->avatar, getStorageDisk('private')) : null,
            'gender' => $this->gender,
            'language_preference' => $this->language_preference,
            'notification_preference' => $this->notification_preference,
            'customer-kyc' => $this->whenLoaded('kyc') ? new ShowCustomerKycResource($this->kyc) : null, 
            
        ];
    }
}
