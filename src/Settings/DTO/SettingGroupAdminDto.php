<?php

namespace Src\Settings\DTO;

use Src\Settings\Models\SettingGroup;

class SettingGroupAdminDto
{
   public function __construct(
        public string $group_name,
        public string $group_name_ne,
        public bool $is_public,
        public string $slug,
        public string $description
    ){}

    public static function fromLiveWireModel(SettingGroup $settingGroup):SettingGroupAdminDto{
        return new self(
            group_name: $settingGroup->group_name,
            group_name_ne: $settingGroup->group_name_ne,
            is_public: $settingGroup->is_public??false,
            slug: $settingGroup->slug,
            description: $settingGroup->description
        );
    }
}
