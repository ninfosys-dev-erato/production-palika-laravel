<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\ActionAdminDto;
use Src\Beruju\Models\Action;

class ActionAdminService
{
    public function store(ActionAdminDto $actionAdminDto)
    {
        return Action::create([
            'cycle_id' => $actionAdminDto->cycle_id,
            'action_type_id' => $actionAdminDto->action_type_id,
            'status' => $actionAdminDto->status,
            'remarks' => $actionAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(Action $action, ActionAdminDto $actionAdminDto)
    {
        return tap($action)->update([
            'cycle_id' => $actionAdminDto->cycle_id,
            'action_type_id' => $actionAdminDto->action_type_id,
            'status' => $actionAdminDto->status,
            'remarks' => $actionAdminDto->remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(Action $action)
    {
        return tap($action)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Action::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function updateStatus(Action $action, string $status, ?string $remarks = null)
    {
        return tap($action)->update([
            'status' => $status,
            'remarks' => $remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
}
