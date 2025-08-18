<?php

namespace Src\BusinessRegistration\Traits;

use App\Traits\HelperTemplate;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Illuminate\Support\Str;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\FileTracking\Models\FileRecord;
use Src\Settings\Enums\TemplateEnum;
use Src\Settings\Models\LetterHeadSample;

trait BusinessRegistrationTemplate
{
    use HelperTemplate;
    const EMPTY_LINES = '____________________';
    public $reg_no;

    public function resolveTemplate(BusinessRegistration | BusinessDeRegistration $businessRegistration, $template = null)
    {

        $template = $template ?? $businessRegistration->registrationType?->form?->template ?? '';

        if ($businessRegistration instanceof \Src\BusinessRegistration\Models\BusinessDeRegistration) {
            $businessRegistration = $businessRegistration->businessRegistration;
        }

        $businessRegistration->load('registrationType', 'fiscalYear', 'province', 'district', 'localBody', 'businessNature', 'renewals');


        $fileRecord = FileRecord::where('subject_id',  $businessRegistration->id)->whereNull('deleted_at')->first();
        $regNo = $fileRecord && $fileRecord->reg_no ? replaceNumbers($fileRecord->reg_no, true) : ' ';
        $this->reg_no = $regNo;
        $globalData = $this->getGlobalData($businessRegistration->approvedBy?->name, $businessRegistration->ward_no, $businessRegistration->id);


        $letterHead = $this->getBusinessLetterHeaderFromSample();
        // $letterFoot = $this->getLetterFooter(getFormattedBsDate());
        $businessRegistrationData = $this->resolveBusinessDate($businessRegistration);

        $formData = $this->getResolvedFormData(is_array($businessRegistration->data) ? $businessRegistration->data : json_decode($businessRegistration->data, true), true);



        $customerData = $this->getCustomerData($businessRegistration);

        $replacements = array_merge(
            ['{{global.letter-head}}' => $letterHead],
            ['{{business.renewal_table}}' => $this->renderRenewalTemplateWithData($businessRegistration)],
            $globalData,
            $formData,
            $customerData,
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
            '{{business.fiscal_year}}' => $businessRegistration->fiscalYear?->year ?? ' ',

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
            '{{business.business_category}}' => $businessRegistration->business_category ?? ' ',
            '{{business.business_purpose}}' => $businessRegistration->purpose ?? ' ',
            '{{business.main_service_or_goods}}' => $businessRegistration->main_service_or_goods ?? ' ',
            '{{business.total_capital}}' => $businessRegistration->total_capital ?? ' ',
            '{{business.business_province}}' => $businessRegistration->businessProvince?->title ?? ' ',
            '{{business.business_district}}' => $businessRegistration->businessDistrict?->title ?? ' ',
            '{{business.business_local_body}}' => $businessRegistration->businessLocalBody?->title ?? ' ',
            '{{business.business_ward}}' => replaceNumbers($businessRegistration->business_ward, true) ?? ' ',
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
            '{{business.kardata_number}}' => replaceNumbers($businessRegistration->kardata_number, true) ?? ' ',
            '{{business.kardata_miti}}' => $businessRegistration->kardata_miti ?? ' ',

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
            return replaceNumbers($businessRegistration->applicant_ward ?? ' ', true);
        }

        $wards = $applicants->pluck('applicant_ward')->filter()->implode(', ');

        return replaceNumbers($wards, true);
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

    public function renderRenewalTemplateWithData(BusinessRegistration $businessRegistration): string
    {
        $template = LetterHeadSample::where('slug', TemplateEnum::BusinessRenewal)
            ->whereNull('deleted_at')
            ->first();

        if (!$template) {
            return '';
        }

        $style = $template->style ? "<style>{$template->style}</style>" : '';
        $content = $template->content;

        $globalData = $this->getGlobalData($businessRegistration->approvedBy?->name, $businessRegistration->ward_no, $businessRegistration->id);
        $globalData = $this->sanitizeReplacements($globalData);


        // Replace global variables anywhere in the content
        $content = Str::replace(array_keys($globalData), array_values($globalData), $content);

        // Step 2: Renewal records
        $renewals = $businessRegistration->renewals->where('application_status', ApplicationStatusEnum::ACCEPTED);
        $renewals->load('fiscalYear');
        $renewals = $renewals->values(); // Reset array keys for index access

        preg_match('/<tbody>\s*<tr>(.*?)<\/tr>\s*<\/tbody>/s', $content, $matches);

        if (!isset($matches[0], $matches[1])) {
            // No match for row template — return global-replaced template only
            return <<<HTML
            {$style}
            {$content}
            HTML;
        }

        $originalRowHtml = $matches[1];
        $generatedRows = '';
        $maxRows = 10;

        for ($i = 0; $i < $maxRows; $i++) {
            $row = $originalRowHtml;

            if (isset($renewals[$i])) {
                $renewal = $renewals[$i];

                $additionalData = [
                    '{{renew.fiscalYear}}' => $renewal->fiscalYear->year ?? '',
                    '{{renew.renewalDate}}' => replaceNumbers($renewal->renew_date ?? '', true) ?? '',
                    '{{renew.billNo}}' => replaceNumbers($renewal->bill_no ?? '', true) ?? '',
                    '{{renew.paymentDate}}' => replaceNumbers($renewal->payment_receipt_date ?? '', true) ?? '',
                ];
            } else {
                // Blank row if no renewal exists
                $additionalData = [
                    '{{renew.fiscalYear}}' => '',
                    '{{renew.renewalDate}}' => '',
                    '{{renew.billNo}}' => '',
                    '{{renew.paymentDate}}' => '',
                ];
            }

            $additionalData = $this->sanitizeReplacements($additionalData);
            $row = Str::replace(array_keys($additionalData), array_values($additionalData), $row);

            $generatedRows .= "<tr>{$row}</tr>\n";
        }


        $content = Str::replace($matches[0], "<tbody>\n{$generatedRows}</tbody>", $content);

        return <<<HTML
        {$style}
        {$content}
        HTML;
    }
}
