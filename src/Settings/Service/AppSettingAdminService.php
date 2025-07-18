<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Settings\DTO\AppSettingDto;
use Src\Settings\Models\AppSetting;
use Src\Settings\Models\Form;

class AppSettingAdminService
{

    public function store(AppSettingDto $appSettingDto)
    {
        return AppSetting::create([
            'version' => $appSettingDto->version,
            'released_note' => $appSettingDto->released_note,
           
        ]);

    }

    public function update(AppSetting $appSetting, AppSettingDto $appSettingDto)
    {
        return tap($appSetting)->update([
            'version' => $appSettingDto->version,
            'released_note' => $appSettingDto->released_note,
        ]);

    }

    public function delete(Form $form)
    {
        return $form->update([
            'deleted_at' => now(),
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Form::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
        ]);


    }
}
