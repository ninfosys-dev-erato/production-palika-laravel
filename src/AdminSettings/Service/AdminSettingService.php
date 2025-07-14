<?php

namespace Src\AdminSettings\Service;

use Illuminate\Support\Facades\Auth;
use Src\AdminSettings\Models\AdminSetting;
use Src\AdminSettings\DTO\AdminSettingDto;

class AdminSettingService
{
    /**
     * Store a new Admin Setting.
     */
    public function store(AdminSettingDto $adminSettingDto)
    {
        return AdminSetting::create([
            'group_id' => $adminSettingDto->group_id,
            'label' => $adminSettingDto->label,
            'select_from' => $adminSettingDto->select_from,
            'value' => $adminSettingDto->value,
            'created_by' => Auth::id(),
        ]);
    }

    /**
     * Update an existing Admin Setting.
     */
    public function update(AdminSetting $setting, AdminSettingDto $adminSettingDto)
    {
        return tap($setting)->update([
            'group_id' => $adminSettingDto->group_id,
            'label' => $adminSettingDto->label,
            'select_from' => $adminSettingDto->select_from,
            'value' => $adminSettingDto->value,
            'updated_by' => Auth::id(),
        ]);
    }

    /**
     * Soft-delete an Admin Setting.
     */
    public function delete(AdminSetting $setting)
    {
        return tap($setting)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }

    /**
     * Bulk-delete a collection of Admin Settings.
     */
    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        AdminSetting::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }
}
