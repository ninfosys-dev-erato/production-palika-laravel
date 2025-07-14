<?php

namespace Domains\CustomerGateway\DigitalBoard\Resources;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'date' => $this->date,
            'description' => $this->description,
            'can_show_on_admin' => (bool) $this->can_show_on_admin,
            'wards' => $this->wards->pluck('ward') ?? 0,
            'file' => $this->getFileUrl($this->file),
        ];
    }
    private function getFileUrl($file)
    {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
        return FileFacade::getTemporaryUrl(config('src.DigitalBoard.notice.notice_path'), $file, 'public');
        }

        return ImageServiceFacade::getImage(config('src.DigitalBoard.notice.notice_path') , $file);
    }
}