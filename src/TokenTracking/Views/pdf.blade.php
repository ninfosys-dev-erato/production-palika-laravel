<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('tokentracking::tokentracking.register_file_report') }}</title>
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
        {{ __('tokentracking::tokentracking.date') }}: {{ $nepaliDate }}
    </div>

    <div>
        यस {{ $startDate }} मितिदेखि {{ $endDate }} मितिसम्मको तथ्याङ्क
    </div>


    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border">टोकन</th>
                <th class="py-2 px-4 border">ग्राहक</th>
                <th class="py-2 px-4 border">मिति</th>
                <th class="py-2 px-4 border">स्थिति</th>
                <th class="py-2 px-4 border">समय</th>
                <th class="py-2 px-4 border">प्रतिक्रिया</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $token)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border">
                        टोकन: {{ $token->token }}<br>
                        उद्देश्य: {{ $token->token_purpose_label }}<br>
                        शाखा: {{ $token->currentBranch->title ?? 'N/A' }}
                    </td>
                    <td class="py-2 px-4 border">
                        @if ($token->tokenHolder)
                            {{ $token->tokenHolder->name }}<br>
                            <small>{{ $token->tokenHolder->mobile_no }}</small><br>
                            <small>{{ $token->tokenHolder->address }}</small>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-2 px-4 border">
                        {{ $token->created_at_bs }}
                    </td>
                    <td class="py-2 px-4 border">
                        चरण:
                        {{ Src\TokenTracking\Enums\TokenStageEnum::from($token->stage)->label() }} <br>
                        स्थिति:
                        {{ Src\TokenTracking\Enums\TokenStatusEnum::from($token->status)->label() }}
                    </td>
                    <td class="py-2 px-4 border">
                        प्रवेश समय: {{ $token->entry_time }}
                        बाहिर समय: {{ $token->exit_time }}
                        अनुमानित समय: {{ $token->estimated_time }}
                    </td>
                    <td class="py-2 px-4 border">
                        @if ($token->feedback->isNotEmpty())
                            गुणस्तर:
                            {{ Src\TokenTracking\Enums\ServiceQualityEnum::from($token->feedback->first()->service_quality)->label() }}
                            <br>
                            पहुँचयोग्यता:
                            {{ Src\TokenTracking\Enums\ServiceAccesibilityEnum::from($token->feedback->first()->service_accesibility)->label() }}
                            <br>
                            सन्तुष्टि:
                            {{ Src\TokenTracking\Enums\CitizenSatisfactionEnum::from($token->feedback->first()->citizen_satisfaction)->label() }}
                        @else
                            कुनै प्रतिक्रिया उपलब्ध छैन
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="footer">
        {{ __('tokentracking::tokentracking.epalika') }}
    </div>
</body>

</html>
