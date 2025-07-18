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
        मिति: {{ $nepaliDate }}
    </div>

    <div>
        यस {{ $startDate }} मितिदेखि {{ $endDate }} मितिसम्मको तथ्याङ्क
    </div>


    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border">परिचय पत्र नं.</th>
                <th class="py-2 px-4 border">पुरा नाम</th>
                <th class="py-2 px-4 border">ठेगाना</th>
                <th class="py-2 px-4 border">कृषक सूचीकरण नं</th>
                <th class="py-2 px-4 border">नागरिकता नं</th>
                <th class="py-2 px-4 border">सम्पर्क नं.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $data)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border">{{ $data->national_id_card_no }}</td>
                    <td class="py-2 px-4 border">
                        {{ $data->user->name }}
                    </td>

                    <td class="py-2 px-4 border">
                        {{ collect([$data->province->title, $data->district->title, $data->ward->ward_name_ne, $data->localBody->title, $data->village, $data->tole])->filter()->join(' ') }}
                    </td>
                    <td class="py-2 px-4 border">{{ $data->farmer_id_card_no }}</td>
                    <td class="py-2 px-4 border">{{ $data->phone_no }}</td>
                    <td class="py-2 px-4 border">{{ $data->citizenship_no }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>


    <div class="footer">
        {{ __('epalika') }}
    </div>
</body>

</html>
