<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\HouseOwnerDetailDto;
use Src\Ebps\Models\HouseOwnerDetail;

class HouseOwnerDetailService
{
    public function store(HouseOwnerDetailDto $dto)
    {
        return HouseOwnerDetail::create([
            'owner_name' => $dto->owner_name,
            'mobile_no' => $dto->mobile_no,
            'father_name' => $dto->father_name,
            'grandfather_name' => $dto->grandfather_name,
            'citizenship_no' => $dto->citizenship_no,
            'citizenship_issued_date' => $dto->citizenship_issued_date,
            'citizenship_issued_at' => $dto->citizenship_issued_at,
            'province_id' => $dto->province_id,
            'district_id' => $dto->district_id,
            'local_body_id' => $dto->local_body_id,
            'ward_no' => $dto->ward_no,
            'tole' => $dto->tole,
            'photo' => $dto->photo,
            'ownership_type' => $dto->ownership_type,
            'parent_id' => $dto->parent_id,
            'reason_of_owner_change' => $dto->reason_of_owner_change,
            'status' => $dto->status,
            'created_at' => now(),
        ]);
    }

    public function update(HouseOwnerDetail $model, HouseOwnerDetailDto $dto)
    {
        return tap($model)->update([
            'owner_name' => $dto->owner_name,
            'mobile_no' => $dto->mobile_no,
            'father_name' => $dto->father_name,
            'grandfather_name' => $dto->grandfather_name,
            'citizenship_no' => $dto->citizenship_no,
            'citizenship_issued_date' => $dto->citizenship_issued_date,
            'citizenship_issued_at' => $dto->citizenship_issued_at,
            'province_id' => $dto->province_id,
            'district_id' => $dto->district_id,
            'local_body_id' => $dto->local_body_id,
            'ward_no' => $dto->ward_no,
            'tole' => $dto->tole,
            'photo' => $dto->photo,
            'ownership_type' => $dto->ownership_type,
            'parent_id' => $dto->parent_id,
            'status' => $dto->status,
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);
    }

    public function delete(HouseOwnerDetail $model)
    {
        return tap($model)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));

        HouseOwnerDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }
}
