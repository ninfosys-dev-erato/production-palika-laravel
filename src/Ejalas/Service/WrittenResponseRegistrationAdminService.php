<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\WrittenResponseRegistrationAdminDto;
use Src\Ejalas\Models\WrittenResponseRegistration;

class WrittenResponseRegistrationAdminService
{
    public function store(WrittenResponseRegistrationAdminDto $writtenResponseRegistrationAdminDto)
    {
        return WrittenResponseRegistration::create([
            'response_registration_no' => $writtenResponseRegistrationAdminDto->response_registration_no,
            'complaint_registration_id' => $writtenResponseRegistrationAdminDto->complaint_registration_id,
            'registration_date' => $writtenResponseRegistrationAdminDto->registration_date,
            'fee_amount' => $writtenResponseRegistrationAdminDto->fee_amount,
            'fee_receipt_no' => $writtenResponseRegistrationAdminDto->fee_receipt_no,
            'fee_paid_date' => $writtenResponseRegistrationAdminDto->fee_paid_date,
            'description' => $writtenResponseRegistrationAdminDto->description,
            'claim_request' => $writtenResponseRegistrationAdminDto->claim_request,
            'submitted_within_deadline' => $writtenResponseRegistrationAdminDto->submitted_within_deadline,
            'fee_receipt_attached' => $writtenResponseRegistrationAdminDto->fee_receipt_attached,
            'fee_receipt_attached' => $writtenResponseRegistrationAdminDto->fee_receipt_attached,
            'registration_indicator' => $writtenResponseRegistrationAdminDto->registration_indicator,
            'status' => $writtenResponseRegistrationAdminDto->status,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(WrittenResponseRegistration $writtenResponseRegistration, WrittenResponseRegistrationAdminDto $writtenResponseRegistrationAdminDto)
    {
        return tap($writtenResponseRegistration)->update([
            'response_registration_no' => $writtenResponseRegistrationAdminDto->response_registration_no,
            'complaint_registration_id' => $writtenResponseRegistrationAdminDto->complaint_registration_id,
            'registration_date' => $writtenResponseRegistrationAdminDto->registration_date,
            'fee_amount' => $writtenResponseRegistrationAdminDto->fee_amount,
            'fee_receipt_no' => $writtenResponseRegistrationAdminDto->fee_receipt_no,
            'fee_paid_date' => $writtenResponseRegistrationAdminDto->fee_paid_date,
            'description' => $writtenResponseRegistrationAdminDto->description,
            'claim_request' => $writtenResponseRegistrationAdminDto->claim_request,
            'submitted_within_deadline' => $writtenResponseRegistrationAdminDto->submitted_within_deadline,
            'fee_receipt_attached' => $writtenResponseRegistrationAdminDto->fee_receipt_attached,
            'registration_indicator' => $writtenResponseRegistrationAdminDto->registration_indicator,
            'status' => $writtenResponseRegistrationAdminDto->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(WrittenResponseRegistration $writtenResponseRegistration)
    {
        return tap($writtenResponseRegistration)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        WrittenResponseRegistration::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
