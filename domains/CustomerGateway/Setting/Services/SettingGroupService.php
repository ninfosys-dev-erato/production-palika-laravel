<?php
namespace Domains\CustomerGateway\Setting\Services;

use Domains\CustomerGateway\Setting\Resources\SettingGroupResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Src\Settings\Models\SettingGroup;

class SettingGroupService{

    public function settingGroups()
    {
        return SettingGroup::whereNull('deleted_at')->whereNull('deleted_by')->with('settings')->get();
    }
}