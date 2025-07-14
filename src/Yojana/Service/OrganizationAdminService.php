<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\OrganizationAdminDto;
use Src\Yojana\Models\Organization;

class OrganizationAdminService
{
    public function store(OrganizationAdminDto $organizationAdminDto): Organization
    {
        return Organization::create([
            'type' => $organizationAdminDto->type,
            'name' => $organizationAdminDto->name,
            'address' => $organizationAdminDto->address,
            'pan_number' => $organizationAdminDto->pan_number,
            'phone_number' => $organizationAdminDto->phone_number,
            'bank_name' => $organizationAdminDto->bank_name,
            'branch' => $organizationAdminDto->branch,
            'account_number' => $organizationAdminDto->account_number,
            'representative' => $organizationAdminDto->representative,
            'post' => $organizationAdminDto->post,
            'representative_address' => $organizationAdminDto->representative_address,
            'mobile_number' => $organizationAdminDto->mobile_number,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(Organization $organization, OrganizationAdminDto $organizationAdminDto): Organization
    {
        return tap($organization)->update([
            'type' => $organizationAdminDto->type,
            'name' => $organizationAdminDto->name,
            'address' => $organizationAdminDto->address,
            'pan_number' => $organizationAdminDto->pan_number,
            'phone_number' => $organizationAdminDto->phone_number,
            'bank_name' => $organizationAdminDto->bank_name,
            'branch' => $organizationAdminDto->branch,
            'account_number' => $organizationAdminDto->account_number,
            'representative' => $organizationAdminDto->representative,
            'post' => $organizationAdminDto->post,
            'representative_address' => $organizationAdminDto->representative_address,
            'mobile_number' => $organizationAdminDto->mobile_number,
            'updated_at' => now(),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(Organization $organization): Organization
    {
        return tap($organization)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): bool
    {
        try {
            $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
            Organization::whereIn('id', $numericIds)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


