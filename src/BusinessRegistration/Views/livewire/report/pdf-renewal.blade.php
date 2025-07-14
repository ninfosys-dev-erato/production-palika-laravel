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

    <div class="main-container">
        <table class="main-table">
            <tr>
                <td style="width: 80px;"><img class="logo" src="{{ $palika_logo }}" alt="Logo"></td>
                <td class="title" style="color: red;">
                    {{ $palika_name }} <br>
                    {{ !empty($palika_ward) ? $palika_ward : getSetting('office_name') }} <br>
                    {{ $address }}
                </td>
                <td style="width: 80px;"><img class="campaign_logo" src="{{ $palika_campaign_logo }}"
                        alt="Campaign Logo"></td>
            </tr>
        </table>
    </div>



    <div class="date">
        {{ __('मिति') }}: {{ $nepaliDate }}
    </div>

    <div class="text-center">
        यस {{ $startDate }} मितिदेखि {{ $endDate }} मितिसम्मको तथ्याङ्क
    </div>

    <table class="table table-bordered table-responsive">
        <thead class="table-light">
            <tr>
                <th>क्र.स.</th>
                <th>दर्ता नं</th>
                <th>संस्था/फर्मको नाम</th>
                <th>संस्था/फर्मको ठेगाना</th>
                <th>संस्था/फर्मको प्रकार</th>
                <th>व्यवसायीको नाम</th>
                <th>समपर्क न‌</th>
                <th>दर्ता मिती </th>
                <th>पछिल्लो नविकरण मिति</th>
                <th>नविकरण रकम</th>
                <th>जरिवाना रकम</th>
                <th>रसिद नं</th>
                <th>रसिद मिति</th>
                <th>स्थिति</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($renewalBusinessData as $data)
                <tr>
                    <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                    <td>{{ replaceNumbers($data->registration_no, true) }}</td>
                    <td>{{ $data->registration?->entity_name }}</td>
                    <td>
                        {{ $data->registration?->province->title ?? '' }}
                        {{ $data->registration?->district->title ?? '' }}
                        {{ $data->registration?->localBody->title ?? '' }}
                        {{ $data->registration?->ward_no ? ' वडा नं. ' . $data->registration?->ward_no : '' }}
                    </td>
                    <td>{{ $data->registration?->registrationType?->registrationCategory?->title_ne }}</td>
                    <td>{{ $data->registration?->applicant_name }}</td>
                    <td>{{ $data->registration?->applicant_number }}</td>
                    <td>{{ replaceNumbers($data->renew_date, true) }}</td>
                    <td>{{ replaceNumbers($data->date_to_be_maintained, true) }}</td>
                    <td>{{ replaceNumbers($data->renew_amount, true) }}</td>
                    <td>{{ replaceNumbers($data->penalty_amount, true) }}</td>
                    <td>{{ replaceNumbers($data->bill_no, true) }}</td>
                    <td>{{ replaceNumbers($data->payment_receipt_date, true) }}</td>
                    <td>{{ Src\BusinessRegistration\Enums\ApplicationStatusEnum::getNepaliLabel($data->application_status) }}
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <table class="ref-section">
            <tr>
                <td class="ref-left">
                    प्रिन्ट गर्ने व्यक्ति: {{ $user->name }}
                </td>
                <td class="ref-right">
                    स्वीकृत गर्ने
                </td>
            </tr>
        </table>
        <p style="text-align: left;">लागू गरिएका फिल्टरहरू:
            {{ implode(' , ', $appliedFilters) }}
        </p>
        {{ __('E-Palika') }}

    </div>
</body>

</html>
