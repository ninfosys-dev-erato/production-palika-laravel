<?php

namespace Src\Settings\DTO;

use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;

class MstSettingAdminDto
{
   public function __construct(
        public string $group_id,
        public string $label,
        public string $label_ne,
        public string $value,
        public int $key_id,
        public string $key_type,
        public string $key_needle,
        public string $key,
        public string $description
    ){}

    public static function fromLiveWireModel(MstSetting $setting):MstSettingAdminDto{
        return new self(
            group_id: $setting->group_id,
            label: $setting->label??"",
            label_ne: $setting->label_ne??"",
            value: $setting->value??"",
            key_id: $setting->key_id??0,
            key_type: $setting->key_type??"",
            key_needle: $setting->key_needle??"",
            key: $setting->key??"",
            description: $setting->description??""
        );
    }
}
