<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ApplicationAdminDto;
use Src\Yojana\Models\Application;

class ApplicationAdminService
{
public function store(ApplicationAdminDto $applicationAdminDto){
    return Application::create([
        'applicant_name' => $applicationAdminDto->applicant_name,
        'address' => $applicationAdminDto->address,
        'mobile_number' => $applicationAdminDto->mobile_number,
        'bank_id' => $applicationAdminDto->bank_id,
        'account_number' => $applicationAdminDto->account_number,
        'is_employee' => $applicationAdminDto->is_employee,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Application $application, ApplicationAdminDto $applicationAdminDto){
    return tap($application)->update([
        'applicant_name' => $applicationAdminDto->applicant_name,
        'address' => $applicationAdminDto->address,
        'mobile_number' => $applicationAdminDto->mobile_number,
        'bank_id' => $applicationAdminDto->bank_id,
        'account_number' => $applicationAdminDto->account_number,
        'is_employee' => $applicationAdminDto->is_employee,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Application $application){
    return tap($application)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Application::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


