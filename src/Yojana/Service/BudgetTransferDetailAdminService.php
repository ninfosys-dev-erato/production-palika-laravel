<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetTransferDetailAdminDto;
use Src\Yojana\Models\BudgetTransferDetails;

class BudgetTransferDetailAdminService
{
    public function store(BudgetTransferDetailAdminDto $budgetTransferDetailDto){
        return BudgetTransferDetails::create([
            'budget_transfer_id' => $budgetTransferDetailDto->budget_transfer_id,
            'budget_source_id' => $budgetTransferDetailDto->budget_source_id,
            'amount' => $budgetTransferDetailDto->amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(BudgetTransferDetails $budgetTransferDetail, BudgetTransferDetailAdminDto $budgetTransferDetailDto){
        return tap($budgetTransferDetail)->update([
            'budget_transfer_id' => $budgetTransferDetailDto->budget_transfer_id,
            'budget_source_id' => $budgetTransferDetailDto->budget_source_id,
            'amount' => $budgetTransferDetailDto->amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(BudgetTransferDetails $budgetTransferDetail){
        return tap($budgetTransferDetail)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BudgetTransferDetails::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


