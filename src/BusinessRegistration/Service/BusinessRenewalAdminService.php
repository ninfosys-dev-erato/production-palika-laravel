<?php

namespace Src\BusinessRegistration\Service;

use App\Facades\PdfFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessRenewalAdminDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;

class BusinessRenewalAdminService
{

    use SessionFlash, BusinessRegistrationTemplate;
    public function store(BusinessRenewalAdminDto $dto)
    {
        return BusinessRenewal::create([
            'fiscal_year_id' => $dto->fiscal_year_id,
            'business_registration_id' => $dto->business_registration_id,
            'renew_date' => $dto->renew_date,
            'renew_date_en' => $dto->renew_date_en,
            'date_to_be_maintained' => $dto->date_to_be_maintained,
            'date_to_be_maintained_en' => $dto->date_to_be_maintained_en,
            'renew_amount' => $dto->renew_amount,
            'penalty_amount' => $dto->penalty_amount,
            'payment_receipt' => $dto->payment_receipt,
            'payment_receipt_date' => $dto->payment_receipt_date,
            'payment_receipt_date_en' => $dto->payment_receipt_date_en,
            'reg_no' => $dto->reg_no,
            'registration_no' => $dto->registration_no,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(BusinessRenewal $businessRenewal, BusinessRenewalAdminDto $dto)
    {
        return tap($businessRenewal)->update([
            'fiscal_year_id' => $dto->fiscal_year_id,
            'business_registration_id' => $dto->business_registration_id,
            'renew_date' => $dto->renew_date,
            'renew_date_en' => $dto->renew_date_en,
            'date_to_be_maintained' => $dto->date_to_be_maintained,
            'date_to_be_maintained_en' => $dto->date_to_be_maintained_en,
            'renew_amount' => $dto->renew_amount,
            'penalty_amount' => $dto->penalty_amount,
            'payment_receipt' => $dto->payment_receipt,
            'payment_receipt_date' => $dto->payment_receipt_date,
            'payment_receipt_date_en' => $dto->payment_receipt_date_en,
            'reg_no' => $dto->reg_no,
            'registration_no' => $dto->registration_no,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(BusinessRenewal $businessRenewal)
    {
        return tap($businessRenewal)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BusinessRenewal::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function sentForPayment(BusinessRenewal $businessRenewal): BusinessRenewal
    {
        tap($businessRenewal)->update([
            'renew_amount' => $businessRenewal->renew_amount,
            'penalty_amount' => $businessRenewal->penalty_amount,
            'application_status' => $businessRenewal->application_status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);

        return $businessRenewal;
    }

    public function uploadBill(BusinessRenewal $businessRenewal, bool $admin = true)
    {
        $businessRenewal = tap($businessRenewal)->update([
            'payment_receipt' => $businessRenewal->payment_receipt,
            'application_status' => ApplicationStatusEnum::BILL_UPLOADED->value,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $admin ? Auth::user()->id : Auth::guard('customer')->id(),
        ]);

        return $businessRenewal;
    }

    public function approveRenewal(BusinessRenewal $businessRenewal)
    {
        $businessRenewal = tap($businessRenewal)->update([
            'renew_date' => $businessRenewal->renew_date,
            'bill_no' => $businessRenewal->bill_no,
            'renew_date_en' => $businessRenewal->renew_date_en,
            'date_to_be_maintained_en' => $businessRenewal->date_to_be_maintained_en,
            'date_to_be_maintained' => $businessRenewal->date_to_be_maintained,
            'payment_receipt_date_en' => $businessRenewal->payment_receipt_date_en,
            'payment_receipt_date' => $businessRenewal->payment_receipt_date,
            'application_status' => $businessRenewal->application_status,
            'approved_by' =>Auth::user()->id,
            'approved_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);

        return $businessRenewal;
    }

    public function getLetter(BusinessRenewal $businessRenewal, string $renewalTemplate, $request = 'web')
    {
        $registrationTemplate = $this->resolveTemplate($businessRenewal->registration);
        $data = $registrationTemplate. $renewalTemplate;
        try {

            $html = $data;
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.BusinessRegistration.businessRegistration.certificate'),
                file_name: "recommendation_{$businessRenewal->id}",
                disk: "local",
                styles:$businessRenewal->registration->registrationType?->form?->styles??""

            );
          
            if ($request === 'web') {
                return redirect()->away($url);
            }
            
            return $url;  
           
        }catch(\Exception $exception){
            logger($exception);
            $this->errorFlash(__("Please fill customer KYC to move forward!"));
        }
}
}
