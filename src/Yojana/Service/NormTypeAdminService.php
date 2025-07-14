<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\NormTypeAdminDto;
use Src\Yojana\Models\NormType;

class NormTypeAdminService
{
public function store(NormTypeAdminDto $normTypeAdminDto){
    return NormType::create([
        'title' => $normTypeAdminDto->title,
        'authority_name' => $normTypeAdminDto->authority_name,
        'year' => $normTypeAdminDto->year,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(NormType $normType, NormTypeAdminDto $normTypeAdminDto){
    return tap($normType)->update([
        'title' => $normTypeAdminDto->title,
        'authority_name' => $normTypeAdminDto->authority_name,
        'year' => $normTypeAdminDto->year,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(NormType $normType){
    return tap($normType)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    NormType::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


