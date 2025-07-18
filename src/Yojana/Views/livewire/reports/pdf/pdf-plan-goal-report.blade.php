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
        <h4>योजना लक्ष्य संक्षिप्त प्रतिवेदन</h4>
    </div>

    <table class="table table-bordered table-striped" id="print-content">
        <thead>
            <tr>
                <th>सि.न.</th>
                <th>प्रगति सूचक र इकाई</th>
                <th>कुल योजना</th>
                <th>कुल लक्ष्य</th>
                <th>सम्पन्न लक्ष्य</th>
                <th>कुल लक्ष्य</th>
                <th>सम्पन्न लक्ष्य</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($query as $index => $row)
                <tr>
                    <td>{{ replaceNumbers($index + 1, true) }}</td>
                    <td>{{ $row->title . ' ( ' . $row->unit->symbol . ' )' }}</td>
                    <td>{{ replaceNumbers($row->targetEntries->count('plan'), true) }}</td>
                    @php
                        $totalPhysicalGoals = $row->targetEntries
                            ->filter(fn($entry) => is_null($entry->deleted_at))
                            ->sum(fn($entry) => floatval($entry->total_physical_goals));

                        $totalFinancialGoals = $row->targetEntries
                            ->filter(fn($entry) => is_null($entry->deleted_at))
                            ->sum(fn($entry) => floatval($entry->total_financial_goals));
                    @endphp

                    <td>{{ replaceNumbers($totalPhysicalGoals, true) }}</td>
                    <td>{{ replaceNumbers($totalFinancialGoals, true) }}</td>
                    <td>{{ replaceNumbers($row->targetEntries->whereNull('deleted_at')->sum('completed_physical_goals'), true) }}
                    </td>
                    <td>{{ replaceNumbers($row->targetEntries->whereNull('deleted_at')->sum('completed_financial_goals'), true) }}
                    </td>
                </tr>
            @endforeach

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
