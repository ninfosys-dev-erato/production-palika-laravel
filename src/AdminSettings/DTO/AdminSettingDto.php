<?php

namespace Src\AdminSettings\DTO;

use Src\AdminSettings\Models\AdminSetting;
use Src\AdminSettings\Enums\ModuleEnum;

class AdminSettingDto
{
    public function __construct(
        public int $group_id,
        public string $label,
        public ?ModuleEnum $select_from,
        public string $value
    ){}

    public static function fromLiveWireModel(AdminSetting $setting):AdminSettingDto{
        return new self(
            group_id: $setting->group_id,
            label: $setting->label,
            select_from: $setting->select_from,
            value: $setting->value
        );
    }
}
