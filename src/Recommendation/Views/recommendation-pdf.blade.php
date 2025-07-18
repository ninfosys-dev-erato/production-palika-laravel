<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('recommendation::recommendation.register_file_report') }}</title>
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
                    {{ $palika_ward }} <br>
                    {{ $address }}
                </td>
                <td style="width: 80px;"><img class="campaign_logo" src="{{ $palika_campaign_logo }}"
                        alt="Campaign Logo"></td>
            </tr>
        </table>
    </div>

    <div class="title">{{ __('recommendation::recommendation.recommendation_report') }}</div>


    <div class="date">
        {{ __('recommendation::recommendation.date') }}: {{ $nepaliDate }}
    </div>

    <div class="filters" style="display: flex; align-items: center; gap: 10px;">
        {{ __('recommendation::recommendation.applied_filters') }} :
        @if (count($filters))
            @foreach ($filters as $filter)
                <span>{{ $filter['label'] }}: {{ $filter['value'] }}</span>
            @endforeach
        @else
            <span>{{ __('recommendation::recommendation.no_filters_applied') }}</span>
        @endif
    </div>

    <table>
        <thead class="table-primary">
            <tr>
                <td>{{ __('recommendation::recommendation.sn') }}</td>
                <td>{{ __('recommendation::recommendation.reg_no') }}</td>
                <td>{{ __('recommendation::recommendation.category') }}</td>
                <td>{{ __('recommendation::recommendation.recommendation') }}</td>
                <td>{{ __('recommendation::recommendation.customer') }}</td>
                <td>{{ __('recommendation::recommendation.ward') }}</td>
                <td>{{ __('recommendation::recommendation.created_date') }}</td>
                <td>{{ __('recommendation::recommendation.amount') }}</td>
                <td>{{ __('recommendation::recommendation.medium') }}</td>
                <td>{{ __('recommendation::recommendation.remarks') }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->records->first()->reg_no ?? 'N/A' }}</td>
                    <td>{{ $report->recommendation->recommendationCategory->title ?? 'N/A' }}</td>
                    <td>{{ $report->recommendation->title ?? 'N/A' }}</td>
                    <td>{{ $report->customer->name ?? 'N/A' }}</td>
                    <td>{{ $report->ward_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d-m-Y') }}</td>
                    <td>{{ number_format($report->recommendation->revenue, 2) ?? '0.00' }}</td>
                    <td>{{ $report->recommendation_medium ?? 'N/A' }}</td>
                    <td>{{ $report->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ __('recommendation::recommendation.epalika') }}
    </div>
</body>

</html>
