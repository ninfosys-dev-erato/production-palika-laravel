<?php

namespace Src\BusinessRegistration\Service;

use App\Facades\FileTrackingFacade;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationDto;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationUploadDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessDeregistration;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;

class BusinessDeRegistrationService
{
    use HelperDate;
    public function store(BusinessDeRegistrationDto $dto): BusinessDeregistration|bool
    {
        $businessDeRegistration = BusinessDeregistration::create([
            'brs_registration_data_id' => $dto->brs_registration_data_id,
            'fiscal_year' => $dto->fiscal_year,
            'application_date' => $dto->application_date,
            'application_date_en' => $dto->application_date_en,
            'amount' => $dto->amount,
            'application_rejection_reason' => $dto->application_rejection_reason,
            'bill_no' => $dto->bill_no,
            'registration_number' => $dto->registration_number,
            'data' =>    json_encode($dto->data),
            'application_status' => $dto->application_status,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()?->id,
            'registration_type_id' => $dto->registration_type_id,
            'application_status' => ApplicationStatusEnum::PENDING,
            'registration_type_id' => $dto->registration_type_id,
            'bill' => $dto->bill,
        ]);

        // Update related BusinessRegistration status to pending
        if ($businessDeRegistration && $businessDeRegistration->businessRegistration) {
            $businessDeRegistration->businessRegistration->business_status = BusinessStatusEnum::INACTIVE->value;
            $businessDeRegistration->businessRegistration->save();
        }

        return $businessDeRegistration;
    }

    public function update(BusinessDeregistration $model, BusinessDeRegistrationDto $dto): BusinessDeregistration|bool
    {
        $model = tap($model)->update([
            'brs_registration_data_id' => $dto->brs_registration_data_id,
            'fiscal_year' => $dto->fiscal_year,
            'application_date' => $dto->application_date,
            'application_date_en' => $dto->application_date_en,
            'data' =>    json_encode($dto->data),
            'amount' => $dto->amount,
            'application_rejection_reason' => $dto->application_rejection_reason,
            'bill_no' => $dto->bill_no,
            'registration_number' => $dto->registration_number,
            'application_status' => $dto->application_status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()?->id,
            'registration_type_id' => $dto->registration_type_id,
            'registration_type_id' => $dto->registration_type_id,
            'bill' => $dto->bill,
        ]);
        return $model;
    }

    public function delete(BusinessDeregistration $model): BusinessDeregistration|bool
    {
        $model = tap($model)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()?->id,
        ]);
        return $model;
    }

    public function sentForPayment(BusinessDeRegistration $businessDeRegistration): BusinessDeRegistration
    {

        FileTrackingFacade::recordFile($businessDeRegistration);
        tap($businessDeRegistration)->update([
            'amount' => $businessDeRegistration->amount,
            'application_status' => $businessDeRegistration->application_status,
            'rejected_by' => null,
            'application_rejection_reason' => null,
            'rejected_at' => null,
        ]);

        return $businessDeRegistration;
    }

    public function uploadBill(BusinessDeRegistration $businessDeRegistration, BusinessDeRegistrationUploadDto $dto, bool $admin = true): BusinessDeRegistration
    {
        FileTrackingFacade::recordFile($businessDeRegistration, $admin);

        tap($businessDeRegistration)->update([
            'bill' => $dto->bill,
            'application_status' => $businessDeRegistration->application_status,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);

        return $businessDeRegistration;
    }
    public function generateBusinessDeRegistrationNumber()
    {
        $fiscalYear = $this->convertNepaliToEnglish(getSetting('fiscal-year'));

        $lastRegistration = BusinessDeRegistration::latest('id')->first();

        $newNumber = str_pad($lastRegistration->id + 1, 6, '0', STR_PAD_LEFT);

        $newRegistrationNumber = $newNumber . '/' . $fiscalYear;

        return $newRegistrationNumber;
    }

    public function accept(BusinessDeRegistration $businessDeRegistration, array $data): BusinessDeRegistration
    {
        FileTrackingFacade::recordFile($businessDeRegistration);
        tap($businessDeRegistration)->update([
            'application_status' => ApplicationStatusEnum::ACCEPTED->value,
            'rejected_by' => null,
            'application_rejection_reason' => null,
            'rejected_at' => null,
            'registration_number' => $data['registration_number'],
            'registration_date' => replaceNumbers($this->adToBs(date('Y-m-d')), true),
            'registration_date_en' => date('Y-m-d'),
            'certificate_number' => $data['certificate_number'],
            'bill_no' => $data['bill_no'],
            'approved_at' => now(),
            'approved_by' => Auth::user()->id,
        ]);
        return $businessDeRegistration;
    }

    public function reject(BusinessDeRegistration $businessDeRegistration, BusinessDeRegistrationUploadDto $businessRegistrationUploadDto)
    {
        FileTrackingFacade::recordFile($businessDeRegistration);
        $resone = tap($businessDeRegistration)->update([
            'rejected_by' => Auth::user()->id,
            'application_rejection_reason' => $businessRegistrationUploadDto->application_rejection_reason,
            'rejected_at' => now(),
            'application_status' => ApplicationStatusEnum::REJECTED->value
        ]);

        return $businessDeRegistration;
    }
}
