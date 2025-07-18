<?php

namespace Src\BusinessRegistration\Traits;

use App\Traits\HelperTemplate;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Illuminate\Support\Str;
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\FileTracking\Models\FileRecord;

trait BusinessRegistrationTemplate
{
    use HelperTemplate;
    const EMPTY_LINES = '____________________';
    public $reg_no;

    public function resolveTemplate(BusinessRegistration | BusinessDeRegistration $businessRegistration)
    {

        $template = $businessRegistration->registrationType?->form?->template ?? '';

        if ($businessRegistration instanceof \Src\BusinessRegistration\Models\BusinessDeRegistration) {
            $businessRegistration = $businessRegistration->businessRegistration;
        }

        $businessRegistration->load('registrationType', 'fiscalYear', 'province', 'district', 'localBody', 'businessNature');


        $fileRecord = FileRecord::where('subject_id',  $businessRegistration->id)->whereNull('deleted_at')->first();
        $regNo = $fileRecord && $fileRecord->reg_no ? replaceNumbers($fileRecord->reg_no, true) : ' ';
        $this->reg_no = $regNo;
        $globalData = $this->getGlobalData($businessRegistration->approvedBy?->name, $businessRegistration->ward_no, $businessRegistration->id);
        $letterHeadwithCampaign = $this->getLetterHeader($businessRegistration->ward_no, getFormattedBsDate(), $regNo, true, $businessRegistration?->fiscalYear?->year ?? getSetting('fiscal-year'));
        $letterHead = $this->getLetterHeaderForBusiness(null, getFormattedBsDate(), $regNo, true, $businessRegistration?->fiscalYear?->year ?? getSetting('fiscal-year'));
        // $letterFoot = $this->getLetterFooter(getFormattedBsDate());
        $businessRegistrationData = $this->resolveBusinessDate($businessRegistration);

        $formData = $this->getResolvedFormData(is_array($businessRegistration->data) ? $businessRegistration->data : json_decode($businessRegistration->data, true), true);
        $customerData = $this->getCustomerData($businessRegistration);

        $replacements = array_merge(
            ['{{global.letter-head}}' => $letterHead, '{{global.letter-head-with-campaign-logo}}' => $letterHeadwithCampaign],

            $globalData,
            $formData,
            $customerData,
            // ['{{global.letter-foot}}' => $letterFoot],
            $businessRegistrationData
        );

        $replacements = $this->sanitizeReplacements($replacements);

        return Str::replace(array_keys($replacements), array_values($replacements), $template);
    }


    private function sanitizeReplacements(array $replacements): array
    {
        return array_map(function ($value) {
            if (is_null($value) || $value === '') {
                return ' ';
            }
            return $value;
        }, $replacements);
    }

    public function resolveBusinessDate($businessRegistration)
    {
        return [
            // Registration type and fiscal year
            '{{business.fiscal_year}}' => $businessRegistration->fiscalYear?->title ?? ' ',

            // Entity and registration details
            '{{business.entity_name}}' => $businessRegistration->entity_name ?? ' ',
            '{{business.registration_date}}' => replaceNumbers($businessRegistration->registration_date, true) ?? ' ',
            '{{business.registration_date_en}}' => $businessRegistration->registration_date_en ?? ' ',
            '{{business.registration_number}}' => replaceNumbers($businessRegistration->registration_number, true) ?? ' ',
            '{{business.certificate_number}}' => replaceNumbers($businessRegistration->certificate_number, true) ?? ' ',

            // Applicant details - handle multiple applicants
            '{{business.applicant_name}}' => $this->getApplicantNames($businessRegistration),
            '{{business.gender}}' => $this->getApplicantGenders($businessRegistration),
            '{{business.father_name}}' => $this->getApplicantFatherNames($businessRegistration),
            '{{business.grandfather_name}}' => $this->getApplicantGrandfatherNames($businessRegistration),
            '{{business.phone}}' => $this->getApplicantPhones($businessRegistration),
            '{{business.email}}' => $this->getApplicantEmails($businessRegistration),
            '{{business.citizenship_number}}' => $this->getApplicantCitizenshipNumbers($businessRegistration),
            '{{business.citizenship_issued_date}}' => $this->getApplicantCitizenshipIssuedDates($businessRegistration),
            '{{business.citizenship_issued_district}}' => $this->getApplicantCitizenshipIssuedDistricts($businessRegistration),


            // Applicant address (relationships) - handle multiple applicants
            '{{business.applicant_province}}' => $this->getApplicantProvinces($businessRegistration),
            '{{business.applicant_district}}' => $this->getApplicantDistricts($businessRegistration),
            '{{business.applicant_local_body}}' => $this->getApplicantLocalBodies($businessRegistration),
            '{{business.applicant_ward}}' => $this->getApplicantWards($businessRegistration),
            '{{business.applicant_tole}}' => $this->getApplicantToles($businessRegistration),
            '{{business.applicant_street}}' => $this->getApplicantStreets($businessRegistration),

            // Business details (relationships)
            '{{business.business_nature}}' => $businessRegistration->business_nature ?? ' ',
            '{{business.main_service_or_goods}}' => $businessRegistration->main_service_or_goods ?? ' ',
            '{{business.total_capital}}' => $businessRegistration->total_capital ?? ' ',
            '{{business.business_province}}' => $businessRegistration->businessProvince?->title ?? ' ',
            '{{business.business_district}}' => $businessRegistration->businessDistrict?->title ?? ' ',
            '{{business.business_local_body}}' => $businessRegistration->businessLocalBody?->title ?? ' ',
            '{{business.business_ward}}' => $businessRegistration->business_ward ?? ' ',
            '{{business.business_tole}}' => $businessRegistration->business_tole ?? ' ',
            '{{business.business_street}}' => $businessRegistration->business_street ?? ' ',

            // Financial and status fields
            '{{business.application_date}}' => $businessRegistration->application_date ?? '',
            '{{business.application_date_en}}' => $businessRegistration->application_date_en ?? '',

            '{{business.business_reg_no}}' => $this->reg_no ?? '',

            // Financial fields
            '{{business.working_capital}}' => $businessRegistration->working_capital ?? ' ',
            '{{business.fixed_capital}}' => $businessRegistration->fixed_capital ?? ' ',
            '{{business.capital_investment}}' => $businessRegistration->capital_investment ?? ' ',
            '{{business.financial_source}}' => $businessRegistration->financial_source ?? ' ',

            // Industrial fields
            '{{business.required_electric_power}}' => $businessRegistration->required_electric_power ?? ' ',
            '{{business.production_capacity}}' => $businessRegistration->production_capacity ?? ' ',
            '{{business.required_manpower}}' => $businessRegistration->required_manpower ?? ' ',
            '{{business.number_of_shifts}}' => $businessRegistration->number_of_shifts ?? ' ',
            '{{business.operation_date}}' => $businessRegistration->operation_date ?? ' ',
            '{{business.others}}' => $businessRegistration->others ?? ' ',

            // Property details
            '{{business.houseownername}}' => $businessRegistration->houseownername ?? ' ',
            '{{business.monthly_rent}}' => $businessRegistration->monthly_rent ?? ' ',
            '{{business.rentagreement}}' => $businessRegistration->rentagreement ?? ' ',

            // Location details
            '{{business.east}}' => $businessRegistration->east ?? ' ',
            '{{business.west}}' => $businessRegistration->west ?? ' ',
            '{{business.north}}' => $businessRegistration->north ?? ' ',
            '{{business.south}}' => $businessRegistration->south ?? ' ',
            '{{business.landplotnumber}}' => $businessRegistration->landplotnumber ?? ' ',
            '{{business.area}}' => $businessRegistration->area ?? ' ',
            '{{business.is_rented}}' => $businessRegistration->is_rented ?? ' ',
            '{{business.total_running_day}}' => $businessRegistration->total_running_day ?? ' ',




        ];
    }

    // Helper methods to handle multiple applicants
    private function getApplicantNames($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;

        if ($applicants->isEmpty()) {
            return $businessRegistration->applicant_name ?? ' ';
        }

        return $applicants->pluck('applicant_name')->filter()->implode(', ');
    }


    private function getApplicantGenders($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->gender?->value ?? ' ';
        }
        return $applicants->pluck('gender')->filter()->implode(', ');
    }

    private function getApplicantFatherNames($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->father_name ?? ' ';
        }
        return $applicants->pluck('father_name')->filter()->implode(', ');
    }

    private function getApplicantGrandfatherNames($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->grandfather_name ?? ' ';
        }
        return $applicants->pluck('grandfather_name')->filter()->implode(', ');
    }

    private function getApplicantPhones($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->phone ?? ' ';
        }
        return $applicants->pluck('phone')->filter()->implode(', ');
    }

    private function getApplicantEmails($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->email ?? ' ';
        }
        return $applicants->pluck('email')->filter()->implode(', ');
    }

    private function getApplicantCitizenshipNumbers($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->citizenship_number ?? ' ';
        }
        return $applicants->pluck('citizenship_number')->filter()->implode(', ');
    }

    private function getApplicantCitizenshipIssuedDates($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->citizenship_issued_date ?? ' ';
        }
        return $applicants->pluck('citizenship_issued_date')->filter()->implode(', ');
    }

    private function getApplicantCitizenshipIssuedDistricts($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->citizenship_issued_district ?? ' ';
        }
        return $applicants->pluck('citizenshipDistrict.title')->filter()->implode(', ');
    }

    // Helper methods for applicant address details
    private function getApplicantProvinces($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicantProvince?->title ?? ' ';
        }
        return $applicants->pluck('applicantProvince.title')->filter()->implode(', ');
    }

    private function getApplicantDistricts($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicantDistrict?->title ?? ' ';
        }
        return $applicants->pluck('applicantDistrict.title')->filter()->implode(', ');
    }

    private function getApplicantLocalBodies($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicantLocalBody?->title ?? ' ';
        }
        return $applicants->pluck('applicantLocalBody.title')->filter()->implode(', ');
    }

    private function getApplicantWards($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicant_ward ?? ' ';
        }
        return $applicants->pluck('applicant_ward')->filter()->implode(', ');
    }

    private function getApplicantToles($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicant_tole ?? ' ';
        }
        return $applicants->pluck('applicant_tole')->filter()->implode(', ');
    }

    private function getApplicantStreets($businessRegistration)
    {
        $applicants = $businessRegistration->applicants;
        if ($applicants->isEmpty()) {
            return $businessRegistration->applicant_street ?? ' ';
        }
        return $applicants->pluck('applicant_street')->filter()->implode(', ');
    }
}
