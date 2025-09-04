<?php

namespace Src\Customers\Service;

use App\Jobs\CustomerKycLogJob;
use Illuminate\Support\Facades\Hash;
use Src\Customers\Notifications\CustomerRegistrationNotification;
use Src\Customers\Notifications\KycVerificationNotification;
use Illuminate\Support\Facades\Auth;
use Src\Customers\DTO\CustomerAdminDto;
use Src\Customers\DTO\CustomerKycDto;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Models\Customer;
use Src\Customers\Models\CustomerKyc;
use Illuminate\Support\Str;

class CustomerAdminService
{

    public function store(CustomerAdminDto $customerAdminDto)
    {

        $customer = Customer::create([
            'name' => $customerAdminDto->name,
            'email' => $customerAdminDto->email ?? null,
            'mobile_no' => $customerAdminDto->mobile_no,
            'is_active' => $customerAdminDto->is_active ?? true,
            'password' => Hash::make($customerAdminDto->password),
            'gender' => $customerAdminDto->gender,
            'created_by' => Auth::id(),
            'kyc_verified_at' => $customerAdminDto->kyc_verified_at,
            'notification_preference' => json_encode(['mail' => true, 'sms' => true, 'expo' => false])
        ]);

        $customerkyc = CustomerKyc::create(
            [
                'customer_id' =>  $customer->id,
                'grandfather_name' => $customerAdminDto->grandfather_name,
                'father_name' => $customerAdminDto->father_name,
                'mother_name' => $customerAdminDto->mother_name,
                'spouse_name' => $customerAdminDto->spouse_name,
                'nepali_date_of_birth' => $customerAdminDto->nepali_date_of_birth,
                'english_date_of_birth' => $customerAdminDto->english_date_of_birth,
                'permanent_province_id' => $customerAdminDto->permanent_province_id,
                'permanent_district_id' => $customerAdminDto->permanent_district_id,
                'permanent_local_body_id' => $customerAdminDto->permanent_local_body_id,
                'permanent_ward' => $customerAdminDto->permanent_ward,
                'permanent_tole' => $customerAdminDto->permanent_tole,
                'temporary_province_id' => $customerAdminDto->temporary_province_id,
                'temporary_district_id' => $customerAdminDto->temporary_district_id,
                'temporary_local_body_id' => $customerAdminDto->temporary_local_body_id,
                'temporary_ward' => $customerAdminDto->temporary_ward,
                'temporary_tole' => $customerAdminDto->temporary_tole,
                'document_type' => $customerAdminDto->document_type,
                'document_issued_date_nepali' => $customerAdminDto->document_issued_date_nepali,
                'document_issued_date_english' => $customerAdminDto->document_issued_date_english,
                'document_issued_at' => $customerAdminDto->document_issued_at,
                'document_number' => $customerAdminDto->document_number,
                'document_image1' => $customerAdminDto->document_image1,
                'document_image2' => $customerAdminDto->document_image2,
                'expiry_date_nepali' => $customerAdminDto->expiry_date_nepali,
                'expiry_date_english' => $customerAdminDto->expiry_date_english,
                'status' => $customerAdminDto->status,
            ]
        );

        $appUrl = 'https://my-app-url.com';
        $customer->notify(new CustomerRegistrationNotification($appUrl, $customerAdminDto->password));
        return $customer;
    }


    public function storeCustomer(CustomerAdminDto $customerAdminDto)
    {
        $customer = Customer::create([
            'name' => $customerAdminDto->name,
            'email' => $customerAdminDto->email ?? null,
            'mobile_no' => $customerAdminDto->mobile_no,
            'is_active' => $customerAdminDto->is_active ?? true,
            'password' => Hash::make($customerAdminDto->password),
            'gender' => $customerAdminDto->gender,
            'created_by' => Auth::id(),
            'notification_preference' => json_encode(['mail' => true, 'sms' => true, 'expo' => false])
        ]);

        $appUrl = 'https://my-app-url.com';
        $customer->notify(new CustomerRegistrationNotification($appUrl, $customerAdminDto->password));
    }

    public function update(Customer $customer, CustomerAdminDto $customerAdminDto)
    {
        return tap($customer)->update([
            'name' => $customerAdminDto->name,
            'email' => $customerAdminDto->email,
            'mobile_no' => $customerAdminDto->mobile_no,
            'password' => $customerAdminDto->password,
            'gender' => $customerAdminDto->gender,
            'updated_by' => Auth::id(),
        ]);
    }
    public function updateStatus(CustomerKyc $customerKyc, CustomerKycDto $dto): CustomerKyc
    {
        $originalKycAttributes = $customerKyc->getOriginal();
        $originalCustomerAttributes = $customerKyc->customer->getOriginal();

        $customerKyc->status = $dto->status;
        $customerKyc->reason_to_reject  = json_encode($dto->reason_to_reject);
        $customerKyc->verified_by = Auth::id();
        $customerKyc->save();

        $customer = $customerKyc->customer;
        $customer->updated_by = Auth::id();
        if ($customerKyc->status->value === KycStatusEnum::ACCEPTED->value) {
            $customer->kyc_verified_at = now();
            $customer->save();
            $customer->notify(new KycVerificationNotification('approved'));
        } elseif ($customerKyc->status->value === KycStatusEnum::REJECTED->value) {
            $customerKyc->rejected_by = Auth::id();
            $reasons =  json_decode($customerKyc->reason_to_reject);

            $customer->notify(new KycVerificationNotification('rejected', $reasons));
        }
        $newKycAttributes = $customerKyc->getAttributes();
        $newCustomerAttributes = $customerKyc->customer->getAttributes();

        CustomerKycLogJob::dispatch(
            $customerKyc->customer,
            $originalKycAttributes,
            $newKycAttributes,
            $originalCustomerAttributes,
            $newCustomerAttributes
        );

        return $customerKyc;
    }
}
