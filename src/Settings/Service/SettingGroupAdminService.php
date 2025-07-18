<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Settings\DTO\SettingGroupAdminDto;
use Src\Settings\Models\SettingGroup;

class SettingGroupAdminService
{
public function store(SettingGroupAdminDto $settingGroupAdminDto){
    return SettingGroup::create([
        'group_name' => $settingGroupAdminDto->group_name,
        'group_name_ne' => $settingGroupAdminDto->group_name_ne,
        'is_public' => $settingGroupAdminDto->is_public,
        'slug' => $settingGroupAdminDto->slug,
        'description' => $settingGroupAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(SettingGroup $settingGroup, SettingGroupAdminDto $settingGroupAdminDto){
    return tap($settingGroup)->update([
        'group_name' => $settingGroupAdminDto->group_name,
        'group_name_ne' => $settingGroupAdminDto->group_name_ne,
        'is_public' => $settingGroupAdminDto->is_public,
        'slug' => $settingGroupAdminDto->slug,
        'description' => $settingGroupAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(SettingGroup $settingGroup){
    return tap($settingGroup)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        SettingGroup::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


