<?php

namespace Domains\CustomerGateway\DigitalBoard\Resources;

use App\Facades\ImageServiceFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'title' => $this->title,
            'photo' => ImageServiceFacade::getImage(config('src.DigitalBoard.program.photo_path') , $this->photo), 
            'can_show_on_admin' => (bool) $this->can_show_on_admin,
            'wards' => $this->wards->pluck('ward') ?? null,
        ];
    }
}