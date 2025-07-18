<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ExpenseHeadAdminDto;
use Src\Yojana\Models\ExpenseHead;

class ExpenseHeadAdminService
{
public function store(ExpenseHeadAdminDto $expenseHeadAdminDto){
    return ExpenseHead::create([
        'title' => $expenseHeadAdminDto->title,
        'type' => $expenseHeadAdminDto->type,
        'code' => $expenseHeadAdminDto->code,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ExpenseHead $expenseHead, ExpenseHeadAdminDto $expenseHeadAdminDto){
    return tap($expenseHead)->update([
        'title' => $expenseHeadAdminDto->title,
        'type' => $expenseHeadAdminDto->type,
        'code' => $expenseHeadAdminDto->code,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ExpenseHead $expenseHead){
    return tap($expenseHead)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ExpenseHead::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


