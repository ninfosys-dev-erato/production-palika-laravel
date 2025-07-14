<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\BudgetSourceAdminDto;
use Src\Yojana\Models\BudgetSource;

class BudgetSourceAdminService
{
public function store(BudgetSourceAdminDto $budgetSourceAdminDto){
    return BudgetSource::create([
        'title' => $budgetSourceAdminDto->title,
        'code' => $budgetSourceAdminDto->code,
        'level_id' => $budgetSourceAdminDto->level_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(BudgetSource $budgetSource, BudgetSourceAdminDto $budgetSourceAdminDto){
    return tap($budgetSource)->update([
        'title' => $budgetSourceAdminDto->title,
        'code' => $budgetSourceAdminDto->code,
        'level_id' => $budgetSourceAdminDto->level_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(BudgetSource $budgetSource){
    return tap($budgetSource)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    BudgetSource::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


