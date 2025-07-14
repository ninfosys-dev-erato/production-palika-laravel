<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('filetracking::filetracking.register_file_report') }}</title>
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

    <div class="title">{{ __('filetracking::filetracking.register_file_report') }}</div>


    <div class="date">
        {{ __('filetracking::filetracking.date') }}: {{ $nepaliDate }}
    </div>

    <div class="filters" style="display: flex; align-items: center; gap: 10px;">
        {{ __('filetracking::filetracking.applied_filters') }} :
        @if (count($filters))
            @foreach ($filters as $filter)
                <span>{{ $filter['label'] }}: {{ $filter['value'] }}</span>
            @endforeach
        @else
            <span>{{ __('filetracking::filetracking.no_filters_applied') }}</span>
        @endif
    </div>

    <table>
        <thead class="table-primary">
            <tr>
                <th>{{ __('filetracking::filetracking.sn') }}</th>
                <th>{{ __('filetracking::filetracking.reg_no') }}</th>
                <th>{{ __('filetracking::filetracking.register_date') }}</th>
                <th colspan="3" class="text-center">{{ __('filetracking::filetracking.letter_received') }}</th>
                <th>{{ __('filetracking::filetracking.file_sender') }}</th>
                <th>{{ __('filetracking::filetracking.address') }}</th>
                <th>{{ __('filetracking::filetracking.subject') }}</th>
                <th>{{ __('filetracking::filetracking.department') }}</th>
                <th>{{ __('filetracking::filetracking.fursayat_branch') }}</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ __('filetracking::filetracking.letter_no') }}</th>
                <th>{{ __('filetracking::filetracking.chno') }}</th>
                <th>{{ __('filetracking::filetracking.date') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>

            @foreach ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->reg_no }}</td>
                    <td>{{ $report->nepali_created_at }}</td>
                    <td>
                        २०८१/८२
                    </td>
                    <td>
                        N/A
                    </td>
                    <td>{{ $report->nepali_created_at }}</td>
                    <td>
                        {{ $report->sender?->name ?? 'N/A' }}
                    </td>
                    <td>{{ $report->applicant_address ?? 'N/A' }}</td>
                    <td>
                        {{ $report->title ?? 'N/A' }}
                    </td>
                    <td>{{ $report->departments()->pluck('title')->implode(', ') ?? 'N/A' }}</td>
                    <td>N/A</td>
                </tr>
            @endforeach

            {{-- @foreach ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->reg_no }}</td>
                    <td>{{ $report->nepali_created_at }}</td>
                    <td>{{ $report->applicant_name ?? 'N/A' }}</td>
                    <td>{{ $report->applicant_mobile_no ?? 'N/A' }}</td>
                    <td>{{ $report->applicant_address ?? 'N/A' }}</td>
                    <td>
                        {{ $report->sender?->name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $report->title }}
                    </td>
                    <td>{{ $report->departments()->pluck('title')->implode(', ') ?? 'N/A' }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>

    <div class="footer">
        {{ __('filetracking::filetracking.epalika') }}
    </div>
</body>

</html>
