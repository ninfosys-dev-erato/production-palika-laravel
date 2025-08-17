<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantTypeAdminDto;
use Src\GrantManagement\Models\GrantType;

class GrantTypeAdminService
{
    public function store(GrantTypeAdminDto $grantTypeAdminDto)
    {
        return GrantType::create([
            'title' => $grantTypeAdminDto->title,
            'title_en' => $grantTypeAdminDto->title_en,
            'amount' => $grantTypeAdminDto->amount,
            'department' => $grantTypeAdminDto->department,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(GrantType $grantType, GrantTypeAdminDto $grantTypeAdminDto)
    {
        return tap($grantType)->update([
            'title' => $grantTypeAdminDto->title,
            'title_en' => $grantTypeAdminDto->title_en,
            'amount' => $grantTypeAdminDto->amount,
            'department' => $grantTypeAdminDto->department,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(GrantType $grantType)
    {
        return tap($grantType)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        GrantType::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
