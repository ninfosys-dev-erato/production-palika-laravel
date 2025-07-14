<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\SettlementDetailAdminDto;
use Src\Ejalas\Models\SettlementDetail;

class SettlementDetailAdminService
{
    public function store(SettlementDetailAdminDto $settlementDetailAdminDto)
    {

        return SettlementDetail::create([
            'complaint_registration_id' => $settlementDetailAdminDto->complaint_registration_id,
            'party_id' => $settlementDetailAdminDto->party_id,
            'deadline_set_date' => $settlementDetailAdminDto->deadline_set_date,
            'detail' => $settlementDetailAdminDto->detail,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(SettlementDetail $settlementDetail, SettlementDetailAdminDto $settlementDetailAdminDto)
    {
        return tap($settlementDetail)->update([
            'complaint_registration_id' => $settlementDetailAdminDto->complaint_registration_id,
            'party_id' => $settlementDetailAdminDto->party_id,
            'detail' => $settlementDetailAdminDto->detail,
            'deadline_set_date' => $settlementDetailAdminDto->deadline_set_date,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(SettlementDetail $settlementDetail)
    {
        return tap($settlementDetail)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        SettlementDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
