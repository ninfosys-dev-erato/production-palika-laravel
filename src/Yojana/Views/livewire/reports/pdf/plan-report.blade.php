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
        <h4>योजनाहरुको प्रतिवेदन</h4>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>सि.न.</th>
                <th>योजनाको नाम</th>
                <th>कार्यान्वयन विधि</th>
                <th>स्थान</th>
                <th>वडा</th>
                <th>कार्यान्वयन तह</th>
                <th>क्षेत्र</th>
                <th>प्रकृति</th>
                <th>उपक्षेत्र</th>
                <th>लक्ष्य समूह</th>
                <th>बिनियोजित बजेट</th>
                <th>बाँकी बजेट</th>
                <th>स्थिति</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $index => $row)
                <tr>
                    <td>{{ replaceNumbers($index + 1, true) }}</td>
                    <td>{{ $row->project_name ?? 'N/A' }}</td>
                    <td>{{ $row->implementationMethod->title ?? 'N/A' }}</td>
                    <td>{{ $row->location ?? 'N/A' }}</td>

                    <td>{{ $row->ward->ward_name_ne ?? 'N/A' }}</td>
                    <td>{{ $row->implementationLevel->title ?? 'N/A' }}</td>


                    <td>{{ $row->planArea->area_name ?? 'N/A' }}</td>
                    <td>{{ $row->nature->label() }}</td>
                    <td>{{ $row->subRegion->name ?? 'N/A' }}</td>
                    <td>{{ $row->target->title ?? 'N/A' }}</td>

                    <td>{{ ' रु '.replaceNumbers($row->allocated_budget, true) ?? 'N/A' }}</td>
                    <td>{{ ' रु '.replaceNumbers($row->remaining_budget, true) ?? 'N/A' }}</td>
                    <td>
                        {{ $row->status instanceof \Src\Yojana\Enums\PlanStatus
                            ? $row->status->label()
                            : PlanStatus::from($row->status) }}
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
