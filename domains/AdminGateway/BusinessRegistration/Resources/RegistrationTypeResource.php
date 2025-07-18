<?php

namespace Domains\AdminGateway\BusinessRegistration\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'registration_category' => new RegistrationCategoryResource($this->whenLoaded('registrationCategory')),
        ];
    }
}