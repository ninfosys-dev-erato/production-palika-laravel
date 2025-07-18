<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('grievance::grievance.register_file_report') }}</title>
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

    <div class="title">{{ __('grievance::grievance.grievance_report') }}</div>


    <div class="date">
        {{ __('grievance::grievance.date') }}: {{ $nepaliDate }}
    </div>

    <div class="filters" style="display: flex; align-items: center; gap: 10px;">
        {{ __('grievance::grievance.applied_filters') }} :
        @if (count($filters))
            @foreach ($filters as $filter)
                <span>{{ $filter['label'] }}: {{ $filter['value'] }}</span>
            @endforeach
        @else
            <span>{{ __('grievance::grievance.no_filters_applied') }}</span>
        @endif
    </div>

    <table>
        <thead class="table-primary">
            <tr>
                <td>{{ __('grievance::grievance.sn') }}</td>
                <td>{{ __('grievance::grievance.reg_no') }}</td>
                <td>{{ __('grievance::grievance.token') }}</td>
                <td>{{ __('grievance::grievance.grievance_type') }}</td>
                <td>{{ __('grievance::grievance.customer') }}</td>
                <td>{{ __('grievance::grievance.ward') }}</td>
                <td>{{ __('grievance::grievance.subject') }}</td>
                <td>{{ __('grievance::grievance.date') }}</td>
                <td>{{ __('grievance::grievance.suggestions') }}</td>
                <td>{{ __('grievance::grievance.medium') }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->records->first()->reg_no ?? 'N/A' }}</td>
                    <td>{{ $report->token ?? 'N/A' }}</td>
                    <td>{{ $report->grievanceType->title ?? 'N/A' }}</td>
                    <td>{{ $report->customer->name ?? 'N/A' }}</td>
                    <td>{{ $report->ward_id }}</td>
                    <td>{{ $report->subject ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $report->remarks }}</td>
                    <td>{{ $report->grievance_medium }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ __('grievance::grievance.epalika') }}
    </div>
</body>

</html>
