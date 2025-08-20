<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\AdditionalFormDynamicDataDto;
use Src\Ebps\Models\AdditionalFormDynamicData;

class AdditionalFormDynamicDataService
{
    public function store(AdditionalFormDynamicDataDto $additionalFormDynamicDataDto)
    {
        return AdditionalFormDynamicData::create([
            'map_apply_id' => $additionalFormDynamicDataDto->map_apply_id,
            'form_id' => $additionalFormDynamicDataDto->form_id,
            'form_data' => $additionalFormDynamicDataDto->form_data,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function update(AdditionalFormDynamicData $additionalFormDynamicData, AdditionalFormDynamicDataDto $additionalFormDynamicDataDto)
    {
        return tap($additionalFormDynamicData)->update([
            'map_apply_id' => $additionalFormDynamicDataDto->map_apply_id,
            'form_id' => $additionalFormDynamicDataDto->form_id,
            'form_data' => $additionalFormDynamicDataDto->form_data,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function updateOrCreate(AdditionalFormDynamicDataDto $additionalFormDynamicDataDto)
    {
        return AdditionalFormDynamicData::updateOrCreate(
            [
                'map_apply_id' => $additionalFormDynamicDataDto->map_apply_id,
                'form_id' => $additionalFormDynamicDataDto->form_id,
            ],
            [
                'form_data' => $additionalFormDynamicDataDto->form_data,
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }

    public function delete(AdditionalFormDynamicData $additionalFormDynamicData)
    {

        return tap($additionalFormDynamicData)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::id(),
        ]);
    }
    public function deleteFormData(AdditionalFormDynamicData $additionalFormDynamicData)
    {

        return tap($additionalFormDynamicData)->update([
            'form_data' => null,
        ]);
    }



    public function findByMapApplyAndForm(int $mapApplyId, int $formId)
    {
        return AdditionalFormDynamicData::where('map_apply_id', $mapApplyId)
            ->where('form_id', $formId)
            ->where('deleted_at', null)
            ->first();
    }
}
