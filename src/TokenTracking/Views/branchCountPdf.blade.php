<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('Register File Report') }}</title>
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
                    {{ getSetting('office-name') }}<br>
                    {{-- {{ !empty($palika_ward) ? $palika_ward : getSetting('office_name') }} <br><br> --}}
                    {{ $address }}
                </td>
                <td style="width: 80px;"><img class="campaign_logo" src="{{ $palika_campaign_logo }}"
                        alt="Campaign Logo"></td>
            </tr>
        </table>
    </div>


    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            प. स. : {{ getSetting('fiscal-year') }}
            <p>च. न :</p>
        </div>
        <div class="date">
            {{ __('मिति') }}: {{ $nepaliDate }}
        </div>
    </div>
    <div>
        {{ $palika_name }}को कार्यालयबाट {{ $startDate }} मितिदेखि {{ $endDate }} मितिसम्मको
        सम्पादित कार्य को दैनिक प्रगति विवरण
    </div>


    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border" style="width: 50px;">सि.न.</th>
                <th class="py-2 px-4 border">सम्पादन गर्ने सचिवालय</th>
                <th class="py-2 px-4 border" style="width: 100px;">सम्पादित कार्यको संख्या</th>
                <th class="py-2 px-4 border" style="width: 200px;">कैफियत</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $token)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border">{{ replaceNumbers($loop->iteration, true) }}</td>
                    <td class="py-2 px-4 border">{{ $token['branch_name'] }}</td>
                    <td class="py-2 px-4 border" style="width: 100px;">
                        {{ replaceNumbers($token['total_tokens'], true) }}</td>
                    <td class="py-2 px-4 border" style="width: 200px;"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-100">
                <td class="py-2 px-4 border" colspan="2">जम्मा</td>
                <td class="py-2 px-4 border">{{ replaceNumbers($totalTokens, true) }}</td>
                <td class="py-2 px-4 border"></td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align: right;">
        <p>.......................</p>
        <p>{{ $signee ? $signee->name : '' }}</p>
    </div>

    <div>

    </div>


    <div class="footer">
        {{ __('E-Palika') }}
    </div>
</body>

</html>
