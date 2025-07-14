<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\OrganizationDetailDto;
use Src\Ebps\Models\OrganizationDetail;

class OrganizationDetailService
{
    public function store(OrganizationDetailDto $organizationDetailDto)
    {
        return OrganizationDetail::create([
            'parent_id' => $organizationDetailDto->parent_id,
            'map_apply_id' => $organizationDetailDto->map_apply_id,
            'registration_date' => $organizationDetailDto->registration_date,
            'organization_id' => $organizationDetailDto->organization_id,
            'name' => $organizationDetailDto->name,
            'contact_no' => $organizationDetailDto->contact_no,
            'email' => $organizationDetailDto->email,
            'reason_of_organization_change' => $organizationDetailDto->reason_of_organization_change,
            'status' => $organizationDetailDto->status,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::id(),
        ]);
    }

    public function update(OrganizationDetail $organizationDetail, OrganizationDetailDto $organizationDetailDto)
    {
        return tap($organizationDetail)->update([
            'parent_id' => $organizationDetailDto->parent_id,
            'map_apply_id' => $organizationDetailDto->map_apply_id,
            'organization_id' => $organizationDetailDto->organization_id,
            'name' => $organizationDetailDto->name,
            'contact_no' => $organizationDetailDto->contact_no,
            'email' => $organizationDetailDto->email,
            'reason_of_organization_change' => $organizationDetailDto->reason_of_organization_change,
            'status' => $organizationDetailDto->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::id(),
        ]);
    }

    public function delete(OrganizationDetail $organizationDetail)
    {
        return tap($organizationDetail)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::id(),
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        OrganizationDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::id(),
        ]);
    }
}
