<?php

namespace Src\Ejalas\Service;

use App\Facades\FileTrackingFacade;
use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\DisputeRegistrationCourtAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeRegistrationCourt;

class DisputeRegistrationCourtAdminService
{
    public function store(DisputeRegistrationCourtAdminDto $disputeRegistrationCourtAdminDto)
    {
        $complainRegistration = ComplaintRegistration::findOrFail($disputeRegistrationCourtAdminDto->complaint_registration_id);

        // Set complaint registration status based on dispute registration court status
        $complaintStatus = ($disputeRegistrationCourtAdminDto->status === 'Approved') ? true : false;

        $complainRegistration->update([
            'status' => $complaintStatus,
        ]);
        FileTrackingFacade::recordFile($complainRegistration);

        return DisputeRegistrationCourt::create([
            'complaint_registration_id' => $disputeRegistrationCourtAdminDto->complaint_registration_id,
            'registrar_id' => $disputeRegistrationCourtAdminDto->registrar_id,
            'status' => $disputeRegistrationCourtAdminDto->status,
            'is_details_provided' => $disputeRegistrationCourtAdminDto->is_details_provided,
            'decision_date' => $disputeRegistrationCourtAdminDto->decision_date,
            'registration_indicator' => $disputeRegistrationCourtAdminDto->registration_indicator,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(DisputeRegistrationCourt $disputeRegistrationCourt, DisputeRegistrationCourtAdminDto $disputeRegistrationCourtAdminDto)
    {
        $complainRegistration = ComplaintRegistration::findOrFail($disputeRegistrationCourtAdminDto->complaint_registration_id);

        // Set complaint registration status based on dispute registration court status
        $complaintStatus = ($disputeRegistrationCourtAdminDto->status === 'Approved') ? true : false;

        $complainRegistration->update([
            'status' => $complaintStatus,
        ]);
        FileTrackingFacade::recordFile($complainRegistration);

        return tap($disputeRegistrationCourt)->update([
            'complaint_registration_id' => $disputeRegistrationCourtAdminDto->complaint_registration_id,
            'registrar_id' => $disputeRegistrationCourtAdminDto->registrar_id,
            'status' => $disputeRegistrationCourtAdminDto->status,
            'decision_date' => $disputeRegistrationCourtAdminDto->decision_date,
            'is_details_provided' => $disputeRegistrationCourtAdminDto->is_details_provided,
            'registration_indicator' => $disputeRegistrationCourtAdminDto->registration_indicator,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(DisputeRegistrationCourt $disputeRegistrationCourt)
    {
        return tap($disputeRegistrationCourt)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        DisputeRegistrationCourt::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
