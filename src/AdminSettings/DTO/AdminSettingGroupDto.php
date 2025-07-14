<?php

namespace Src\AdminSettings\DTO;

use Src\AdminSettings\Models\AdminSettingGroup;

class AdminSettingGroupDto
{
    public function __construct(
        public string $group_name,
        public string $description,
    ){}

    public static function fromLiveWireModel(AdminSettingGroup $group):AdminSettingGroupDto{
        return new self(
            group_name: $group->group_name,
            description: $group->description,
        );
    }
}
