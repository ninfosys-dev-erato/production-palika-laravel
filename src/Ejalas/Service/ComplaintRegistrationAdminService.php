<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\ComplaintRegistrationAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;

class ComplaintRegistrationAdminService
{
    public function store(ComplaintRegistrationAdminDto $complaintRegistrationAdminDto)
    {
        return ComplaintRegistration::create([
            'fiscal_year_id' => $complaintRegistrationAdminDto->fiscal_year_id,
            'reg_no' => $complaintRegistrationAdminDto->reg_no,
            'old_reg_no' => $complaintRegistrationAdminDto->old_reg_no,
            'reg_date' => $complaintRegistrationAdminDto->reg_date,
            'reg_address' => $complaintRegistrationAdminDto->reg_address,
            'complainer_id' => $complaintRegistrationAdminDto->complainer_id,
            'defender_id' => $complaintRegistrationAdminDto->defender_id,
            'priority_id' => $complaintRegistrationAdminDto->priority_id,
            'dispute_matter_id' => $complaintRegistrationAdminDto->dispute_matter_id,
            'subject' => $complaintRegistrationAdminDto->subject,
            'description' => $complaintRegistrationAdminDto->description,
            'claim_request' => $complaintRegistrationAdminDto->claim_request,
            'status' => $complaintRegistrationAdminDto->status,
            'reconciliation_center_id' => $complaintRegistrationAdminDto->reconciliation_center_id,
            'reconciliation_reg_no' => $complaintRegistrationAdminDto->reconciliation_reg_no,
            'ward_no' => GlobalFacade::ward() ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(ComplaintRegistration $complaintRegistration, ComplaintRegistrationAdminDto $complaintRegistrationAdminDto)
    {
        return tap($complaintRegistration)->update([
            'fiscal_year_id' => $complaintRegistrationAdminDto->fiscal_year_id,
            'reg_no' => $complaintRegistrationAdminDto->reg_no,
            'old_reg_no' => $complaintRegistrationAdminDto->old_reg_no,
            'reg_date' => $complaintRegistrationAdminDto->reg_date,
            'reg_address' => $complaintRegistrationAdminDto->reg_address,
            'complainer_id' => $complaintRegistrationAdminDto->complainer_id,
            'defender_id' => $complaintRegistrationAdminDto->defender_id,
            'priority_id' => $complaintRegistrationAdminDto->priority_id,
            'dispute_matter_id' => $complaintRegistrationAdminDto->dispute_matter_id,
            'subject' => $complaintRegistrationAdminDto->subject,
            'description' => $complaintRegistrationAdminDto->description,
            'claim_request' => $complaintRegistrationAdminDto->claim_request,
            'status' => $complaintRegistrationAdminDto->status,
            'reconciliation_center_id' => $complaintRegistrationAdminDto->reconciliation_center_id,
            'reconciliation_reg_no' => $complaintRegistrationAdminDto->reconciliation_reg_no,
            'ward_no' => $complaintRegistrationAdminDto->ward_no,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(ComplaintRegistration $complaintRegistration)
    {
        return tap($complaintRegistration)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        ComplaintRegistration::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
