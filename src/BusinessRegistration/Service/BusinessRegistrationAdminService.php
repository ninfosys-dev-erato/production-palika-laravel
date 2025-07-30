<?php

namespace Src\BusinessRegistration\Service;

use App\Facades\FileTrackingFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\BusinessRegistration\DTO\BusinessRegistrationAdminDto;
use Src\BusinessRegistration\DTO\BusinessRegistrationShowDto;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\BusinessStatusEnum;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Models\Setting;

class BusinessRegistrationAdminService
{
    use HelperDate, BusinessRegistrationTemplate;

    public function store(BusinessRegistrationAdminDto $businessRegistrationAdminDto): bool|BusinessRegistration
    {
        $businessRegistration = BusinessRegistration::create([
            // Business Info
            'business_nature'              => $businessRegistrationAdminDto->business_nature,
            'main_service_or_goods'        => $businessRegistrationAdminDto->main_service_or_goods,
            'total_capital'                => $businessRegistrationAdminDto->total_capital,
            'business_province'            => $businessRegistrationAdminDto->business_province,
            'business_district'            => $businessRegistrationAdminDto->business_district,
            'business_local_body'          => $businessRegistrationAdminDto->business_local_body,
            'business_ward'                => $businessRegistrationAdminDto->business_ward,
            'business_tole'                => $businessRegistrationAdminDto->business_tole,
            'business_street'              => $businessRegistrationAdminDto->business_street,
            'registration_type_id'         => $businessRegistrationAdminDto->registration_type_id,
            'purpose'                      => $businessRegistrationAdminDto->purpose,
            'entity_name'                  => $businessRegistrationAdminDto->entity_name,
            'fiscal_year'                  => $businessRegistrationAdminDto->fiscal_year,
            'registration_date'            => $businessRegistrationAdminDto->registration_date,
            'registration_date_en'         => $businessRegistrationAdminDto->registration_date_en,
            'application_date'             => $businessRegistrationAdminDto->application_date,
            'application_date_en'         => $businessRegistrationAdminDto->application_date_en,
            'data'                        => json_encode($businessRegistrationAdminDto->data),
            'created_at'                    => date('Y-m-d H:i:s'),
            'created_by'                     => $businessRegistrationAdminDto->created_by,
            'registration_type' => $businessRegistrationAdminDto->registrationType ?? BusinessRegistrationType::REGISTRATION,

            'registration_number' => $businessRegistrationAdminDto->registration_number,
            'certificate_number' => $businessRegistrationAdminDto->certificate_number,
            'application_status' => ApplicationStatusEnum::PENDING->value,

            'working_capital'              => $businessRegistrationAdminDto->working_capital,
            'fixed_capital'                => $businessRegistrationAdminDto->fixed_capital,
            'capital_investment'           => $businessRegistrationAdminDto->capital_investment,
            'financial_source'             => $businessRegistrationAdminDto->financial_source,
            'required_electric_power'      => $businessRegistrationAdminDto->required_electric_power,
            'production_capacity'          => $businessRegistrationAdminDto->production_capacity,
            'required_manpower'            => $businessRegistrationAdminDto->required_manpower,
            'number_of_shifts'             => $businessRegistrationAdminDto->number_of_shifts,
            'operation_date'               => $businessRegistrationAdminDto->operation_date,
            'others'                       => $businessRegistrationAdminDto->others,
            'houseownername' => $businessRegistrationAdminDto->houseownername,
            'house_owner_phone' => $businessRegistrationAdminDto->house_owner_phone,
            'monthly_rent' => $businessRegistrationAdminDto->monthly_rent,
            'rentagreement' => $businessRegistrationAdminDto->rentagreement,
            'east' => $businessRegistrationAdminDto->east,
            'west' => $businessRegistrationAdminDto->west,
            'north' => $businessRegistrationAdminDto->north,
            'south' => $businessRegistrationAdminDto->south,
            'landplotnumber' => $businessRegistrationAdminDto->landplotnumber,
            'area' => $businessRegistrationAdminDto->area,
            'is_rented' => $businessRegistrationAdminDto->is_rented,
            'total_running_day' => $businessRegistrationAdminDto->total_running_day,
            'registration_category' => $businessRegistrationAdminDto->registration_category,
            'business_status' => BusinessStatusEnum::ACTIVE->value,
        ]);

        return $businessRegistration;
    }

    public function update(BusinessRegistrationAdminDto $businessRegistrationAdminDto, BusinessRegistration $businessRegistration): bool|BusinessRegistration
    {
        $registration = tap($businessRegistration)->update([
            // Business Info
            'business_nature'              => $businessRegistrationAdminDto->business_nature,
            'main_service_or_goods'        => $businessRegistrationAdminDto->main_service_or_goods,
            'total_capital'                => $businessRegistrationAdminDto->total_capital,
            'business_province'            => $businessRegistrationAdminDto->business_province,
            'business_district'            => $businessRegistrationAdminDto->business_district,
            'business_local_body'          => $businessRegistrationAdminDto->business_local_body,
            'business_ward'                => $businessRegistrationAdminDto->business_ward,
            'business_tole'                => $businessRegistrationAdminDto->business_tole,
            'business_street'              => $businessRegistrationAdminDto->business_street,
            'purpose'                      => $businessRegistrationAdminDto->purpose,
            'registration_type_id'         => $businessRegistrationAdminDto->registration_type_id,
            'entity_name'                  => $businessRegistrationAdminDto->entity_name,
            'fiscal_year'                  => $businessRegistrationAdminDto->fiscal_year,
            'registration_date'            => $businessRegistrationAdminDto->registration_date,
            'registration_date_en'         => $businessRegistrationAdminDto->registration_date_en,
            'application_date'             => $businessRegistrationAdminDto->application_date,
            'application_date_en'         => $businessRegistrationAdminDto->application_date_en,
            'data'                        => json_encode($businessRegistrationAdminDto->data),
            'created_at'                    => date('Y-m-d H:i:s'),
            'created_by'                     => $businessRegistrationAdminDto->created_by,
            'registration_type' => $businessRegistrationAdminDto->registrationType ?? BusinessRegistrationType::REGISTRATION,
            'registration_number' => $businessRegistrationAdminDto->registration_number,
            'certificate_number' => $businessRegistrationAdminDto->certificate_number,
            'application_status' => ApplicationStatusEnum::PENDING->value,

            'working_capital'              => $businessRegistrationAdminDto->working_capital,
            'fixed_capital'                => $businessRegistrationAdminDto->fixed_capital,
            'capital_investment'           => $businessRegistrationAdminDto->capital_investment,
            'financial_source'             => $businessRegistrationAdminDto->financial_source,
            'required_electric_power'      => $businessRegistrationAdminDto->required_electric_power,
            'production_capacity'          => $businessRegistrationAdminDto->production_capacity,
            'required_manpower'            => $businessRegistrationAdminDto->required_manpower,
            'number_of_shifts'             => $businessRegistrationAdminDto->number_of_shifts,
            'operation_date'               => $businessRegistrationAdminDto->operation_date,
            'others'                       => $businessRegistrationAdminDto->others,
            'houseownername' => $businessRegistrationAdminDto->houseownername,
            'house_owner_phone' => $businessRegistrationAdminDto->house_owner_phone,
            'monthly_rent' => $businessRegistrationAdminDto->monthly_rent,
            'rentagreement' => $businessRegistrationAdminDto->rentagreement,
            'east' => $businessRegistrationAdminDto->east,
            'west' => $businessRegistrationAdminDto->west,
            'north' => $businessRegistrationAdminDto->north,
            'south' => $businessRegistrationAdminDto->south,
            'landplotnumber' => $businessRegistrationAdminDto->landplotnumber,
            'area' => $businessRegistrationAdminDto->area,
            'is_rented' => $businessRegistrationAdminDto->is_rented,
            'total_running_day' => $businessRegistrationAdminDto->total_running_day,
            'registration_category' => $businessRegistrationAdminDto->registration_category,
        ]);

        return $registration;
    }

    public function delete(BusinessRegistration $businessRegistration): bool|BusinessRegistration
    {

        $businessRegistration = tap($businessRegistration)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
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

    public function reject(BusinessRegistration $businessRegistration, BusinessRegistrationShowDto $businessRegistrationAdminDto)
    {
        FileTrackingFacade::recordFile($businessRegistration);
        $resone = tap($businessRegistration)->update([
            'rejected_by' => Auth::user()->id,
            'application_rejection_reason' => $businessRegistrationAdminDto->application_rejection_reason,
            'rejected_at' => now(),
            'application_status' => ApplicationStatusEnum::REJECTED->value,
            'business_status' => BusinessStatusEnum::INACTIVE->value,
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
            'registration_date' => replaceNumbers($this->adToBs(date('Y-m-d')), true),
            'registration_date_en' => date('Y-m-d'),
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

    // public function generateBusinessRegistrationNumber()
    // {
    //     $fiscalYearKey = key(getSettingWithKey('fiscal-year'));
    //     $fiscalYear = $this->convertNepaliToEnglish(getSetting('fiscal-year'));

    //     $lastCount = BusinessRegistration::where('fiscal_year', $fiscalYearKey)
    //         ->whereNotNull('registration_number')
    //         ->where('application_status', ApplicationStatusEnum::ACCEPTED->value)
    //         ->count();

    //     $newNumber = str_pad($lastCount + 1, 6, '0', STR_PAD_LEFT);
    //     $newRegistrationNumber = $newNumber . '/' . $fiscalYear;


    //     return $newRegistrationNumber;
    // }

    public function generateBusinessRegistrationNumber($fiscalYearId)
    {
        $fiscalYearName = FiscalYear::findOrFail($fiscalYearId);
        $fiscalYear = $this->convertNepaliToEnglish($fiscalYearName->year);

        // Get the max registration number (only the numeric part before '/')
        $maxNumber = BusinessRegistration::where('fiscal_year', $fiscalYearId)
            ->whereNotNull('registration_number')
            ->selectRaw("MAX(CAST(SUBSTRING_INDEX(registration_number, '/', 1) AS UNSIGNED)) as max_num")
            ->value('max_num');

        // If no records yet, start from 1
        $newSerial = $maxNumber ? $maxNumber + 1 : 1;

        $newNumber = str_pad($newSerial, 6, '0', STR_PAD_LEFT);

        return $newNumber . '/' . $fiscalYear;
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
    public function deRegisterBusiness(BusinessRegistrationAdminDto $businessRegistrationAdminDto, BusinessRegistration $businessRegistration): BusinessRegistration|bool
    {
        DB::beginTransaction();
        try {

            if ($businessRegistration->deleted_at === null && $businessRegistration->deleted_by === null) {
                $deregistration = $this->store($businessRegistrationAdminDto);
                $this->delete($businessRegistration);
                DB::commit();
                return $deregistration;
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
