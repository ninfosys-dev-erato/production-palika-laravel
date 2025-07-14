<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\RegistrationIndicatorAdminDto;
use Src\Ejalas\Models\RegistrationIndicator;

class RegistrationIndicatorAdminService
{
public function store(RegistrationIndicatorAdminDto $registrationIndicatorAdminDto){
    return RegistrationIndicator::create([
        'dispute_title' => $registrationIndicatorAdminDto->dispute_title,
        'indicator_type' => $registrationIndicatorAdminDto->indicator_type,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(RegistrationIndicator $registrationIndicator, RegistrationIndicatorAdminDto $registrationIndicatorAdminDto){
    return tap($registrationIndicator)->update([
        'dispute_title' => $registrationIndicatorAdminDto->dispute_title,
        'indicator_type' => $registrationIndicatorAdminDto->indicator_type,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(RegistrationIndicator $registrationIndicator){
    return tap($registrationIndicator)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    RegistrationIndicator::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


