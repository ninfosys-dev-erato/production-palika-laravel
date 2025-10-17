<?php

namespace Src\Yojana\Traits;

use App\Traits\HelperTemplate;
use App\Traits\HelperDate;
use Illuminate\Support\Collection;
use Src\Yojana\Models\AgreementFormat;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Enums\SignatureParties;


trait YojanaTemplate
{
    use HelperTemplate, HelperDate;

public function resolveTemplate(Plan | ConsumerCommittee $plan, LetterSample | AgreementFormat $form)
{
    
    // dd(replaceNumbers($plan->agreement->beneficiaries_total_no,true));
    // dd($this->committeeAgreementSignatureDetails($plan));
    $template = $form->sample_letter;
    $replacements = $this->resolveTemplateBindings($template, $plan);

    // Keep model reference for resolving single bindings later
    // $this->model = $plan;

    $resolved = preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($replacements,$plan) {
        $expression = trim($matches[1]);
        // dd($matches, $replacements);
        // --- Function call pattern ---
        // e.g., amountToNepaliWords(costEstimation.total_cost)
        if (preg_match('/^(\w+)\((.*?)\)$/', $expression, $funcParts)) {
            $functionName = $funcParts[1];
            $paramString = trim($funcParts[2]);

            // Split params safely by comma, ignoring commas inside quotes
            $params = preg_split('/,(?=(?:[^"]*"[^"]*")*[^"]*$)/', $paramString);

            $resolvedParams = [];
            foreach ($params as $param) {
                $param = trim($param, " \t\n\r\0\x0B\"'"); // Trim quotes/spaces
                if ($param === '') continue;

                // Try to resolve variable from replacements or directly
                $value = $replacements[$param] ?? $this->resolveSingleBinding($param, $plan);

                // If still null, keep literal string
                $resolvedParams[] = $value ?? $param;
            }

            // If helper function exists, call it with all resolved params
            if (function_exists($functionName)) {
                try {
                    return call_user_func_array($functionName, $resolvedParams);
                } catch (\Throwable $e) {
                    return "_______________";
                }
            }

            // Unknown function
            return "_______________";
        }

        // --- Normal variable replacement ---
        $key = $expression;
        $value = $replacements[$key] ?? "_______________";

        if (is_string($value) || is_numeric($value)) {
            return $value;
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            return $value->implode(', ');
        }

        if (is_object($value) && enum_exists(get_class($value)) && property_exists($value, 'value')) {
            return $value->value;
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        return "_______________";
    }, $template);

    $date = replaceNumbers(ne_date(date('Y-m-d')), true);
    return $this->getBusinessLetterHeaderFromSample() . $resolved;
}

    function resolveTemplateBindings(string $template, Plan | ConsumerCommittee $model): array
    {
        preg_match_all('/{{\s*(.*?)\s*}}/', $template, $matches);
        $results = [];

        foreach ($matches[1] as $binding) {
            $path = explode('.', trim($binding));
            $value = $model;

            foreach ($path as $segment) {
                if (is_null($value)) {
                    break; // any missing relation breaks the chain
                }

                if (is_object($value)) {
                    try {
                        $value = $value->{$segment} ?? null;
                        if ($segment == 'created_at' || $segment == 'updated_at' || $segment == 'deleted_at') {
                            $value = replaceNumbers(ne_date($value->format('Y-m-d')),true);
                        }
                        if ($segment == 'plan_type'){
                            $value = $model->plan_type->label();
                        }if ($segment == 'plan_budget_source_data'){
                            $value = $this->getBudgetSourceData($model);
                        }if ($segment == 'agreement_grant_details'){
                            $value = $this->getAgreementGrantDetails($model);
                        }if ($segment == 'agreement_beneficiary_details'){
                            $value = $this->getAgreementBenificiaries($model);
                        }if ($segment == 'cost_details'){
                            $value = $this->getCostDetails($model);
                        }if ($segment == 'agreement_installment_details'){
                            $value = $this->getAgreementInstallmentDetails($model);
                        }if ($segment == 'agreement_signature_details'){
                            $value = $this->getAgreementSignatureDetails($model);
                        }if ($segment == 'cost_estimation_details'){
                            $value = $this->getCostEstimationDetails($model);
                        }if ($segment == 'agreement_cost_details'){
                            $value = $this->getAgreementCostDetails($model);
                        }if ($segment == 'advance_payment_details'){
                            $value = $this->getAdvancePaymentDetails($model);
                        }if ($segment == 'evaluation_details'){
                            $value = $this->getEvaluationDetails($model);
                        }if ($segment == 'payment_details'){
                            $value = $this->getPaymentDetails($model);
                        }if ($segment == 'palika_name'){
                            $value = $this->getPalikaName();
                        }if ($segment == 'palika_address'){
                            $value = $this->getPalikaAddress();
                        }if ($segment == 'palika'){
                            $value = $this->getPalika();
                        }if ($segment == 'current_date_bs'){
                            $value = getFormattedBsDate() ?? '';
                        }if ($segment == 'expense_heads'){
                            $value = $this->ExpenseHeadList($model) ?? '';
                        }if ($segment == 'committee_payment_amount'){
                            $value = $model->latestPayment->evaluation_amount * 0.25;
                        }
                        if ($segment == 'committee_members_table'){
                            $value = $this->committeeMemberDetails($model) ?? '';
                        }
                        if ($segment == 'committee_agreement_signature_details'){
                            $value = $this->committeeAgreementSignatureDetails($model) ?? '';
                        }
                        if ($segment == 'agreement_beneficiaries_total_no'){
                            $value = $this->totalAgreementBenificiaries($model) ?? '';
                        }
                    } catch (\Throwable $e) {
                        $value = null;
                        break;
                    }
                } elseif (is_array($value)) {
                    $value = $value[$segment] ?? null;
                } else {
                    $value = null;
                    break;
                }
            }

            $results[$binding] = $value;
        }
        return $results;
    }

    private function resolveSingleBinding(string $binding, $model)
    {
        $path = explode('.', $binding);
        $value = $model;
    
        foreach ($path as $segment) {
            if (is_null($value)) break;
    
            if (is_object($value)) {
                if (method_exists($value, $segment) && $value->{$segment}() instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                    $value = $value->{$segment};
                } else {
                    $value = $value->getAttribute($segment);
                }
            } elseif (is_array($value)) {
                $value = $value[$segment] ?? null;
            } else {
                $value = null;
                break;
            }
        }
    
        return $value;
    }
    


    public function getBudgetSourceData($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead style="text-align: left;">
            <tr>
                <th style="border:1px solid black; padding:8px;  text-align: center;">क्र.सं</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('स्रोत प्रकार') . '</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('कार्यक्रम') . '</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('बजेट शीर्षक') . '</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('खर्च शीर्षक') . '</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('आर्थिक वर्ष') . '</th>
                <th style="border:1px solid black; padding:8px;  text-align: center;">' . __('रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->budgetSources->count()) {
            foreach ($plan->budgetSources as $index => $source) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($source->sourceType->title ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($source->budgetDetail->program ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($source->budgetHead->title ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($source->expenseHead->title ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($source->fiscalYear->year ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">  रु ' . replaceNumbers($source->amount, true) . '</td>
            </tr>';
            }

            $html .= '<tr>
            <td colspan="6" style="border:1px solid black; padding:8px; text-align:right; font-weight:bold;">' . __('yojana::yojana.total') . '</td>
            <td style="border:1px solid black; padding:8px; text-align:right; font-weight:bold;">  रु ' . replaceNumbers($plan->budgetSources->sum('amount'), true) . '</td>
        </tr>';
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('बजेट स्रोत छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getAgreementGrantDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead style="text-align: left;">
            <tr style="text-align: left;">
                <th style="border:1px solid black;  padding:8px;">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('स्रोत प्रकार') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('सामग्रीको नाम') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('एकाइ') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->agreement->grants->count()) {
            foreach ($plan->agreement->grants as $index => $grants) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($grants->sourceType->title ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($grants->material_name ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($grants->unit ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">  रु ' . replaceNumbers($grants->amount ?? 0, true) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('वस्तुगत अनुदान छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getAgreementBenificiaries($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px;">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('लाभान्वित हुने') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('कुल संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('पुरुष संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('महिला संख्या') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->agreement->beneficiaries->count()) {
            foreach ($plan->agreement->beneficiaries as $index => $beneficiary) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . ($beneficiary->beneficiary->title ?? '-') . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($beneficiary->total_count ?? 0), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($beneficiary->men_count ?? 0), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($beneficiary->women_count ?? 0), true) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('कुनै लाभार्थी छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getCostDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px;">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('लागतको स्रोत') . '</th>
                <th style="border:1px solid black;  padding:8px;">' . __('रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->costEstimation->costDetails->count()) {
            foreach ($plan->costEstimation->costDetails as $index => $detail) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->sourceType->title . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($detail->cost_amount ?? 0), true) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('लागत स्रोत छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getAgreementInstallmentDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('किस्ता') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('मिति') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('किस्ताको रकम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('निर्माण सामग्री परिमाण') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center";">' . __('प्रतिशत') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->agreement->installmentDetails->count()) {
            $totalCash = 0;
            $totalGoods = 0;
        
            foreach ($plan->agreement->installmentDetails as $index => $detail) {
                $totalCash += $detail->cash_amount ?? 0;
                $totalGoods += $detail->goods_amount ?? 0;
        
                $html .= '<tr style="transition:background-color 0.15s;">
                    <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers($detail->installment_number, true) . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->release_date . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center">रु ' . replaceNumbers($detail->cash_amount, true) . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center">रु ' . replaceNumbers($detail->goods_amount, true) . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers($detail->percentage, true) . ' %</td>
                </tr>';
            }
        
            // Add total row
            $html .= '<tr style="font-weight:bold; ">
                <td colspan="3" style="border:1px solid black; padding:8px; text-align:right;">जम्मा</td>
                <td style="border:1px solid black; padding:8px; text-align:center;">रु ' . replaceNumbers($totalCash, true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align:center;">रु ' . replaceNumbers($totalGoods, true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align:center;"></td>
            </tr>';
        
        } else {
            $html .= '<tr>
                <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                    <i class="bx bx-info-circle me-1"></i>' . __('किस्ता विवरण छैन') . '
                </td>
            </tr>';
        }
        
        $html .= '</tbody></table>';

        return $html;
    }

    public function getAgreementSignatureDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <tbody>
        <tr style="transition:background-color 0.15s;">';

        foreach ($plan->agreement->signatureDetails as $index => $detail) {
            $html .= '
            <td style="border:1px solid black; padding:8px;">
            <br>
                हस्ताक्षर:- <br>
                नाम:- ' . htmlspecialchars($detail->name) . '<br>
                पद:- ' . htmlspecialchars($detail->position) . '<br>
                ठेगाना:- ' . htmlspecialchars($detail->address) . '<br>
                सम्पर्क नम्बर:- ' . replaceNumbers($detail->contact_number, true) . '<br>
                मिति:- ' . replaceNumbers($detail->date, true) . '
            </td>';
        }

        $html .= '</tr></tbody></table>';

        return $html;
    }


    public function committeeAgreementSignatureDetails($plan)
    {
          // Extract members
          $members = $plan->ImplementationAgency->consumerCommittee->committeeMembers ?? collect();
    
          // Extract officer details
          $officer = $plan->agreement->signatureDetails
              ->whereIn('signature_party', ['office', 'planning_department', 'ward'])
              ->last();
            $party = $officer->signature_party;
            $partyLabel = SignatureParties::from($party)->label();

            $html = '<figure class="table">
            <table class="bordered-table" border="1" style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td style="text-align:center;" colspan="3"><strong>उपभोक्ता समिति/समुहको विवरण</strong></td>
                        <td style="text-align:center;" colspan="1"><strong>'.$partyLabel.'को तर्फबाट</strong></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">दस्तखत:</td>
                        <td style="text-align:center;">दस्तखत:</td>
                        <td style="text-align:center;">दस्तखत:</td>
                        <td style="text-align:center;">दस्तखत:</td>
                    </tr>';
        
        
        
            $officerDetails = (object)[
                'name' => $officer->name ?? '',
                'designation' => $officer->position ?? '',
                'address' => $officer->address ?? '',
                'mobile_number' => $officer->contact_number ?? '',
                'date' => ''
            ];
        
        // Only include chair, secretary, and treasurer
        $signatureOrder = ['chair', 'secretary', 'treasurer'];

        $members = $members->filter(function ($m) use ($signatureOrder) {
            $raw = $m->designation;

            // Convert enum to string if needed
            if ($raw instanceof \BackedEnum) {
                $designationKey = strtolower($raw->value);
            } elseif (is_string($raw)) {
                $designationKey = strtolower($raw);
            } else {
                $designationKey = '';
            }

            return in_array($designationKey, $signatureOrder);
        })->sortBy(function ($m) use ($signatureOrder) {
            $raw = $m->designation;

            if ($raw instanceof \BackedEnum) {
                $designationKey = strtolower($raw->value);
            } elseif (is_string($raw)) {
                $designationKey = strtolower($raw);
            } else {
                $designationKey = '';
            }

            return array_search($designationKey, $signatureOrder);
        })->values();

        // Take first 3, then append officer as 4th column
        $members = $members->take(3);
        $members->push($officerDetails);

    
        // Name row
        $html .= '<tr>';
        foreach ($members as $member) {
            $html .= '<td>नाम, थर: ' . ($member->name ?? '') . '</td>';
        }
        $html .= '</tr>';
    
        // Designation row
        $html .= '<tr>';
        foreach ($members as $member) {
            $designation = '';

            if ($member->designation instanceof \BackedEnum) {
                // If it's an enum, get the label() if available
                $designation = method_exists($member->designation, 'label')
                    ? $member->designation->label()
                    : $member->designation->value;
            } elseif (is_string($member->designation)) {
                // If it's a string, use as is
                $designation = $member->designation;
            }

            $html .= '<td>पद: ' . e($designation) . '</td>';
        }
        $html .= '</tr>';

    
        // Address row
        $html .= '<tr>';
        foreach ($members as $member) {
            $html .= '<td>ठेगाना: ' . ($member->address ?? '') . '</td>';
        }
        $html .= '</tr>';
    
        // Contact number row
        $html .= '<tr>';
        foreach ($members as $member) {
            $html .= '<td>सम्पर्क नं: ' . ($member->mobile_number ?? '') . '</td>';
        }
        $html .= '</tr>';
    
        // Date row (current Nepali date)
        $html .= '<tr>';
        $currentDate = now()->format('Y-m-d'); // or getNepaliDate(now())
        foreach ($members as $member) {
            $html .= '<td>मिति: ' . replaceNumbers($this->adToBs($currentDate), true) . '</td>';
        }
        $html .= '</tr>';
    
        // Signature placeholder row
        $html .= '<tr>';
        foreach ($members as $member) {
            $html .= '<td style="height:50px;width:50px;">&nbsp;</td>';
        }
        $html .= '</tr>';
    
        $html .= '</tbody></table></figure>';
    
        return $html;
    }
    


    public function getCostEstimationDetails($plan)
    {
        $costEstimationWithConfig = $plan->costEstimation->total_cost ?? 0;
        $costEstimationAmount = $costEstimationWithConfig;
        $configDetails = '';

        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px;text-align: center;">' . __('विवरण') . '</th>
                <th style="border:1px solid black;  padding:8px;text-align: center;">' . __('रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

            // Config adjustments
            if ($plan->costEstimation && $plan->costEstimation->configDetails->count()) {
                foreach ($plan->costEstimation->configDetails as $detail) {
                    $symbol = '';
                    if ($detail->operation_type === 'add') {
                        $symbol = '+ रु ';
                        $costEstimationAmount -= $detail->amount;
                    } elseif ($detail->operation_type === 'deduct') {
                        $symbol = '- रु ';
                        $costEstimationAmount += $detail->amount;
                    }

                    $amountText = $symbol . replaceNumbers($detail->amount, true);

                    $configDetails .= '<tr>
                    <td style="border:1px solid black; padding:8px; text-align: center;">' .
                        htmlspecialchars($detail->configurationRelation->title) . '</td>
                    <td style="border:1px solid black; padding:8px; text-align: center;">' .
                        $amountText . '</td>
                </tr>';
                }
            }

            // लागत अनुमान (final)
            $html .= '<tr>
            <td style="border:1px solid black; padding:8px; text-align: center;">लागत अनुमान</td>
            <td style="border:1px solid black; padding:8px; text-align: center;"> रु ' .
                replaceNumbers($costEstimationAmount, true) . '</td>
        </tr>';

            // Insert config details
            $html .= $configDetails;

            // जम्मा लागत अनुमान (original/base)
            $html .= '<tr>
            <td style="border:1px solid black; padding:8px; text-align: center;">जम्मा लागत अनुमान</td>
            <td style="border:1px solid black; padding:8px; text-align: center;"> रु ' .
                replaceNumbers($costEstimationWithConfig, true) . '</td>
        </tr>';

            $html .= '</tbody></table>';

            return $html;
    }

    public function getAgreementCostDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कुल रकम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('भ्याट') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('भ्याट सहित कुल रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->agreement->agreementCost) {
            $detail = $plan->agreement->agreementCost;
            $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($detail->total_amount ?? 0), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($detail->total_vat_amount ?? 0), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($detail->total_with_vat ?? 0), true) . '</td>
            </tr>';
        }
        $html .= '</tbody></table>';

        return $html;
    }

    public function getAdvancePaymentDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('भुक्तानी मिति') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->advancePayments->count()) {
            foreach ($plan->advancePayments as $index => $detail) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->date . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers($detail->paid_amount, true) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('अग्रिम भुक्तानी गरिएको छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getEvaluationDetails($plan)
    {
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('किस्ता') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('मूल्यांकन न.') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('मूल्यांकन मिति') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('मूल्यांकन रकम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कर रकम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कर सहित मूल्यांकन रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->evaluations->count()) {
            foreach ($plan->evaluations as $index => $detail) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->installment_no->label() . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' .  replaceNumbers($detail->evaluation_no,true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->evaluation_date . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers((float)$detail->evaluation_amount - (float) $detail->total_vat, true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers($detail->total_vat, true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers($detail->evaluation_amount, true) . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('मूल्यांकन गरिएको छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function committeeMemberDetails($plan){	
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('क्र.स.') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('पद') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('नाम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('ठेगाना/टोल') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('वार्ड नं.') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('ना.प्र.प') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('जिल्ला') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->ImplementationAgency->consumerCommittee->committeeMembers->count()) {
            // Ensure first four records are Chair, Vice-Chair, Secretary, Treasurer (in that order)
            $priorityOrder = [
                'chair' => 0,
                'vice_chair' => 1,
                'secretary' => 2,
                'treasurer' => 3,
            ];

            $members = $plan->ImplementationAgency->consumerCommittee->committeeMembers;
            $sorted = $members->values()->sortBy(function ($m, $i) use ($priorityOrder) {
                $raw = $m->designation;
                // Support backed enums, plain strings, or other scalar representations
                if (is_object($raw) && property_exists($raw, 'value')) {
                    $designationKey = strtolower((string) $raw->value);
                } elseif (is_scalar($raw)) {
                    $designationKey = strtolower((string) $raw);
                } else {
                    $designationKey = '';
                }
                $rank = $priorityOrder[$designationKey] ?? 100;
                return sprintf('%03d-%03d', $rank, $i);
            })->values();

            foreach ($sorted as $index => $detail) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->designation->label() . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->name . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->address . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $plan->ImplementationAgency->consumerCommittee->ward->ward_name_ne . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->citizenship_number . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . 'बर्दिया' . '</td>
            </tr>';
            }
        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function getPaymentDetails($plan)
    {
        $latestPayment = $plan->payments->sortByDesc('created_at')->first();
        $html = '<table style="width:100%; border-collapse:collapse; border:1px solid black;">
        <thead >
            <tr>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('क्रम संख्या') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कर शिर्षक') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('मूल्यांकन रकम') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कर दर') . '</th>
                <th style="border:1px solid black;  padding:8px; text-align: center">' . __('कर रकम') . '</th>
            </tr>
        </thead>
        <tbody>';

        if ($plan->payments->count()) {
            foreach ($latestPayment->taxDeductions as $index => $detail) {
                $html .= '<tr style="transition:background-color 0.15s;">
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers(($index + 1), true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . $detail->configuration->title . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers($detail->evaluation_amount, true) . '</td>
                <td style="border:1px solid black; padding:8px; text-align: center">' . replaceNumbers($detail->rate, true) . '% </td>
                <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers($detail->amount, true) . '</td>
            </tr>';
            }

            $html .= '
                <tr style="transition:background-color 0.15s;">
                        <td colspan="4" style="border:1px solid black; padding:8px; text-align: right"> जम्मा कर कटौती :</td>
                        <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($latestPayment->total_tax_deduction), true) . '</td>
                </tr>
                <tr style="transition:background-color 0.15s;">
                        <td colspan="4" style="border:1px solid black; padding:8px; text-align: right"> जम्मा कटौती :</td>
                        <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($latestPayment->total_deduction), true) . '</td>
                </tr>
                <tr style="transition:background-color 0.15s;">
                        <td colspan="4" style="border:1px solid black; padding:8px; text-align: right">भुक्तानी रकम :</td>
                        <td style="border:1px solid black; padding:8px; text-align: center"> रु ' . replaceNumbers(($latestPayment->paid_amount), true) . '</td>
                </tr>
                ';

        } else {
            $html .= '<tr>
            <td colspan="7" style="border:1px solid black; padding:8px; text-align:center;">
                <i class="bx bx-info-circle me-1"></i>' . __('भुक्तानी गरिएको छैन') . '
            </td>
        </tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    public function totalAgreementBenificiaries($plan){
        return replaceNumbers($plan->agreement->beneficiaries_total_no,true);
    }

    public function ExpenseHeadList($plan){
        // return 'hello';
        return replaceNumbers($plan->getExpenseHeads(), true);
    }
    

    public function getPalikaName()
    {
        return getSetting('palika-name');
    }

    public function getPalikaAddress()
    {
        $palikaName =  getSetting('palika-name');
        $address = explode(' ', $palikaName)[0];
        return $address;
    }
    public function getPalika()
    {
        $palikaName =  getSetting('palika-name');
        $parts = explode(' ', $palikaName);
        $palika = end($parts);
        return $palika;
    }
}
