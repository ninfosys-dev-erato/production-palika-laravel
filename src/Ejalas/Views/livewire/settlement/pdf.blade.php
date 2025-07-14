<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title xlass="text-center">{{ __('ejalas::ejalas.complaint_registration_report') }}</title> --}}
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
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
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

        .center-title {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <table class="main-table">
            <tr>
                <td style="width: 80px;"><img class="logo" src="{{ $palika_logo }}" alt="Logo"></td>
                <td class="title" style="color: red;">
                    {{ $palika_name }} <br>
                    {{ !empty($palika_ward) ? $palika_ward : getSetting('office_name') }} <br><br>
                    {{ $address }}
                </td>
                <td style="width: 80px;"><img class="campaign_logo" src="{{ $palika_campaign_logo }}"
                        alt="Campaign Logo"></td>
            </tr>
        </table>
    </div>



    <div class="date">
        {{ __('ejalas::ejalas.date') }}: {{ $nepaliDate }}
    </div>

    <div class="center-title">
        यस {{ $startDateNp }} मितिदेखि {{ $endDateNp }} मितिसम्मको तथ्याङ्क
    </div>


    <table>
        <thead>
            <tr>
                <th>दर्ता नं</th>
                <th>छलफल मिति</th>
                <th>मिलापत्र मिति</th>
                <th>मिलापत्र व्यहोरा</th>
                <th>मिलापत्र भएको हो?</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr class="hover:bg-gray-50">
                    <td>{{ $report->complaintRegistration->reg_no }}</td>
                    <td>{{ $report->discussion_date_bs }}</td>
                    <td>{{ $report->settlement_date_bs }}</td>
                    <td>{{ $report->settlement_details }}</td>
                    <td>{{ $report->is_settled ? 'मिलापत्र भएको' : 'मिलापत्र बाँकी छ' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="footer">
        {{ __('ejalas::ejalas.epalika') }}
    </div>
</body>

</html>
