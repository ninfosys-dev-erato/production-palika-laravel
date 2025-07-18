<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @font-face {
            font-family: Nirmala;
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Nirmala.ttf') }}') format('truetype');
        }

        body {
            font-family: Nirmala;
            font-size: 14px;

        }


        .filters {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .filters p {
            margin: 2px 0;
        }


        .date {
            text-align: right;
            font-size: 14px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
        }



        .main-container {
            width: 100%;
            border-bottom: 2px solid black;
            text-align: center;
            padding: 10px 0;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .main-table td {
            border: none;
        }

        .logo,
        .campaign_logo {
            width: 80px;
            height: auto;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }


        .ref-left {
            width: 60%;
            vertical-align: top;
            font-size: 16px;
        }

        .ref-right {
            width: 40%;
            text-align: right;
            vertical-align: top;
            font-size: 16px;
        }

        .ref-section table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            margin-top: 40px;
            border: none !important;
            font-weight: bold;
        }

        .ref-section td,
        .ref-section tr {
            border: none !important;
            padding-top: 10px;
            padding-bottom: 5px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>


    {!! $header !!} {{-- renders header  --}}

     <div class="text-center">
        <h4>संचालित योजनाहरुको सारांश प्रतिवेदन</h4>
     </div>

    <table class="table table-bordered table-striped" id="print-content">
        <thead>
        <tr>
            <th>सि.न.</th>
            <th>क्षेत्रको नाम</th>
            <th>खर्च शीर्षक</th>
            <th>आयोजनाको नाम</th>
            <th>वडा</th>
            <th>सम्झौता मिति</th>
            <th>विनियोजित बजेट</th>
            <th>कुल भुक्तानी</th>
            <th>लक्ष्य प्रविष्टि</th>
            <th>लक्ष्य सम्पन्न</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totalBudget = 0;
            $total_payment = 0;
        @endphp
        @foreach ($plans as $index => $row)
            <tr>
                <td>{{ replaceNumbers($index + 1, true) }}</td>
                <td>{{ $row->planArea->area_name ?? 'N/A' }}</td>
                <td>
                    @php
                        $uniqueExpenseHeads = $row->budgetSources
                            ->pluck('expenseHead.title')
                            ->filter()
                            ->unique();
                        $payment_amount = ($row->total_advance_paid ?? 0) + ($row->total_payment ?? 0)
                    @endphp
                    {{ $uniqueExpenseHeads->isNotEmpty() ? $uniqueExpenseHeads->implode(', ') : 'N/A' }}
                </td>
                <td>{{ $row->project_name }}</td>
                <td>{{ replaceNumbers($row->ward_id, true) }}</td>

                <td>{{ replaceNumbers($row->created_at_nepali, true) ?? 'N/A' }}</td>

                {{-- <td>{{ $row->latestPayment?->payment_date ?? 'N/A' }}</td> --}}
                <td>{{ replaceNumbers($row->allocated_budget, true) }}</td>
                <td>{{ replaceNumbers(($payment_amount), true) }}</td>

                <td>
                    भौतिक: {{ replaceNumbers($row->targetEntries->sum('total_physical_goals'), true) }} <br>

                    वित्तीय: {{ replaceNumbers($row->targetEntries->sum('total_financial_goals'), true) }}
                </td>
                <td>
                    भौतिक: {{ replaceNumbers($row->targetEntries->flatMap->targetCompletions->sum('completed_physical_goal'), true) ?? 'N/A' }} <br>

                    वित्तीय: {{ replaceNumbers($row->targetEntries->flatMap->targetCompletions->sum('completed_financial_goal'), true) ?? 'N/A' }}
                </td>
            </tr>
            @php
                $totalBudget += $row->allocated_budget;
                $total_payment += $payment_amount;
            @endphp
        @endforeach
        <tr>
            <td colspan="5"></td>
            <td class="text-right"><strong>जम्मा</strong></td>
            <td><strong>{{ replaceNumbers($totalBudget, true) }}</strong></td>
            <td><strong>{{ replaceNumbers($total_payment, true) }}</strong></td>
            <td></td>
            <td></td>
        </tr>

        </tbody>
    </table>

    <div class="footer">
        {{-- <table class="ref-section">
            <tr>
                <td class="ref-left">
                    प्रिन्ट गर्ने व्यक्ति: {{ $user->name }}
                </td>
                <td class="ref-right">
                    स्वीकृत गर्ने
                </td>
            </tr>
        </table> --}}

        {{ __('yojana::yojana.epalika') }}

    </div>
</body>

</html>
