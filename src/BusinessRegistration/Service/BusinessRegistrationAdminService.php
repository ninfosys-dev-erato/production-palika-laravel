<?php

namespace Src\BusinessRegistration\Service;

use App\Facades\FileTrackingFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\BusinessRegistrationAdminDto;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Settings\Models\Setting;
use DB;

class BusinessRegistrationAdminService
{
    use HelperDate, BusinessRegistrationTemplate;

    public function store(BusinessRegistrationAdminDto $businessRegistrationAdminDto): bool|BusinessRegistration
    {
        $businessRegistration = BusinessRegistration::create([
            'entity_name' => $businessRegistrationAdminDto->entity_name,
            'registration_type_id' => $businessRegistrationAdminDto->registration_type_id,
            'amount' => $businessRegistrationAdminDto->amount,
            'bill_no' => $businessRegistrationAdminDto->bill_no,
            'applicant_number' => $businessRegistrationAdminDto->applicant_number,
            'applicant_name' => $businessRegistrationAdminDto->applicant_name,
            'application_date' => $businessRegistrationAdminDto->application_date,
            'application_date_en' => $businessRegistrationAdminDto->application_date_en,
            'registration_date' => $businessRegistrationAdminDto->registration_date,
            'registration_date_en' => $businessRegistrationAdminDto->registration_date_en,
            'registration_number' => $businessRegistrationAdminDto->registration_number,
            'certificate_number' => $businessRegistrationAdminDto->certificate_number,
            'department_id' => $businessRegistrationAdminDto->department_id,
            'business_nature' => $businessRegistrationAdminDto->business_nature,
            'province_id' => $businessRegistrationAdminDto->province_id,
            'district_id' => $businessRegistrationAdminDto->district_id,
            'local_body_id' => $businessRegistrationAdminDto->local_body_id,
            'ward_no' => $businessRegistrationAdminDto->ward_no,
            'way' => $businessRegistrationAdminDto->way,
            'tole' => $businessRegistrationAdminDto->tole,
            'data' => json_encode($businessRegistrationAdminDto->data),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $businessRegistrationAdminDto->created_by,
            'mobile_no' => $businessRegistrationAdminDto->mobile_no,
            'operator_id' => $businessRegistrationAdminDto->operator_id,
            'preparer_id' => $businessRegistrationAdminDto->preparer_id,
            'approver_id' => $businessRegistrationAdminDto->approver_id,
            'registration_type' => $businessRegistrationAdminDto->registrationType ?? BusinessRegistrationType::REGISTRATION,
            'registration_id' => $businessRegistrationAdminDto->registration_id ?? null,
        ]);

        return $businessRegistration;
    }

    public function update(BusinessRegistrationAdminDto $businessRegistrationAdminDto, BusinessRegistration $businessRegistration): bool|BusinessRegistration
    {
        $registration = tap($businessRegistration)->update([
            'entity_name' => $businessRegistrationAdminDto->entity_name,
            'registration_type_id' => $businessRegistrationAdminDto->registration_type_id,
            'amount' => $businessRegistrationAdminDto->amount,
            'applicant_number' => $businessRegistrationAdminDto->applicant_number,
            'applicant_name' => $businessRegistrationAdminDto->applicant_name,
            'bill_no' => $businessRegistrationAdminDto->bill_no,
            'application_date' => $businessRegistrationAdminDto->application_date,
            'application_date_en' => $businessRegistrationAdminDto->application_date_en,
            'registration_date' => $businessRegistrationAdminDto->registration_date,
            'registration_date_en' => $businessRegistrationAdminDto->registration_date_en,
            'registration_number' => $businessRegistrationAdminDto->registration_number,
            'certificate_number' => $businessRegistrationAdminDto->certificate_number,
            'department_id' => $businessRegistrationAdminDto->department_id,
            'business_nature' => $businessRegistrationAdminDto->business_nature,
            'province_id' => $businessRegistrationAdminDto->province_id,
            'district_id' => $businessRegistrationAdminDto->district_id,
            'local_body_id' => $businessRegistrationAdminDto->local_body_id,
            'ward_no' => $businessRegistrationAdminDto->ward_no,
            'way' => $businessRegistrationAdminDto->way,
            'tole' => $businessRegistrationAdminDto->tole,
            'data' => json_encode($businessRegistrationAdminDto->data),
            'updated_at' => now(),
            'updated_by' => $businessRegistrationAdminDto->updated_by,
            'mobile_no' => $businessRegistrationAdminDto->mobile_no,
            'application_status' => ApplicationStatusEnum::PENDING->value,
            'operator_id' => $businessRegistrationAdminDto->operator_id,
            'preparer_id' => $businessRegistrationAdminDto->preparer_id,
            'approver_id' => $businessRegistrationAdminDto->approver_id,
        ]);

        return $registration;
    }

    public function delete(BusinessRegistration $businessRegistration): bool|BusinessRegistration
    {
        $businessRegistration = tap($businessRegistration)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id
        ]);

        return $businessRegistration;
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        BusinessRegistration::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function reject(BusinessRegistration $businessRegistration, BusinessRegistrationShowDto $applyRecommendationShowDto)
    {
        FileTrackingFacade::recordFile($businessRegistration);
        $resone = tap($businessRegistration)->update([
            'rejected_by' => Auth::user()->id,
            'application_rejection_reason' => $applyRecommendationShowDto->application_rejection_reason,
            'rejected_at' => now(),
            'application_status' => ApplicationStatusEnum::REJECTED->value
        ]);

        return $businessRegistration;
    }

    public function sentForPayment(BusinessRegistration $businessRegistration): BusinessRegistration
    {
        FileTrackingFacade::recordFile($businessRegistration);
        tap($businessRegistration)->update([
            'amount' => $businessRegistration->amount,
            'application_status' => $businessRegistration->application_status,
            'rejected_by' => null,
            'application_rejection_reason' => null,
            'rejected_at' => null,
        ]);

        return $businessRegistration;
    }

    public function accept(BusinessRegistration $businessRegistration, array $data): BusinessRegistration
    {
        FileTrackingFacade::recordFile($businessRegistration);
        tap($businessRegistration)->update([
            'application_status' => ApplicationStatusEnum::ACCEPTED->value,
            'rejected_by' => null,
            'application_rejection_reason' => null,
            'rejected_at' => null,
            'registration_number' => $data['registration_number'],
            'registration_date' => $data['registration_date'],
            'registration_date_en' => $data['registration_date_en'],
            'certificate_number' => $data['certificate_number'],
            'bill_no' => $data['bill_no'],
            'business_status' => BusinessStatusEnum::ACTIVE->value,
            'approved_at' => now(),
            'approved_by' => Auth::user()->id,
        ]);

        return $businessRegistration;
    }


    public function uploadBill(BusinessRegistration $businessRegistration, BusinessRegistrationShowDto $businessRegistrationShowDto, bool $admin = true)
    {
        FileTrackingFacade::recordFile($businessRegistration, $admin);
        tap($businessRegistration)->update([
            'bill' => $businessRegistrationShowDto->bill,
            'application_status' => ApplicationStatusEnum::BILL_UPLOADED->value,
            'rejected_by' => null,
            'rejected_reason' => null,
            'rejected_at' => null,
        ]);

        return $businessRegistration;
    }

    public function generateBusinessRegistrationNumber()
    {
        $fiscalYear = $this->convertNepaliToEnglish(getSetting('fiscal-year'));

        $lastRegistration = BusinessRegistration::latest('id')->first();

        $newNumber = str_pad($lastRegistration->id + 1, 6, '0', STR_PAD_LEFT);

        $newRegistrationNumber = $newNumber . '/' . $fiscalYear;

        return $newRegistrationNumber;
    }

    public function getLetter(BusinessRegistration $businessRegistration, $request = 'web')
    {
        try {
            $html =  $this->resolveTemplate($businessRegistration);
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.BusinessRegistration.businessRegistration.certificate'),
                file_name: "recommendation_{$businessRegistration->id}",
                disk: "local",
                styles: $businessRegistration->registrationType?->form?->styles ?? ""
            );
            if ($request === 'web') {
                return redirect()->away($url);
            }

            return $url;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
    public function deRegisterBusiness(BusinessRegistrationAdminDto $businessRegistrationAdminDto, BusinessRegistration $businessRegistration): bool
    {
        DB::beginTransaction();
        try {

            if ($businessRegistration->deleted_at === null && $businessRegistration->deleted_by === null) {
                $this->store($businessRegistrationAdminDto);
                $this->delete($businessRegistration);
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
