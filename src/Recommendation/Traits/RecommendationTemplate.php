<?php

namespace Src\Recommendation\Traits;

use App\Facades\GlobalFacade;
use App\Models\User;
use App\Traits\HelperTemplate;
use Illuminate\Support\Str;
use Src\FileTracking\Models\FileRecord;
use Src\Recommendation\Models\ApplyRecommendation;
use Symfony\Component\DomCrawler\Crawler;

trait RecommendationTemplate
{
    use HelperTemplate;

    const EMPTY_LINES = '____________________';

    public function resolveRecommendationTemplate(ApplyRecommendation $applyRecommendation): string
    {
        $wardChairperson = User::whereHas('wards', function ($query) {
            $query->where('id', GlobalFacade::ward());
        })
            ->role('वडा अध्यक्ष')
            ->first();

        $applyRecommendation->load(
            'recommendation.form',
            'recommendation.acceptedBy',
            'recommendation.notifyTo',
            'customer.kyc',
            'reviewedBy',
            'acceptedBy'
        );

        $template = $applyRecommendation?->recommendation?->form?->template;
        $wardId = $applyRecommendation->is_ward ? $applyRecommendation->ward_id : null;
        $fileRecord = FileRecord::where('subject_id', $applyRecommendation->id)
            ->whereNull('deleted_at')
            ->first();

        $regNo = $fileRecord && $fileRecord->reg_no
            ? replaceNumbers($fileRecord->reg_no, true)
            : ' ';

        $signeeName = $applyRecommendation?->signee?->name
            ?? $wardChairperson?->name
            ?? "";

        $globalData = $this->getGlobalData($signeeName, $wardId, $applyRecommendation->id);
        // $letterHead = $this->getLetterHeader($wardId, getFormattedBsDate(), $regNo, true, $applyRecommendation?->fiscalYear?->year);

        $letterHead = $this->getRecommendationLetterHead($regNo, $applyRecommendation?->fiscalYear?->year ?? getSetting('fiscal-year)'), true);

        $letterFoot = $this->getFooter();

        $formData = $this->getResolvedFormData(
            is_array($applyRecommendation->data)
                ? $applyRecommendation->data
                : json_decode($applyRecommendation->data, true)
        );

        $relationsHtml = $formData['{{form.relations}}'] ?? '';
        $ppBoxesHtml = '';

        if (!empty($relationsHtml)) {
            $crawler = new Crawler($relationsHtml);
            $rows = $crawler->filter('tbody > tr');

            // Updated styles
            $tableStyle = 'width: 100%; border-collapse: separate; border-spacing: 20px 5px; margin: 20px auto;';
            $boxStyle = 'width: 100px; height: 100px; border: 1px solid #000; margin: 0 auto; background-color: #fff;';
            $nameStyle = 'font-size: 1rem; text-align: center; word-wrap: break-word; padding-top: 5px; ';

            $ppBoxesHtml .= "<table style='{$tableStyle}' class='custom-table'>";

            $itemsPerRow = 5;
            $totalItems = $rows->count();
            $totalRows = ceil($totalItems / $itemsPerRow);

            for ($row = 0; $row < $totalRows; $row++) {
                // First row for photo boxes
                $ppBoxesHtml .= '<tr class="custom-tr">';
                for ($col = 0; $col < $itemsPerRow; $col++) {
                    $index = ($row * $itemsPerRow) + $col;
                    if ($index < $totalItems) {
                        $ppBoxesHtml .= "<td class=\"custom-td\" style='{$boxStyle}; text-align: center; padding:60px 5px;'>हालसालै
खिचेको पासपोर्ट
साइजको फोटा</td>";
                    } else {
                        $ppBoxesHtml .= "<td  class=\"custom-td\" style='width: 25%; text-align: center; padding:60px 5px;'></td>";
                    }
                }
                $ppBoxesHtml .= '</tr>';

                // Second row for names
                $ppBoxesHtml .= '<tr class="custom-tr"> ';
                for ($col = 0; $col < $itemsPerRow; $col++) {
                    $index = ($row * $itemsPerRow) + $col;
                    if ($index < $totalItems) {
                        $columns = $rows->eq($index)->filter('td');
                        $name = $columns->count() > 1 ? trim($columns->eq(1)->text()) :
                            'नाम नदेखियो';
                        $relation = $columns->count() > 1 ? trim($columns->eq(2)->text()) :
                            'नाता';
                        $ppBoxesHtml .= "<td class=\"custom-td\" style='text-align: center; width: 25%;'><div style='{$nameStyle}'>" .
                            htmlspecialchars($name) .
                            ' <br>(<span style="text-shadow: 0.1px 0 #000, -0.2px 0 #000;">' .
                            htmlspecialchars($relation) .
                            '</span>)</div></td>';
                    } else {
                        $ppBoxesHtml .= "<td class=\"custom-td\" style='width: 25%;'></td>";
                    }
                }
                $ppBoxesHtml .= '</tr>';
            }

            $ppBoxesHtml .= '</table>';

            $formData['{{table-boxes}}'] = $ppBoxesHtml;
        }
        $customerData = $this->getCustomerData($applyRecommendation);

        $replacements = array_merge(
            ['{{global.letter-head}}' => $letterHead],
            $globalData,
            $formData,
            $customerData,
            ['{{global.letter-foot}}' => $letterFoot]
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
}
