<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetSourceLogDto;
use Src\Yojana\Models\BudgetSourcePaymentLog;

class BudgetSourceLogAdminService
{
    public function store(BudgetSourceLogDto $budgetSourceLogDto){
        return BudgetSourcePaymentLog::create([
            'payment_id' => $budgetSourceLogDto->payment_id,
            'plan_budget_source_id' => $budgetSourceLogDto->plan_budget_source_id,
            'amount' => $budgetSourceLogDto->amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(BudgetSourcePaymentLog $budgetSourceLog, BudgetSourceLogDto $budgetSourceLogDto){
        return tap($budgetSourceLog)->update([
            'payment_id' => $budgetSourceLogDto->payment_id,
            'plan_budget_source_id' => $budgetSourceLogDto->plan_budget_source_id,
            'amount' => $budgetSourceLogDto->amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(BudgetSourcePaymentLog $budgetSourceLog){
        return tap($budgetSourceLog)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BudgetSourcePaymentLog::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


