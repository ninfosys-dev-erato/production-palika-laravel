<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessDeRegistrationDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessDeregistration;

class BusinessDeRegistrationService
{
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
            'application_status' => ApplicationStatusEnum::PENDING->value,

        ]);

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
            'application_status' => ApplicationStatusEnum::PENDING->value,
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
}
