<?php

namespace Src\BusinessRegistration\Traits;

use App\Traits\HelperTemplate;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Illuminate\Support\Str;
use Src\FileTracking\Models\FileRecord;

trait BusinessRegistrationTemplate
{
    use HelperTemplate;
    const EMPTY_LINES = '____________________';
    public $reg_no;

    public function resolveTemplate(BusinessRegistration $businessRegistration)
    {
        $businessRegistration->load('registrationType', 'fiscalYear', 'province', 'district', 'localBody', 'businessNature');

        $template = $businessRegistration?->registrationType?->form?->template ?? '';

        $fileRecord = FileRecord::where('subject_id',  $businessRegistration?->id)->whereNull('deleted_at')->first();
        $regNo = $fileRecord && $fileRecord->reg_no ? replaceNumbers($fileRecord->reg_no, true) : ' ';
        $this->reg_no = $regNo;
        $globalData = $this->getGlobalData($businessRegistration?->approvedBy?->name, $businessRegistration?->ward_no, $businessRegistration?->id);
        $letterHeadwithCampaign = $this->getLetterHeader($businessRegistration?->ward_no, getFormattedBsDate(), $regNo, true, $businessRegistration?->fiscalYear?->year ?? getSetting('fiscal-year'));
        $letterHead = $this->getLetterHeaderForBusiness(null, getFormattedBsDate(), $regNo, true, $businessRegistration?->fiscalYear?->year ?? getSetting('fiscal-year'));
        // $letterFoot = $this->getLetterFooter(getFormattedBsDate());
        $businessRegistrationData = $this->resolveBusinessDate($businessRegistration);

        $formData = $this->getResolvedFormData(is_array($businessRegistration?->data) ? $businessRegistration?->data : json_decode($businessRegistration?->data, true), true);
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
                return self::EMPTY_LINES;
            }
            return $value;
        }, $replacements);
    }

    public function resolveBusinessDate($businessRegistration)
    {
        return [
            '{{business.registration_type_id}}' => $businessRegistration?->registrationType?->title ?? self::EMPTY_LINES,
            '{{business.entity_name}}' => $businessRegistration?->entity_name ?? self::EMPTY_LINES,
            '{{business.amount}}' => $businessRegistration?->amount ?? self::EMPTY_LINES,
            '{{business.bill_no}}' => $businessRegistration?->bill_no ?? self::EMPTY_LINES,
            '{{business.application_date}}' => $businessRegistration?->application_date ?? self::EMPTY_LINES,
            '{{business.application_date_en}}' => $businessRegistration?->application_date_en ?? self::EMPTY_LINES,
            '{{business.registration_date}}' => replaceNumbers($businessRegistration?->registration_date, true) ?? self::EMPTY_LINES,
            '{{business.registration_date_en}}' => $businessRegistration?->registration_date_en ?? self::EMPTY_LINES,
            '{{business.registration_number}}' => $businessRegistration?->registration_number ?? self::EMPTY_LINES,
            '{{business.certificate_number}}' => $businessRegistration?->certificate_number ?? self::EMPTY_LINES,
            '{{business.province_id}}' => $businessRegistration?->province?->title ?? self::EMPTY_LINES,
            '{{business.district_id}}' => $businessRegistration?->district?->title ?? self::EMPTY_LINES,
            '{{business.local_body_id}}' => $businessRegistration?->localBody?->title ?? self::EMPTY_LINES,
            '{{business.ward_no}}' => $businessRegistration?->ward_no ?? self::EMPTY_LINES,
            '{{business.way}}' => $businessRegistration?->way ?? self::EMPTY_LINES,
            '{{business.tole}}' => $businessRegistration?->tole ?? self::EMPTY_LINES,
            '{{business.data}}' => $businessRegistration?->data ?? self::EMPTY_LINES,
            '{{business.bill}}' => $businessRegistration?->bill ?? self::EMPTY_LINES,
            '{{business.mobile_no}}' => $businessRegistration?->mobile_no ?? self::EMPTY_LINES,
            '{{business.fiscal_year_id}}' => $businessRegistration?->fiscalYear?->title ?? self::EMPTY_LINES,
            '{{business.business_owner_name}}' => $businessRegistration?->applicant_name ?? self::EMPTY_LINES,
            '{{business.business_owner_number}}' => $businessRegistration?->applicant_number ?? self::EMPTY_LINES,
            '{{business.business_reg_no}}' => $this->reg_no ?? self::EMPTY_LINES,
            '{{business.business_business_nature}}' => $businessRegistration?->businessNature?->title_ne ?? self::EMPTY_LINES,

        ];
    }
}
