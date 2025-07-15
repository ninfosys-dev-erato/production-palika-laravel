<?php

namespace App\Traits;

use App\Facades\ImageServiceFacade;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;

trait MapApplyTrait
{
    const EMPTY_LINES = '____________________';
    
    public function resolveMapStepTemplate($mapApply, $mapStep, $form): string
    {
        if (!$mapApply || !$form) {
            return '';
        }

        $mapApply?->load('customer.kyc', 'fiscalYear', 'landDetail.fourBoundaries', 'constructionType', 'mapApplySteps', 'houseOwner');

        $signatures = '______________________';

        $letter = [
            'header' => getLetterHeader(null),
            'footer' => getLetterFooter(null),
        ];

        $template = MapApplyStepTemplate::where('form_id', $form->id)->first();
        $submittedData = [];
        if ($template && $template->data) {
            $submittedData = is_array($template->data)
                ? $template->data
                : json_decode($template->data, true) ?? [];
        }
        
        $data = [
            '{{global.letter-head}}' => $letter['header'] ?? self::EMPTY_LINES,
            '{{global.letter-head-footer}}' => $letter['footer'] ?? self::EMPTY_LINES,
            '{{global.province}}' => getSetting('palika-province') ?? self::EMPTY_LINES,
            '{{global.district}}' => getSetting('palika-district') ?? self::EMPTY_LINES,
            '{{global.local-body}}' => getSetting('palika-local-body') ?? self::EMPTY_LINES,
            '{{global.ward}}' => replaceNumbers(getSetting('palika-ward', true)) ?? self::EMPTY_LINES,
            '{{global.today_date_ad}}' => today()->toDateString(),
            '{{global.today_date_bs}}' => getFormattedBsDate() ?? self::EMPTY_LINES,
            '{{global.business_status}}' => $mapApply?->businessRegistration?->business_status ?? self::EMPTY_LINES,
            '{{global.registration_number}}' => $mapApply?->businessRegistration?->registration_number ?? self::EMPTY_LINES,
            '{{global.registration_date}}' => $mapApply?->businessRegistration?->registration_date ?? self::EMPTY_LINES,
            '{{global.rejected_reason}}' => $mapApply?->businessRegistration?->application_rejection_reason ?? self::EMPTY_LINES,
            ...getResolvedFormData($submittedData)
        ];

        if($mapApply?->customer && $mapApply?->customer->kyc)
        {
            $data = array_merge($data, $this->resolveCustomerData($mapApply));
        }
        
        if($mapApply?->landDetail)
        {
            $data = array_merge($data, $this->resolveLandDetails($mapApply));
        }
        
        if($mapApply?->houseOwner || $mapApply?->landOwner)
        {
            $data = array_merge($data, $this->resolveHouseOwnerDetails($mapApply));
            $data = array_merge($data, $this->resolveLandOwnerDetails($mapApply));
        }      
          
        
        $data = array_merge($data, $this->resolveApplicantDetails($mapApply));
        
        if($mapApply?->signature)
        {
            $data = array_merge($data, [
                '{{mapApply.signature}}' => '<img src="data:image/jpeg;base64,' . base64_encode(\App\Facades\ImageServiceFacade::getImage(config('src.Ebps.ebps.path'), $mapApply?->signature, 'local')) . '" alt="Signature" width="80">',
                '{{form.approver.signature}}' => $signatures,
            ]);
        }

        $data = array_map(fn($value) => is_array($value) ? json_encode($value) : (string) $value, $data);

        return \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $form->template ?? '');
    }

    private function resolveCustomerData($mapApply)
    {
        if (!$mapApply?->customer || !$mapApply?->customer->kyc) {
            return [];
        }

        $kyc = $mapApply?->customer->kyc;
        
        return [
            '{{customer.nepali_date_of_birth}}' => $kyc?->nepali_date_of_birth ?? self::EMPTY_LINES,
            '{{customer.english_date_of_birth}}' => $kyc?->english_date_of_birth ?? self::EMPTY_LINES,
            '{{customer.grandfather_name}}' => $kyc?->grandfather_name ?? self::EMPTY_LINES,
            '{{customer.father_name}}' => $kyc?->father_name ?? self::EMPTY_LINES,
            '{{customer.mother_name}}' => $kyc?->mother_name ?? self::EMPTY_LINES,
            '{{customer.spouse_name}}' => $kyc?->spouse_name ?? self::EMPTY_LINES,
            '{{customer.permanent_province_id}}' => isset($kyc?->permanentProvince, $kyc?->permanentProvince->title) ? $kyc?->permanentProvince->title : self::EMPTY_LINES,
            '{{customer.permanent_district_id}}' => isset($kyc?->permanentDistrict, $kyc?->permanentDistrict->title) ? $kyc?->permanentDistrict->title : self::EMPTY_LINES,
            '{{customer.permanent_local_body_id}}' => isset($kyc?->permanentLocalBody, $kyc?->permanentLocalBody->title) ? $kyc?->permanentLocalBody->title : self::EMPTY_LINES,
            '{{customer.permanent_ward}}' => replaceNumbers($kyc?->permanent_ward, true) ?? self::EMPTY_LINES,
            '{{customer.permanent_tole}}' => $kyc?->permanent_tole ?? self::EMPTY_LINES,
            '{{customer.temporary_province_id}}' => isset($kyc?->temporaryProvince, $kyc?->temporaryProvince->title) ? $kyc?->temporaryProvince->title : self::EMPTY_LINES,
            '{{customer.temporary_district_id}}' => isset($kyc?->temporaryDistrict, $kyc?->temporaryDistrict->title) ? $kyc?->temporaryDistrict->title : self::EMPTY_LINES,
            '{{customer.temporary_local_body_id}}' => isset($kyc?->temporaryLocalBody, $kyc?->temporaryLocalBody->title) ? $kyc?->temporaryLocalBody->title : self::EMPTY_LINES,
            '{{customer.temporary_ward}}' => replaceNumbers($kyc?->temporary_ward, true) ?? self::EMPTY_LINES,
            '{{customer.temporary_tole}}' => $kyc?->temporary_tole ?? self::EMPTY_LINES,
            '{{customer.document_issued_date_nepali}}' => $kyc?->document_issued_date_nepali ?? self::EMPTY_LINES,
            '{{customer.document_issued_date_english}}' => $kyc?->document_issued_date_english ?? self::EMPTY_LINES,
            '{{customer.document_number}}' => $kyc?->document_number ?? self::EMPTY_LINES,
            '{{customer.document_image1}}' => $kyc?->document_image1 ? "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $kyc?->document_image1, 'local')) : self::EMPTY_LINES,
            '{{customer.document_image2}}' => $kyc?->document_image2 ? "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $kyc?->document_image2, 'local')) : self::EMPTY_LINES,
            '{{customer.expiry_date_nepali}}' => $kyc?->expiry_date_nepali ?? self::EMPTY_LINES,
            '{{customer.expiry_date_english}}' => $kyc?->expiry_date_english ?? self::EMPTY_LINES,
        ];
    }
    
    private function resolveHouseOwnerDetails($mapApply)
    {
        if (!$mapApply?->houseOwner) {
            return [];
        }

        $houseOwner = $mapApply?->houseOwner ?? self::EMPTY_LINES;
        
        return [
            '{{mapApply.houseOwnerName}}' => $houseOwner?->owner_name ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerMobileNo}}' => replaceNumbers($houseOwner?->mobile_no, true) ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerFatherName}}' => $houseOwner?->father_name ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerGrandFatherName}}' => $houseOwner?->grand_father_name ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerCitizenshipNo}}' => replaceNumbers($houseOwner?->citizenship_no, true) ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerProvince}}' => isset($houseOwner?->province, $houseOwner?->province->title) ? $houseOwner?->province->title : self::EMPTY_LINES,
            '{{mapApply.houseOwnerDistrict}}' => isset($houseOwner?->district, $houseOwner?->district->title) ? $houseOwner?->district->title : self::EMPTY_LINES,
            '{{mapApply.houseOwnerLocalBody}}' => isset($houseOwner?->local_body, $houseOwner?->local_body->title) ? $houseOwner?->local_body->title : self::EMPTY_LINES,
            '{{mapApply.houseOwnerWard}}' => replaceNumbers($houseOwner?->ward, true) ?? self::EMPTY_LINES,
            '{{mapApply.houseOwnerTole}}' => $houseOwner?->tole ?? self::EMPTY_LINES,
        ];
    }
    private function resolveLandOwnerDetails($mapApply)
    {
    
        $landOwner = $mapApply?->landOwner ?? $mapApply?->houseOwner;
        
        return [
            '{{mapApply.landOwnerName}}' => $landOwner?->owner_name ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerMobileNo}}' => replaceNumbers($landOwner?->mobile_no, true) ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerFatherName}}' => $landOwner?->father_name ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerGrandFatherName}}' => $landOwner?->grand_father_name ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerCitizenshipNo}}' => replaceNumbers($landOwner?->citizenship_no, true) ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerProvince}}' => isset($landOwner?->province, $landOwner?->province->title) ? $landOwner?->province->title : self::EMPTY_LINES,
            '{{mapApply.landOwnerDistrict}}' => isset($landOwner?->district, $landOwner?->district->title) ? $landOwner?->district->title : self::EMPTY_LINES,
            '{{mapApply.landOwnerLocalBody}}' => isset($landOwner?->local_body, $landOwner?->local_body->title) ? $landOwner?->local_body->title : self::EMPTY_LINES,
            '{{mapApply.landOwnerWard}}' => replaceNumbers($landOwner?->ward, true) ?? self::EMPTY_LINES,
            '{{mapApply.landOwnerTole}}' => $landOwner?->tole ?? self::EMPTY_LINES,
        ];
    }

    private function resolveApplicantDetails($mapApply)
    {
        return [
            '{{mapApply.applicantName}}' => $mapApply?->full_name ?? self::EMPTY_LINES,
            '{{mapApply.applicantMobileNo}}' => replaceNumbers($mapApply?->mobile_no, true) ?? self::EMPTY_LINES,
            '{{mapApply.applicantProvince}}' => isset($mapApply?->province, $mapApply?->province->title) ? $mapApply?->province->title : self::EMPTY_LINES,
            '{{mapApply.applicantDistrict}}' => isset($mapApply?->district, $mapApply?->district->title) ? $mapApply?->district->title : self::EMPTY_LINES,
            '{{mapApply.applicantLocalBody}}' => isset($mapApply?->localBody, $mapApply?->localBody->title) ? $mapApply?->localBody->title : self::EMPTY_LINES,
            '{{mapApply.applicantWard}}' => replaceNumbers($mapApply?->ward_no, true) ?? self::EMPTY_LINES,
        ];
    }

    private function resolveLandDetails($mapApply)
    {
        if (!$mapApply?->landDetail) {
            return [];
        }

        $landDetail = $mapApply?->landDetail;
        $fourBoundaries = $landDetail->fourBoundaries ?? collect();
        
        $fourBoundariesTable = '';
        if ($fourBoundaries->isNotEmpty()) {
            $fourBoundariesTable = '<table style="width:100%; border-collapse: collapse;" border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #000;">नाम</th>
                        <th style="border: 1px solid #000;">दिशा</th>
                        <th style="border: 1px solid #000;">दूरी</th>
                        <th style="border: 1px solid #000;">कित्ता नं</th>
                    </tr>
                </thead>
                <tbody>' .
                $fourBoundaries->map(
                    fn($fort) =>
                    "<tr>
                        <td style='border: 1px solid #000;'>" . (isset($fort?->title) ? $fort?->title : self::EMPTY_LINES) . "</td>
                        <td style='border: 1px solid #000;'>" . (isset($fort?->direction) ? $fort?->direction : self::EMPTY_LINES) . "</td>
                        <td style='border: 1px solid #000;'>" . (isset($fort?->distance) ? replaceNumbers($fort?->distance, true): self::EMPTY_LINES) . "</td>
                        <td style='border: 1px solid #000;'>" . (isset($fort?->lot_no) ? replaceNumbers($fort?->lot_no, true) : self::EMPTY_LINES) . "</td>
                    </tr>"
                )->implode('') .
                '</tbody></table>';
        }

        return [
            '{{mapApply.customer.name}}' => isset($mapApply?->customer, $mapApply?->customer->name) ? $mapApply?->customer->name : 'Not Provided',
            '{{mapApply.landDetail.ward_no}}' => isset($landDetail->ward) ? replaceNumbers($landDetail->ward, true) : self::EMPTY_LINES,
            '{{mapApply.landDetail.tole}}' => isset($landDetail->tole) ? $landDetail->tole : self::EMPTY_LINES,
            '{{mapApply.landDetail.plot_no}}' => isset($landDetail->lot_no) ? replaceNumbers($landDetail->lot_no, true) : self::EMPTY_LINES,
            '{{mapApply.landDetail.area}}' => isset($landDetail->area_sqm) ? replaceNumbers($landDetail->area_sqm, true) : self::EMPTY_LINES,
            '{{mapApply.landDetail.ownership_type}}' => isset($landDetail->ownership) ? $landDetail->ownership : self::EMPTY_LINES,
            '{{mapApply.landDetail.former_ward}}' => isset($landDetail->ward) ? replaceNumbers($landDetail->ward, true) : self::EMPTY_LINES,
            '{{mapApply.landDetail.former_localBody}}' => isset($landDetail->localBody, $landDetail->localBody->title) ? $landDetail->localBody->title : self::EMPTY_LINES,
            '{{mapApply.usage}}' => isset($mapApply?->usage) ? $mapApply?->usage : self::EMPTY_LINES,
            '{{mapApply.landDetail.fourForts:name,direction,distance_to,plot_no}}' => $fourBoundariesTable,
            '{{mapApply.constructionType.title}}' => isset($mapApply?->constructionType, $mapApply?->constructionType->title) ? $mapApply?->constructionType->title : self::EMPTY_LINES,
            '{{mapApply.customer.age}}' => isset($mapApply?->customer, $mapApply?->customer->customerDetail, $mapApply?->customer->customerDetail->age) ? $mapApply?->customer->customerDetail->age : self::EMPTY_LINES,
            '{{customer.phone}}' => isset($mapApply?->customer, $mapApply?->customer->phone) ? replaceNumbers($mapApply?->customer->phone, true): self::EMPTY_LINES,
            '{{mapApply.customer.phone}}' => isset($mapApply?->customer, $mapApply?->customer->mobile_no) ? replaceNumbers($mapApply?->customer->mobile_no, true) : self::EMPTY_LINES,
            '{{mapApply.appliedDate}}' => isset($mapApply?->applied_date, $mapApply?->applied_date) ? replaceNumbers($mapApply?->applied_date, true) : self::EMPTY_LINES,
        ];
    }
}
