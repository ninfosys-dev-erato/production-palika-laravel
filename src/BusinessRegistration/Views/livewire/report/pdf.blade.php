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

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>क्र.स.</th>
                <th>रजिस्ट्रेसन न</th>
                <th>संस्थाको नाम</th>
                <th>संस्थाको ठेगाना</th>
                <th>प्रकार</th>
                <th>वर्ग</th>
                <th>प्रकृति</th>
                <th>संस्थापकको नाम</th>
                <th>संस्थापकको न</th>
                <th>संस्थापकको ठेगाना</th>
                <th>दर्ता मिती</th>
                <th>आवेदन स्थिति</th>
                <th>व्यापार स्थिति</th>
            </tr>
        </thead>
        <tbody>
            @php $businessNumber = 1; @endphp
            @foreach ($registerBusinessData as $data)
                @if ($data->applicants->count() > 0)
                    @foreach ($data->applicants as $index => $applicant)
                        <tr>
                            <td>
                                @if ($index == 0)
                                    {{ replaceNumbers($businessNumber, true) }}
                                @else
                                    {{ replaceNumbers($businessNumber, true) }}.{{ replaceNumbers($index + 1, true) }}
                                @endif
                            </td>
                            <td>{{ $data->registration_number }}</td>
                            <td>{{ $data->entity_name }}</td>
                            <td>
                                @php
                                    $businessAddress = collect([
                                        $data->businessProvince->title ?? null,
                                        $data->businessDistrict->title ?? null,
                                        $data->businessLocalBody->title ?? null,
                                        $data->business_ward ? 'वडा नं. ' . $data->business_ward : null,
                                        $data->business_tole ?? null,
                                        $data->business_street ?? null,
                                    ])
                                        ->filter()
                                        ->implode(', ');
                                @endphp
                                {{ $businessAddress }}
                            </td>
                            <td>{{ $data->registrationType->registrationCategory->title_ne ?? '' }}</td>
                            <td>{{ $data->registrationType->title ?? '' }}</td>
                            <td>{{ $data->businessNature->title_ne ?? '' }}</td>
                            <td>{{ $applicant->applicant_name ?? '' }}</td>
                            <td>{{ $applicant->phone ?? '' }}</td>
                            <td>
                                @php
                                    $applicantAddress = collect([
                                        $applicant->applicantProvince->title ?? null,
                                        $applicant->applicantDistrict->title ?? null,
                                        $applicant->applicantLocalBody->title ?? null,
                                        $applicant->applicant_ward ? 'वडा नं. ' . $applicant->applicant_ward : null,
                                        $applicant->applicant_tole ?? null,
                                        $applicant->applicant_street ?? null,
                                    ])
                                        ->filter()
                                        ->implode(', ');
                                @endphp
                                {{ $applicantAddress }}
                            </td>
                            <td>{{ $data->application_date }}</td>
                            <td>{{ $data->application_status_nepali }}</td>
                            <td>{{ $data->business_status_nepali }}</td>
                        </tr>
                    @endforeach
                    @php $businessNumber++; @endphp
                @endif
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
