<?php

namespace Src\Wards\Service;

use Illuminate\Support\Facades\Auth;
use Src\Wards\DTO\WardAdminDto;
use Src\Wards\Models\Ward;

class WardAdminService
{
    public function store(WardAdminDto $wardAdminDto){
        return Ward::create([
            'id' => $wardAdminDto->id,
            'local_body_id' => $wardAdminDto->local_body_id,
            'phone' => $wardAdminDto->phone,
            'email' => $wardAdminDto->email,
            'address_en' => $wardAdminDto->address_en,
            'address_ne' => $wardAdminDto->address_ne,
            'ward_name_en' => $wardAdminDto->ward_name_en,
            'ward_name_ne' => $wardAdminDto->ward_name_ne,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Ward $ward, WardAdminDto $wardAdminDto){
        return tap($ward)->update([
            'local_body_id' => $wardAdminDto->local_body_id,
            'phone' => $wardAdminDto->phone,
            'email' => $wardAdminDto->email,
            'address_en' => $wardAdminDto->address_en,
            'address_ne' => $wardAdminDto->address_ne,
            'ward_name_en' => $wardAdminDto->ward_name_en,
            'ward_name_ne' => $wardAdminDto->ward_name_ne,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Ward $ward){
        return tap($ward)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Ward::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


