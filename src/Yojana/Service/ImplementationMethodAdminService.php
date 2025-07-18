<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ImplementationMethodAdminDto;
use Src\Yojana\Models\ImplementationMethod;

class ImplementationMethodAdminService
{
public function store(ImplementationMethodAdminDto $implementationMethodAdminDto){
    return ImplementationMethod::create([
        'title' => $implementationMethodAdminDto->title,
        'code' => $implementationMethodAdminDto->code,
        'model' => $implementationMethodAdminDto->model,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ImplementationMethod $implementationMethod, ImplementationMethodAdminDto $implementationMethodAdminDto){
    return tap($implementationMethod)->update([
        'title' => $implementationMethodAdminDto->title,
        'code' => $implementationMethodAdminDto->code,
        'model' => $implementationMethodAdminDto->model,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ImplementationMethod $implementationMethod){
    return tap($implementationMethod)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ImplementationMethod::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


