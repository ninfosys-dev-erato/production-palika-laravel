<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\BusinessDeregistration;

class BusinessDeRegistrationDto
{
    public function __construct(
        public ?int $brs_registration_data_id = null,
        public ?string $fiscal_year = null,
        public ?string $application_date = null,
        public ?string $application_date_en = null,
        public ?array $data,
        public ?string $amount = null,
        public ?string $application_rejection_reason = null,
        public ?string $bill_no = null,
        public ?string $registration_number = null,
        public ?string $application_status = null,
        public ?int $created_by = null,
        public ?int $updated_by = null,
        public ?string $deleted_at = null,
        public ?int $deleted_by = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?int $registration_type_id = null,
    ) {}

    public static function fromLiveWireModel(BusinessDeregistration $model): self
    {
        return new self(
            brs_registration_data_id: $model->brs_registration_data_id,
            fiscal_year: $model->fiscal_year,
            application_date: $model->application_date,
            application_date_en: $model->application_date_en,
            data: $model->data,
            amount: $model->amount,
            application_rejection_reason: $model->application_rejection_reason,
            bill_no: $model->bill_no,
            registration_number: $model->registration_number,
            application_status: $model->application_status,
            created_by: $model->created_by,
            updated_by: $model->updated_by,
            deleted_at: $model->deleted_at,
            deleted_by: $model->deleted_by,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            registration_type_id: $model->registration_type_id,
        );
    }
}
