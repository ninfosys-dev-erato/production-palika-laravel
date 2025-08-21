<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\JudicialEmployeeAdminDto;
use Src\Ejalas\Models\JudicialEmployee;

class JudicialEmployeeAdminService
{
    public function store(JudicialEmployeeAdminDto $judicialEmployeeAdminDto)
    {
        return JudicialEmployee::create([
            'name' => $judicialEmployeeAdminDto->name,
            'ward_id' => $judicialEmployeeAdminDto->ward_id,
            'level_id' => $judicialEmployeeAdminDto->level_id,
            'designation_id' => $judicialEmployeeAdminDto->designation_id,
            'join_date' => $judicialEmployeeAdminDto->join_date,
            'phone_no' => $judicialEmployeeAdminDto->phone_no,
            'email' => $judicialEmployeeAdminDto->email,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(JudicialEmployee $judicialEmployee, JudicialEmployeeAdminDto $judicialEmployeeAdminDto)
    {
        return tap($judicialEmployee)->update([
            'name' => $judicialEmployeeAdminDto->name,
            'ward_id' => $judicialEmployeeAdminDto->ward_id,
            'level_id' => $judicialEmployeeAdminDto->level_id,
            'designation_id' => $judicialEmployeeAdminDto->designation_id,
            'join_date' => $judicialEmployeeAdminDto->join_date,
            'phone_no' => $judicialEmployeeAdminDto->phone_no,
            'email' => $judicialEmployeeAdminDto->email,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(JudicialEmployee $judicialEmployee)
    {
        return tap($judicialEmployee)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        JudicialEmployee::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
