<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ConfigurationAdminDto;
use Src\Yojana\Models\Configuration;

class ConfigurationAdminService
{
    public function store(ConfigurationAdminDto $configurationAdminDto)
    {
        return Configuration::create([
            'title' => $configurationAdminDto->title,
            'amount' => $configurationAdminDto->amount,
            'rate' => $configurationAdminDto->rate,
            'type_id' => $configurationAdminDto->type_id,
            'use_in_cost_estimation' => $configurationAdminDto->use_in_cost_estimation,
            'use_in_payment' => $configurationAdminDto->use_in_payment,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Configuration $configuration, ConfigurationAdminDto $configurationAdminDto)
    {
        return tap($configuration)->update([
            'title' => $configurationAdminDto->title,
            'amount' => $configurationAdminDto->amount,
            'rate' => $configurationAdminDto->rate,
            'type_id' => $configurationAdminDto->type_id,
            'use_in_cost_estimation' => $configurationAdminDto->use_in_cost_estimation,
            'use_in_payment' => $configurationAdminDto->use_in_payment,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Configuration $configuration)
    {
        return tap($configuration)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Configuration::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
