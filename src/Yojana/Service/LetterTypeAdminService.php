<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\LetterTypeAdminDto;
use Src\Yojana\Models\LetterType;

class LetterTypeAdminService
{
public function store(LetterTypeAdminDto $letterTypeAdminDto){
    return LetterType::create([
        'title' => $letterTypeAdminDto->title,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LetterType $letterType, LetterTypeAdminDto $letterTypeAdminDto){
    return tap($letterType)->update([
        'title' => $letterTypeAdminDto->title,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LetterType $letterType){
    return tap($letterType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LetterType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


