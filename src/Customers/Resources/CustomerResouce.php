<?php

namespace Src\Customers\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'email'                  => $this->email,
            'mobile_no'              => $this->mobile_no,
            'is_active'              => $this->is_active,
            'avatar'                 => $this->avatar,
            'gender'                 => $this->gender?->value, // or ->label if needed
            'language_preference'    => $this->language_preference?->value,
            'expo_push_token'        => $this->expo_push_token,
            'notification_preference'=> $this->notification_preference,
            'kyc_verified_at'        => $this->kyc_verified_at?->toDateTimeString(),
            // Include KYC only if loaded (no lazy loading error)
            'kyc' => $this->whenLoaded('kyc', fn () => CustomerKycResource::make($this->kyc)),
        ];
    }
}
