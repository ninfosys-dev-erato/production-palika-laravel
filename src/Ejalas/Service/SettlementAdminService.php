<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\SettlementAdminDto;
use Src\Ejalas\Models\Settlement;

class SettlementAdminService
{
    public function store(SettlementAdminDto $settlementAdminDto)
    {
        return Settlement::create([
            'complaint_registration_id' => $settlementAdminDto->complaint_registration_id,
            'discussion_date' => $settlementAdminDto->discussion_date,
            'settlement_date' => $settlementAdminDto->settlement_date,
            'present_members' => $settlementAdminDto->present_members,
            'settlement_details' => $settlementAdminDto->settlement_details,
            'reconciliation_center_id' => $settlementAdminDto->reconciliation_center_id,
            'is_settled' => $settlementAdminDto->is_settled,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Settlement $settlement, SettlementAdminDto $settlementAdminDto)
    {
        return tap($settlement)->update([
            'complaint_registration_id' => $settlementAdminDto->complaint_registration_id,
            'discussion_date' => $settlementAdminDto->discussion_date,
            'settlement_date' => $settlementAdminDto->settlement_date,
            'present_members' => $settlementAdminDto->present_members,
            'reconciliation_center_id' => $settlementAdminDto->reconciliation_center_id,
            'settlement_details' => $settlementAdminDto->settlement_details,
            'is_settled' => $settlementAdminDto->is_settled,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Settlement $settlement)
    {
        return tap($settlement)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Settlement::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
