<?php

namespace Domains\CustomerGateway\DigitalBoard\Resources;

use App\Facades\VideoServiceFacade;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $disk = $this->is_private ? 'local' : 'public';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url ?? null,
            'can_show_on_admin' => $this->can_show_on_admin,
            'file' => $this->file 
                ? VideoServiceFacade::getVideo(config('src.DigitalBoard.video.video_path'), $this->file, $disk)
                : null,
            'wards' => $this->wards->pluck('ward') ?? null,
        ];
    }
}