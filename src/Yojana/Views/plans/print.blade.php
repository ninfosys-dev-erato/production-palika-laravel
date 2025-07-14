<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 20px;
        }

        h4 {
            /*border-bottom: 2px solid black;*/
            padding-bottom: 5px;
            margin-top: 30px;
            text-align: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .info-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }

        .info-value {
            color: #000;
        }


        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            /*border: 1px solid #aaa;*/
            padding: 6px 8px;
            text-align: left;
        }

        .with-border {
            border: 1px solid #aaa;
        }

        .no-border {
            border: none; /* Hides borders */
            padding: 6px 8px;
            vertical-align: top;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .bg-light {
            background-color: #f9f9f9;
        }

        .section-divider {
            margin: 20px 0 10px;
            font-weight: bold;
            font-size: 16px;
            color: #01399a;
            border-bottom: 2px solid #01399a;
        }
    </style>
</head>
<body>


{!! $header !!} {{-- renders header  --}}

<h4>योजनाको मूल विवरण</h4>
<table class="table">
    <tbody>
    <tr>
        <td>
            <div class="info-title">आयोजनाको नाम</div>
            <div class="info-value">{{ $plan->project_name }}</div>
        </td>
        <td>
            <div class="info-title">परियोजनाको स्थिति</div>
            <div class="info-value">{{ $plan->status->label() }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">कार्यान्वयन विधि</div>
            <div class="info-value">{{ $plan->implementationMethod->title ?? '-' }}</div>
        </td>
        <td>
            <div class="info-title">स्थान</div>
            <div class="info-value">{{ $plan->location }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">वडा नं.</div>
            <div class="info-value">
                {{ app()->getLocale() === "en" ? ($plan->ward->ward_name_en ?? $plan->ward->ward_name_ne) : ($plan->ward->ward_name_ne ?? $plan->ward->ward_name_en) ?? '-' }}
            </div>
        </td>
        <td>
            <div class="info-title">सुरु भएको आ.व.</div>
            <div class="info-value">{{ $plan->startFiscalYear->year ?? '-' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">संचालन हुने आ.व.</div>
            <div class="info-value">{{ $plan->operateFiscalYear->year ?? '-' }}</div>
        </td>
        <td>
            <div class="info-title">क्षेत्र</div>
            <div class="info-value">{{ $plan->planArea->area_name ?? '-' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">उप-क्षेत्र</div>
            <div class="info-value">{{ $plan->subRegion->name ?? '-' }}</div>
        </td>
        <td>
            <div class="info-title">लक्ष्य</div>
            <div class="info-value">{{ $plan->target->title ?? '-' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">कार्यान्वयन तह</div>
            <div class="info-value">{{ $plan->implementationLevel->title ?? '-' }}</div>
        </td>
        <td>
            <div class="info-title">योजना प्रकार</div>
            <div class="info-value">{{ $plan->plan_type->label() }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">प्रकृति</div>
            <div class="info-value">{{ $plan->nature->label() }}</div>
        </td>
        <td>
            <div class="info-title">योजना ग्रुप</div>
            <div class="info-value">{{ $plan->projectGroup->title ?? '-' }}</div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="info-title">उद्देश्य</div>
            <div class="info-value">{{ $plan->purpose }}</div>
        </td>
        <td>
            <div class="info-title">रातो पुस्तक विवरण/सिन नं.</div>
            <div class="info-value">{{ replaceNumbers($plan->red_book_detail, true) }}</div>
        </td>
    </tr>
    </tbody>
</table>


<h4>बजेट विवरण</h4>

<table class="table">
    <thead class="no-border">
    <tr>
        <th>बिनियोजित बजेट</th>
        <th> रकमान्तर गरिएको रकम</th>
        <th>अन्तिम बजेट</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{' रु ' . replaceNumbersWithLocale(number_format($plan->allocated_budget), true) }}</td>
            <td>{{' रु ' . replaceNumbersWithLocale(number_format($plan->totalTransferAmount), true) }}</td>
            <td>{{' रु ' . replaceNumbersWithLocale(number_format($plan->remaining_amount), true) }}</td>
        </tr>

    </tbody>
</table>


<h4>बजेट स्रोत विवरण</h4>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>स्रोत प्रकार</th>
        <th>कार्यक्रम</th>
        <th>बजेट शीर्षक	</th>
        <th>खर्च शीर्षक	</th>
        <th>आर्थिक वर्ष	</th>
        <th class="text-end">रकम</th>
    </tr>
    </thead>
    <tbody>
    @forelse($plan->budgetSources as $index => $source)
        <tr>
            <td>{{ replaceNumbers($index + 1, true) }}</td>
            <td>{{ $source->sourceType->title ?? '-' }}</td>
            <td>{{ $source->budgetDetail->program ?? '-' }}</td>
            <td>{{ $source->budgetHead->title ?? '-' }}</td>
            <td>{{ $source->expenseHead->title ?? '-' }}</td>
            <td>{{ $source->fiscalYear->year ?? '-' }}</td>
            <td class="text-end">{{' रु '. replaceNumbersWithLocale(number_format($source->amount), true) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">कुनै बजेट स्रोतहरू फेला परेनन्।</td>
        </tr>
    @endforelse

    @if ($plan->budgetSources->count() > 0)
        <tr class="fw-bold bg-light">
            <td colspan="6" class="text-end" style="text-align: right;">कुल:</td>
            <td class="text-end">{{ ' रु '. replaceNumbersWithLocale(number_format($plan->budgetSources->sum('amount')), true) }}</td>
        </tr>
    @endif
    </tbody>
</table>

</body>
</html>
