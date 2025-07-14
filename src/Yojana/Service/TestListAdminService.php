<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\TestListAdminDto;
use Src\Yojana\Models\TestList;

class TestListAdminService
{
public function store(TestListAdminDto $testListAdminDto){
    return TestList::create([
        'title' => $testListAdminDto->title,
        'type' => $testListAdminDto->type,
        'is_for_agreement' => $testListAdminDto->is_for_agreement,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TestList $testList, TestListAdminDto $testListAdminDto){
    return tap($testList)->update([
        'title' => $testListAdminDto->title,
        'type' => $testListAdminDto->type,
        'is_for_agreement' => $testListAdminDto->is_for_agreement,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TestList $testList){
    return tap($testList)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TestList::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


