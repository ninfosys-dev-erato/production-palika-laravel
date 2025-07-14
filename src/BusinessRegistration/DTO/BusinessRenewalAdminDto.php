<?php

namespace Src\BusinessRegistration\DTO;

use Src\BusinessRegistration\Models\BusinessRenewal;

class BusinessRenewalAdminDto
{
    public function __construct(
        public string  $fiscal_year_id,
        public string  $business_registration_id,
        public string  $renew_date,
        public string  $renew_date_en,
        public string  $date_to_be_maintained,
        public string  $date_to_be_maintained_en,
        public string  $renew_amount,
        public string  $penalty_amount,
        public ?string $payment_receipt,
        public ?string $payment_receipt_date,
        public ?string $payment_receipt_date_en,
        public string  $reg_no,
        public string  $registration_no
    )
    {
    }

    public static function fromLiveWireModel(BusinessRenewal $businessRenewal): BusinessRenewalAdminDto
    {
        return new self(
            fiscal_year_id: $businessRenewal->fiscal_year_id,
            business_registration_id: $businessRenewal->business_registration_id,
            renew_date: $businessRenewal->renew_date,
            renew_date_en: $businessRenewal->renew_date_en,
            date_to_be_maintained: $businessRenewal->date_to_be_maintained,
            date_to_be_maintained_en: $businessRenewal->date_to_be_maintained_en,
            renew_amount: $businessRenewal->renew_amount,
            penalty_amount: $businessRenewal->penalty_amount,
            payment_receipt: $businessRenewal->payment_receipt ?? null,
            payment_receipt_date: $businessRenewal->payment_receipt_date ?? null,
            payment_receipt_date_en: $businessRenewal->payment_receipt_date_en ?? null,
            reg_no: $businessRenewal->reg_no ?? null,
            registration_no: $businessRenewal->registration_no
        );
    }
}
