<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\ActionTypeAdminDto;
use Src\Beruju\Models\ActionType;

class ActionTypeAdminService
{
    public function store(ActionTypeAdminDto $actionTypeAdminDto){
        return ActionType::create([
            'name_eng' => $actionTypeAdminDto->name_eng,
            'name_nep' => $actionTypeAdminDto->name_nep,
            'sub_category_id' => $actionTypeAdminDto->sub_category_id,
            'remarks' => $actionTypeAdminDto->remarks,
            'form_id' => $actionTypeAdminDto->form_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(ActionType $actionType, ActionTypeAdminDto $actionTypeAdminDto){
        return tap($actionType)->update([
            'name_eng' => $actionTypeAdminDto->name_eng,
            'name_nep' => $actionTypeAdminDto->name_nep,
            'sub_category_id' => $actionTypeAdminDto->sub_category_id,
            'remarks' => $actionTypeAdminDto->remarks,
            'form_id' => $actionTypeAdminDto->form_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(ActionType $actionType){
        return tap($actionType)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        ActionType::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
