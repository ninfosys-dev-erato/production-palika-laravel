<?php

namespace App\Traits;

use App\Facades\FileFacade;
use App\Facades\GlobalFacade;
use Illuminate\Database\Eloquent\Model;
use Src\Settings\Models\LetterHeadSample;
use Src\Wards\Models\Ward;
use Illuminate\Support\Str;
use Src\Settings\Enums\TemplateEnum;

trait HelperTemplate
{

    const EMPTY_LINES = "____________________";
    function getLetterHeader(
        ?int $ward_no = null,
        string $date = '',     // default inside function if empty
        string|null $reg_no = '',
        bool $is_darta = true,
        string|null $fiscal_year = ''
    ): string {
        $date = $date ?: getFormattedBsDate() ?? '';
        $fiscal_year = $fiscal_year ?: (getSetting('fiscal-year') ?? self::EMPTY_LINES);



        // Ward or fallback office name
        $office_name = null;
        if ($ward_no) {
            $office_name = Ward::where('id', $ward_no)->value('ward_name_ne');
        }
        $office_name = $office_name ?: getSetting('office-name') ?: self::EMPTY_LINES;

        $palika_name = getSetting('palika-name') ?: self::EMPTY_LINES;
        $palika_logo = getSetting('palika-logo') ?: "";
        $palika_campaign_logo = getSetting('palika-campaign-logo') ?: "";
        $district = getSetting('palika-district') ?: self::EMPTY_LINES;
        $province = getSetting('palika-province') ?: self::EMPTY_LINES;
        $address = trim("{$district}, {$province}, नेपाल", ', ');

        // Darta/Chalani label
        $label = $is_darta ? 'दर्ता नं.' : 'चलानी नं.';

        // Escape dynamic values
        $palika_name = htmlspecialchars($palika_name, ENT_QUOTES, 'UTF-8');
        $office_name = htmlspecialchars($office_name, ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $fiscal_year = htmlspecialchars($fiscal_year, ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
        $reg_no = htmlspecialchars(replaceNumbers($reg_no, true), ENT_QUOTES, 'UTF-8');
        $label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <div class="main-container" style="">
            <table class="main-table" width="100%" cellpadding="0" cellspacing="0" style="padding: 0; margin:0;">
                <tr>
                    <td width="80">
                        <img class="logo" src="{$palika_logo}" alt="Logo" width="80">
                    </td>
                    <td class="title" align="center" valign="middle">
                        <span style="color: red;">
                            <span style="font-size: 1.6rem; font-weight: bold">{$palika_name}</span><br>
                            <span style="font-size: 1.6rem; font-weight: bold">{$office_name}</span><br>
                            <span style="font-size: 1.2rem">{$address}</span>
                        </span>
                    </td>
                    <td width="80">
                        <img class="campaign_logo" src="{$palika_campaign_logo}" alt="Campaign Logo" width="80">
                    </td>
                </tr>
            </table>

            <table width="100%" style="font-size: 0.9rem; margin-top: 0.3rem;">
                <tr>
                    <td width="34%">पत्र संख्या: {$fiscal_year}</td>
                    <td width="33%" rowspan="2" style="text-align: right;">मिति: {$date}</td>

                </tr>
                <tr>
                <td width="33%">चलानी नं./Dis. No.: {$reg_no}</td>
    </tr>
            </table>
            <hr style="margin: 0.5rem 0;">
        </div>
    HTML;
    }

    function getRecommendationLetterHead(string $regNo, string $fiscalYear, bool $is_darta = true): string
    {
        $letterHeadSample = LetterHeadSample::where('slug', TemplateEnum::Recommendation)->whereNull('deleted_at')->first();
        if (!$letterHeadSample) {
            return '';
        }
        $label = $is_darta ? 'दर्ता नं.' : 'चलानी नं.';
        $ward_no = GlobalFacade::ward();
        $office_name = null;
        $office_name_en = null;
        $ward_name = null;
        $ward_name_en = null;
        $ward_location = null;
        if ($ward_no) {
            $office_name = Ward::where('id', $ward_no)->value('ward_name_ne');
            $office_name_en = Ward::where('id', $ward_no)->value('ward_name_en');
            $ward_name = Ward::where('id', $ward_no)->value('address_ne');
            $ward_name_en = Ward::where('id', $ward_no)->value('address_en');
            $ward_location = Ward::where('id', $ward_no)->value('plus_code_location');
        }
        $office_name = $office_name ?: getSetting('office-name') ?: self::EMPTY_LINES;
        $office_name_en = $office_name_en ?: getSetting('office-name-en') ?: self::EMPTY_LINES;

        $additionalData = [
            '{{rec.reg_no}}' => $regNo ?? '',
            '{{rec.fiscal_year}}' => $fiscalYear ?? '',
            '{{rec.label}}' => $label ?? '',
            '{{rec.date}}' => getFormattedBsDate() ?? '',
            '{{rec.office_name}}' => $office_name ?? '',
            '{{rec.office_name_en}}' => $office_name_en ?? '',
            '{{rec.ward_name}}' => $ward_name ?? '',
            '{{rec.ward_name_en}}' => $ward_name_en ?? '',
            '{{rec.ward_location}}' => $ward_location ?? '',
        ];
        $globalData = $this->getGlobalData(null);
        $replacements = array_merge(
            $additionalData,
            $globalData,
        );
        $replacements = $this->sanitizeReplacements($replacements);
        $content =  Str::replace(array_keys($replacements), array_values($replacements), $letterHeadSample->content);
        $style = $letterHeadSample->style ? "<style>{$letterHeadSample->style}</style>" : "";

        return <<<HTML
        {$style}
        {$content}
        HTML;
    }

    function getBusinessLetterHeaderFromSample(): string
    {
        // Fetch the letter head sample by slug
        $letterHeadSample = LetterHeadSample::where('slug', TemplateEnum::Business)
            ->whereNull('deleted_at')
            ->first();

        if (!$letterHeadSample) {
            return '';
        }


        $district = getSetting('palika-district') ?: self::EMPTY_LINES;
        $province = getSetting('palika-province') ?: self::EMPTY_LINES;
        $address = trim("{$district}, {$province}, नेपाल", ', ');


        $globalData = $this->getGlobalData(null);


        $replacements = array_merge(
            $globalData,
        );
        $replacements = $this->sanitizeReplacements($replacements);

        $content =  Str::replace(array_keys($replacements), array_values($replacements), $letterHeadSample->content);

        // Add style if available
        $style = $letterHeadSample->style ? "<style>{$letterHeadSample->style}</style>" : "";

        return <<<HTML
        {$style}
        {$content}
        HTML;
    }

    function getFooter(): string
    {
        $letterHeadSample = LetterHeadSample::where('slug', TemplateEnum::Footer)->whereNull('deleted_at')->first();
        if (!$letterHeadSample) {
            return '';
        }

        $ward_no = GlobalFacade::ward();

        $ward = $ward_no ? Ward::find($ward_no) : null;

        $additionalData = [
            '{{rec.ward_email}}' => $ward?->email ?? '',
            '{{rec.ward_chairperson_no}}' => $ward?->ward_chairperson_no ?? '',
            '{{rec.ward_secretary_no}}' => $ward?->ward_secretary_no ?? '',
            '{{rec.ward_social}}' => $ward?->ward_social ?? '',
        ];

        $globalData = $this->getGlobalData(null);

        $replacements = array_merge(
            $additionalData,
            $globalData,
        );
        $replacements = $this->sanitizeReplacements($replacements);
        $content =  Str::replace(array_keys($replacements), array_values($replacements), $letterHeadSample->content);
        $style = $letterHeadSample->style ? "<style>{$letterHeadSample->style}</style>" : "";
        return <<<HTML
        {$style}
        {$content}
        HTML;
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
    //     function getLetterFooter(
    //         string $document_date = '',
    //         string $copy_no = '1',
    //         string $signature_label = 'प्रमाणित गर्ने'
    //     ): string {
    //         $document_date = $document_date ?: date('Y-m-d');

    //         // Escape to avoid injection in HTML
    //         $document_date = htmlspecialchars($document_date, ENT_QUOTES, 'UTF-8');
    //         $copy_no = htmlspecialchars($copy_no, ENT_QUOTES, 'UTF-8');
    //         $signature_label = htmlspecialchars($signature_label, ENT_QUOTES, 'UTF-8');

    //         return <<<HTML
    //     <div class="letter-footer" style="position: fixed; bottom: -10px; left: 0; right: 0; background-color: white; padding: 1rem 0;">
    //         <table width="100%" style="font-size: 0.9rem;">
    //             <tr>
    //                 <td width="33%">मिति: {$document_date}</td>
    //                 <td width="34%" align="center">प्रतिलिपि संख्या: {$copy_no}</td>
    //                 <td width="33%" align="right">हस्ताक्षर: ____________________</td>
    //             </tr>
    //         </table>

    //         <div style="margin-top: 1rem; font-size: 0.85rem;">
    //             <strong>{$signature_label}</strong><br>
    //             <em>(कर्मचारी/प्रमाणित गर्ने अधिकारी)</em>
    //         </div>
    //     </div>
    // HTML;
    //     }
    function getResolvedFormData(array $submittedData): array
    {
        foreach ($submittedData as $key => $field) {
            if (($field['type'] ?? null) === 'group' && isset($field['fields']) && is_array($field['fields'])) {
                foreach ($field['fields'] as $childKey => $childField) {
                    $submittedData[$childKey] = $childField;
                }
                unset($submittedData[$key]);
            }
        }
        return collect($submittedData)
            ->mapWithKeys(function ($data) {
                $slug = $data['slug'];

                if ($data['type'] === 'table') {
                    $tableHtml = generateTableHtml($data['fields'] ?? []);
                    return ["{{form.{$slug}}}" => $tableHtml];
                } elseif ($data['type'] === 'file') {
                    $fileHtml = getFiles($data['value'] ?? null);
                    return ["{{form.{$slug}}}" => $fileHtml];
                } else {
                    return ["{{form.{$slug}}}" => $data['value'] ?? ''];
                }
            })
            ->toArray();
    }

    function generateTableHtml(array $fields): string
    {
        if (empty($fields)) {
            return '';
        }

        $tableHtml = '<table border="1" style="border-collapse: collapse; width: 100%; border: 1px solid black;">';

        // Generate table headers
        $tableHtml .= '<thead><tr style="background-color: #f2f2f2;">';
        foreach ($fields[0] as $key => $headerField) {
            $label = $headerField['label'] ?? ucfirst($key);
            $tableHtml .= "<th style='border: 1px solid black; padding: 8px;'>{$label}</th>";
        }
        $tableHtml .= '</tr></thead>';

        // Generate table rows
        $tableHtml .= '<tbody>';
        foreach ($fields as $row) {
            $tableHtml .= '<tr>';
            foreach ($row as $column) {
                $value = '-';

                if (is_array($column)) {
                    $value = $column['type'] === 'file'
                        ? getFiles($column['value'] ?? null)
                        : (isset($column['value'])
                            ? (is_array($column['value'])
                                ? (!empty($column['value']) ? implode(', ', $column['value']) : '-')
                                : $column['value'])
                            : '-');
                }

                $tableHtml .= "<td style='border: 1px solid black; padding: 8px;'>{$value}</td>";
            }
            $tableHtml .= '</tr>';
        }
        $tableHtml .= '</tbody>';

        $tableHtml .= '</table>';

        return $tableHtml;
    }

    function getFiles(array|string|null $files, string $path = null): string
    {
        if (is_null($files)) {
            return '';
        }

        $files = is_array($files) ? $files : [$files];
        $path = $path ?? config('src.Recommendation.recommendation.path');

        return collect($files)->reduce(function ($carry, $file) use ($path) {
            $file = FileFacade::getFile($path, $file, 'local');
            if ($file) {
                $image = base64_encode($file);
                return $carry . "<img alt='File' width='50' src='data:image/jpeg;base64,{$image}'>";
            }
            return $carry;
        }, '');
    }

    private function getGlobalData(string|null $signee, int $ward_no = null, $file_record_id = null): array
    {
        $acceptorName = $signee ?? self::EMPTY_LINES;
        return [
            '{{global.province}}' => getSetting('palika-province') ?? self::EMPTY_LINES,
            '{{global.province_en}}' => getSetting('palika-province-eng') ?? self::EMPTY_LINES,
            '{{global.district}}' => getSetting('palika-district') ?? self::EMPTY_LINES,
            '{{global.district_en}}' => getSetting('district-english') ?? self::EMPTY_LINES,
            '{{global.local-body}}' => getSetting('palika-local-body') ?? self::EMPTY_LINES,
            '{{global.ward}}' => getSetting('palika-ward') ?? self::EMPTY_LINES,
            '{{global.today_date_ad}}' => today()->toDateString() ?? self::EMPTY_LINES,
            '{{global.today_date_bs}}' => getFormattedBsDate() ?? self::EMPTY_LINES,
            '{{global.acceptor_sign}}' => '{{global.acceptor_sign}}',
            '{{global.acceptor_name}}' => $acceptorName,
            '{{global.signee_name}}' => $acceptorName,
            '{{global.palika_name}}' => getSetting('palika-name') ?? self::EMPTY_LINES,
            '{{global.palika_name_en}}' => getSetting('palika-name-english') ?: self::EMPTY_LINES,
            '{{global.office_name}}' => getSetting('office-name') ?? self::EMPTY_LINES,
            '{{global.fiscal_year}}' => getSetting('fiscal-year') ?? self::EMPTY_LINES,
            '{{global.palika_address}}' => getSetting('palika-address') ?? self::EMPTY_LINES,
            '{{global.palika_email}}' => getSetting('office_email') ?? self::EMPTY_LINES,
            '{{global.palika_phone}}' => getSetting('office_phone') ?? self::EMPTY_LINES,
            '{{global.palika_logo}}' => getSetting('palika-logo') ?? '',
            '{{global.palika_campaign_logo}}' => getSetting('palika-campaign-logo') ?? '',
        ];
    }

    private function getCustomerData(Model $model): array
    {
        $customer = $model->customer;

        if (!$customer) {
            return [];
        }

        $imagePath = config('src.CustomerKyc.customerKyc.path');

        return [
            '{{customer.name}}' => $customer->name ?? self::EMPTY_LINES,
            '{{customer.email}}' => $customer->email ?? self::EMPTY_LINES,
            '{{customer.mobile_no}}' => $customer->mobile_no ?? self::EMPTY_LINES,
            '{{customer.gender}}' => $customer->gender?->label() ?? self::EMPTY_LINES,
            '{{customer.gender_ne}}' => match ($customer->gender?->value ?? null) {
                'female' => 'महिला',
                'male' => 'पुरुष',
                default => self::EMPTY_LINES,
            },
            '{{customer.nepali_date_of_birth}}' => replaceNumbers($customer->kyc->nepali_date_of_birth, true) ?? self::EMPTY_LINES,
            '{{customer.english_date_of_birth}}' => $customer->kyc->english_date_of_birth ?? self::EMPTY_LINES,
            '{{customer.grandfather_name}}' => $customer->kyc->grandfather_name ?? self::EMPTY_LINES,
            '{{customer.father_name}}' => $customer->kyc->father_name ?? self::EMPTY_LINES,
            '{{customer.mother_name}}' => $customer->kyc->mother_name ?? self::EMPTY_LINES,
            '{{customer.spouse_name}}' => $customer->kyc->spouse_name ?? self::EMPTY_LINES,
            '{{customer.permanent_province_id}}' => $customer->kyc->permanentProvince?->title ?? self::EMPTY_LINES,
            '{{customer.permanent_district_id}}' => $customer->kyc->permanentDistrict?->title ?? self::EMPTY_LINES,
            '{{customer.permanent_local_body_id}}' => $customer->kyc->permanentLocalBody?->title ?? self::EMPTY_LINES,
            '{{customer.permanent_district_id_en}}' => $customer->kyc->permanentDistrict?->title_en ?? self::EMPTY_LINES,
            '{{customer.permanent_local_body_id_en}}' => $customer->kyc->permanentLocalBody?->title_en ?? self::EMPTY_LINES,
            '{{customer.permanent_ward}}' => replaceNumbers($customer->kyc->permanent_ward, true) ?? self::EMPTY_LINES,
            '{{customer.permanent_ward_en}}' => $customer->kyc->permanent_ward ?? self::EMPTY_LINES,
            '{{customer.permanent_tole}}' => $customer->kyc->permanent_tole ?? self::EMPTY_LINES,
            '{{customer.temporary_province_id}}' => $customer->kyc->temporaryProvince?->title ?? self::EMPTY_LINES,
            '{{customer.temporary_district_id}}' => $customer->kyc->temporaryDistrict?->title ?? self::EMPTY_LINES,
            '{{customer.temporary_local_body_id}}' => $customer->kyc->temporaryLocalBody?->title ?? self::EMPTY_LINES,
            '{{customer.temporary_ward}}' => replaceNumbers($customer->kyc->temporary_ward, true) ?? self::EMPTY_LINES,
            '{{customer.temporary_tole}}' => $customer->kyc->temporary_tole ?? self::EMPTY_LINES,
            '{{customer.document_issued_date_nepali}}' => replaceNumbers($customer->kyc->document_issued_date_nepali) ?? self::EMPTY_LINES,
            '{{customer.document_issued_date_english}}' => $customer->kyc->document_issued_date_english ?? self::EMPTY_LINES,
            '{{customer.document_number}}' => $customer->kyc->document_number ?? self::EMPTY_LINES,
            '{{customer.document_image1}}' => 'data:image/jpeg;base64,' . base64_encode(
                FileFacade::getFile($imagePath, (string) $customer->kyc?->document_image1)
            ),
            '{{customer.document_image2}}' => 'data:image/jpeg;base64,' . base64_encode(
                FileFacade::getFile($imagePath, (string) $customer->kyc?->document_image2)
            ),
            '{{customer.expiry_date_nepali}}' => $customer->kyc->expiry_date_nepali ?? self::EMPTY_LINES,
            '{{customer.expiry_date_english}}' => $customer->kyc->expiry_date_english ?? self::EMPTY_LINES
        ];
    }

    function getLetterHeaderForBusiness(
        ?int $ward_no = null,
        string $date = '',     // default inside function if empty
        string|null $reg_no = '',
        bool $is_darta = true,
        string|null $fiscal_year = ''
    ): string {
        $date = $date ?: date('Y-m-d');
        $fiscal_year = $fiscal_year ?: (getSetting('fiscal-year') ?? self::EMPTY_LINES);



        // Ward or fallback office name
        $office_name = null;
        if ($ward_no) {
            $office_name = Ward::where('id', $ward_no)->value('ward_name_ne');
        }
        $office_name = $office_name ?: getSetting('office-name') ?: self::EMPTY_LINES;

        $palika_name = getSetting('palika-name') ?: self::EMPTY_LINES;
        $palika_logo = getSetting('palika-logo') ?: "";
        $palika_campaign_logo = getSetting('palika-campaign-logo') ?: "";
        $district = getSetting('palika-district') ?: self::EMPTY_LINES;
        $province = getSetting('palika-province') ?: self::EMPTY_LINES;
        $address = trim("{$district}, {$province}, नेपाल", ', ');

        // Darta/Chalani label
        $label = $is_darta ? 'दर्ता नं.' : 'चलानी नं.';

        // Escape dynamic values
        $palika_name = htmlspecialchars($palika_name, ENT_QUOTES, 'UTF-8');
        $office_name = htmlspecialchars($office_name, ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $fiscal_year = htmlspecialchars($fiscal_year, ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
        $reg_no = htmlspecialchars($reg_no, ENT_QUOTES, 'UTF-8');
        $label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0;">
    <tr>
                    <td width="80">
                        <img class="logo" src="{$palika_logo}" alt="Logo" width="80">
                    </td>
        <!-- Center Content -->
        <td align="center" valign="middle">
            <div style="color: red; line-height: 1.6;">
                <div style="
    font-size: 16pt;
    font-weight: bold;
    color: red;
    text-align: center;
    width: 100%;
    white-space: nowrap;
">
                    {$palika_name}
                </div>
                <div style="font-size: 22pt; font-weight: 600;">
                    {$office_name}
                </div>
                <div style="font-size: 14pt;">
                  {$address}
                </div>
            </div>
        </td>


        <td width="80" align="right" valign="middle">

        </td>
    </tr>
</table>
HTML;
    }
}
