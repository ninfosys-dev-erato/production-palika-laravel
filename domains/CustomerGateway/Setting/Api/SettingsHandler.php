<?php

namespace Domains\CustomerGateway\Setting\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Setting\Resources\SettingGroupResource;
use Domains\CustomerGateway\Setting\Services\SettingGroupService;

class SettingsHandler extends Controller
{
    use ApiStandardResponse;
    public $settingGroupService;
    public function __construct()
    {
        $this->settingGroupService = new SettingGroupService();
    }

    public function settingGroup()
    {
        return SettingGroupResource::collection($this->settingGroupService->settingGroups());
    }
}