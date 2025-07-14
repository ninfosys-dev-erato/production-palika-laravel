<?php

namespace Domains\CustomerGateway\Setting\Resources;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "group_name"    => $this->group_name,
            "group_name_ne" => $this->group_name_ne,
            "slug"          => $this->slug,
            "is_public"     => $this->is_public,
            "description"   => $this->description,
            "settings"      => $this->whenLoaded('settings', function () {
                return $this->settings->map(function ($setting) {
                    return [
                        "label"      => $setting->label,
                        "label_ne"   => $setting->label_ne,
                        "value"      => $setting->value,
                        "key_id"     => $setting->key_id,
                        "key_type"   => $setting->key_type,
                        "key_needle" => $setting->key_needle,
                        "key"        => $setting->key,
                    ];
                });
            }),
        ];
    }

}
