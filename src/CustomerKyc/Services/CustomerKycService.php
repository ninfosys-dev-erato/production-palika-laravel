<?php

namespace Src\CustomerKyc\Services;
use App\Facades\ImageServiceFacade;
use App\Jobs\CustomerKycLogJob;
use Src\Customers\Notifications\KycVerificationNotification;
use App\Services\ImageService;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Models\CustomerKyc;

class CustomerKycService
{
    protected $path; 

    public function __construct()
    {
        $this->path = config('src.CustomerKyc.customerKyc.path');
    }    

    public function storeCustomerKyc($dto, $customer, bool $webCustomer = false)
    {
        $customerkyc = CustomerKyc::where('customer_id', $customer->id)->first();
        
        $originalKycAttributes = $customerkyc ? $customerkyc->getAttributes() : [];
        $originalCustomerAttributes = $customer ? $customer->getAttributes() : [];

        $image1 = $webCustomer ? $dto->document_image1 : $this->handleFileUploads($dto->document_image1);
        $image2 = $webCustomer ? $dto->document_image2 : $this->handleFileUploads($dto->document_image2);

        $customerkyc = CustomerKyc::updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'grandfather_name' => $dto->grandfather_name,
                'father_name' => $dto->father_name,
                'mother_name' => $dto->mother_name,
                'spouse_name' => $dto->spouse_name,
                'nepali_date_of_birth' => $dto->nepali_date_of_birth,
                'english_date_of_birth' => $dto->english_date_of_birth,
                'permanent_province_id' => $dto->permanent_province_id,
                'permanent_district_id' => $dto->permanent_district_id,
                'permanent_local_body_id' => $dto->permanent_local_body_id,
                'permanent_ward' => $dto->permanent_ward,
                'permanent_tole' => $dto->permanent_tole,
                'temporary_province_id' => $dto->temporary_province_id,
                'temporary_district_id' => $dto->temporary_district_id,
                'temporary_local_body_id' => $dto->temporary_local_body_id,
                'temporary_ward' => $dto->temporary_ward,
                'temporary_tole' => $dto->temporary_tole,
                'document_type' => $dto->document_type,
                'document_issued_date_nepali' => $dto->document_issued_date_nepali,
                'document_issued_date_english' => $dto->document_issued_date_english,
                'document_issued_at' => $dto->document_issued_at,
                'document_number' => $dto->document_number,
                'document_image1' => $image1,
                'document_image2' => $image2,
                'expiry_date_nepali' => $dto->expiry_date_nepali,
                'expiry_date_english' => $dto->expiry_date_english,
                'status' => KycStatusEnum::PENDING,
            ]); 

        $customer->update([
            'name' => $dto->name,
            'gender' => $dto->gender,
            'email' => $dto->email,
        ]);

        if ($customerkyc && $customerkyc->wasRecentlyCreated === false) {
            $newKycAttributes = $customerkyc->getAttributes();
            CustomerKycLogJob::dispatch(
                $customer, 
                $originalKycAttributes, 
                $newKycAttributes, 
                $originalCustomerAttributes, 
                $customer->getAttributes()
            );
        }
        $customer->notify(new KycVerificationNotification('submit'));
        return $customer;
    }

    public function updateCustomerKyc($dto,  $customer, bool $webCustomer = false): void
    {
        $customerkyc = CustomerKyc::where('customer_id', $customer->id)->first();

        $originalKycAttributes = $customerkyc ? $customerkyc->getAttributes() : [];
        $originalCustomerAttributes = $customer ? $customer->getAttributes() : [];
        $image1 = $webCustomer ? $dto->document_image1 : $this->handleFileUploads($dto->document_image1);
        $image2 = $webCustomer ? $dto->document_image2 : $this->handleFileUploads($dto->document_image2);

        $customerkyc->update([
            'grandfather_name' =>$dto->grandfather_name,
            'father_name' => $dto->father_name,
            'mother_name' => $dto->mother_name,
            'spouse_name' => $dto->spouse_name,
            'nepali_date_of_birth' => $dto->nepali_date_of_birth,
            'english_date_of_birth' => $dto->english_date_of_birth,
            'permanent_province_id' => $dto->permanent_province_id,
            'permanent_district_id' => $dto->permanent_district_id,
            'permanent_local_body_id' => $dto->permanent_local_body_id,
            'permanent_ward' => $dto->permanent_ward,
            'permanent_tole' => $dto->permanent_tole,
            'temporary_province_id' => $dto->temporary_province_id,
            'temporary_district_id' => $dto->temporary_district_id,
            'temporary_local_body_id' => $dto->temporary_local_body_id,
            'temporary_ward' => $dto->temporary_ward,
            'temporary_tole' => $dto->temporary_tole,
            'status' => KycStatusEnum::PENDING,
            'document_type' => $dto->document_type,
            'document_issued_date_nepali' => $dto->document_issued_date_nepali,
            'document_issued_date_english' => $dto->document_issued_date_english,
            'document_issued_at' => $dto->document_issued_at,
            'document_number' => $dto->document_number,
            'document_image1' => $image1,
            'document_image2' => $image2,
            'expiry_date_nepali' => $dto->expiry_date_nepali,
            'expiry_date_english' => $dto->expiry_date_english,
        ]);

        $customer->update([
            'name' => $dto->name,
            'email' => $dto->email,
            'gender' => $dto->gender,
        ]);

        if ($customerkyc->wasRecentlyCreated === false) {
            CustomerKycLogJob::dispatch( $customer, $originalKycAttributes, $customerkyc->getAttributes(), $originalCustomerAttributes, $customer->getAttributes());
        }
    }
    public function handleFileUploads($base64Image)
    {
        return ImageServiceFacade::base64Save(
            $base64Image, 
            $this->path , 
            'local'
        );
    }

}
