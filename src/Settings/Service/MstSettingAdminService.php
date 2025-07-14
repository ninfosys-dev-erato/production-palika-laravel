<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Src\Settings\DTO\MstSettingAdminDto;
use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;

class MstSettingAdminService
{
    public function store(MstSettingAdminDto $settingAdminDto){
        return MstSetting::create([
            'group_id' => $settingAdminDto->group_id,
            'label' => $settingAdminDto->label,
            'label_ne' => $settingAdminDto->label_ne,
            'value' => $settingAdminDto->value,
            'key_id' => $settingAdminDto->key_id,
            'key_type' => $settingAdminDto->key_type,
            'key_needle' => $settingAdminDto->key_needle,
            'key' => $settingAdminDto->key,
            'description' => $settingAdminDto->description,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(MstSetting $setting, MstSettingAdminDto $settingAdminDto){
        return tap($setting)->update([
            'group_id' => $settingAdminDto->group_id,
            'label' => $settingAdminDto->label,
            'label_ne' => $settingAdminDto->label_ne,
            'value' => $settingAdminDto->value,
            'key_id' => $settingAdminDto->key_id,
            'key_type' => $settingAdminDto->key_type,
            'key_needle' => $settingAdminDto->key_needle,
            'key' => $settingAdminDto->key,
            'description' => $settingAdminDto->description,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(MstSetting $setting){
        return tap($setting)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        MstSetting::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function setValue(MstSetting $setting, string|bool|int $value, int|null $key_id = 0){
       Cache::forget("setting_{$setting->key}");
       Cache::forget("setting_with_key_{$setting->key}");
        return tap($setting)->update([
            'value' => $value,
            'key_id' => $key_id,
        ]);
    }
}


