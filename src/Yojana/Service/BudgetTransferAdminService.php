<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetTransferAdminDto;
use Src\Yojana\Models\BudgetTransfer;

class BudgetTransferAdminService
{
    public function store(BudgetTransferAdminDto $budgetTransferAdminDto){
        return BudgetTransfer::create([
            'from_plan' => $budgetTransferAdminDto->from_plan,
            'to_plan' => $budgetTransferAdminDto->to_plan,
            'amount' => $budgetTransferAdminDto->amount,
            'date' => date('Y-m-d H:i:s'),
            'user' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(BudgetTransfer $budgetTransfer, BudgetTransferAdminDto $budgetTransferAdminDto){
        return tap($budgetTransfer)->update([
            'from_plan' => $budgetTransferAdminDto->from_plan,
            'to_plan' => $budgetTransferAdminDto->to_plan,
            'amount' => $budgetTransferAdminDto->amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(BudgetTransfer $budgetTransfer){
         tap($budgetTransfer)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BudgetTransfer::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


