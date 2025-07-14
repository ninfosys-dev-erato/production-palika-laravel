<?php

namespace Domains\CustomerGateway\Employee\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'gender' => $this->gender,
            'pan_no' => $this->pan_no,
            'is_department_head' => $this->is_department_head,
            'photo' => $this->photo, 
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'ward_no' => $this->ward_no,
            'remarks' => $this->remarks,
            'position' => $this->position,
            'branch' => $this->whenLoaded('branch')?[
                'id' => $this->branch->id,
                'name' => $this->branch->title,
                'name_en' => $this->branch->title_en,
            ]:[
                'id' => 0,
                'name' => "N/A",
                'name_en' => "N/A",
            ],
            'designation_id' => $this->whenLoaded('designation')?[
                'id' => $this->designation->id,
                'name' => $this->designation->title,
                'name_en' => $this->designation->title_en,
            ]:[
                'id' => 0,
                'name' => "N/A",
                'name_en' => "N/A",
            ]
            
        ];
    }
}