<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetHeadAdminDto;
use Src\Yojana\Models\BudgetHead;

class BudgetHeadAdminService
{
    public function store(BudgetHeadAdminDto $budgetHeadAdminDto)
    {
        return BudgetHead::create([

            'title' => $budgetHeadAdminDto->title,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(BudgetHead $budgetHead, BudgetHeadAdminDto $budgetHeadAdminDto)
    {
        return tap($budgetHead)->update([
            'title' => $budgetHeadAdminDto->title,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(BudgetHead $budgetHead)
    {
        return tap($budgetHead)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BudgetHead::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
