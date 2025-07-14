<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetDetailAdminDto;
use Src\Yojana\Models\BudgetDetail;

class BudgetDetailAdminService
{
public function store(BudgetDetailAdminDto $budgetDetailAdminDto){
    return BudgetDetail::create([
        'ward_id' => $budgetDetailAdminDto->ward_id,
        'amount' => $budgetDetailAdminDto->amount,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BudgetDetail $budgetDetail, BudgetDetailAdminDto $budgetDetailAdminDto){
    return tap($budgetDetail)->update([
        'ward_id' => $budgetDetailAdminDto->ward_id,
        'amount' => $budgetDetailAdminDto->amount,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BudgetDetail $budgetDetail){
    return tap($budgetDetail)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BudgetDetail::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


