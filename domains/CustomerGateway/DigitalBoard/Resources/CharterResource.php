<?php

namespace Domains\CustomerGateway\DigitalBoard\Resources;

use App\Facades\ImageServiceFacade;
use Domains\CustomerGateway\Branch\Resources\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service' => $this->service,
            'branch_id' => $this->whenLoaded('branch') ? new BranchResource(($this->branch)):null,
            'required_document' => $this->required_document,
            'amount' => $this->amount,
            'time' => $this->time,
            'responsible_person' => $this->responsible_person,
            'can_show_on_admin' => (bool) $this->can_show_on_admin,
            'wards' => $this->wards->pluck('ward') ?? null,
        ];
    }
}