<?php

namespace Src\AdminSettings\Service;
use Illuminate\Support\Facades\Auth;
use Src\AdminSettings\Models\AdminSettingGroup;
use Src\AdminSettings\DTO\AdminSettingGroupDto;

class AdminSettingGroupService
{

    public function store(AdminSettingGroupDto $adminSettingGroupDto)
    {
        return AdminSettingGroup::create([
            'group_name' => $adminSettingGroupDto->group_name,
            'description' => $adminSettingGroupDto->description,
            'created_by' => Auth::id()
        ]);

    }

    public function update(AdminSettingGroup $group, AdminSettingGroupDto $adminSettingGroupDto)
    {
        return tap($group)->update([
            'group_name' => $adminSettingGroupDto->group_name,
            'description' => $adminSettingGroupDto->description,
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(AdminSettingGroup $group)
    {
        return tap($group)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        AdminSettingGroup::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

}