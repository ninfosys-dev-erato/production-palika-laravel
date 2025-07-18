<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title xlass="text-center">{{ __('Recommendation Report') }}</title>
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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .filters {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .filters p {
            margin: 2px 0;
        }

        .title {
            font-size: 20px;
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
    </style>
</head>

<body>

    <div class="header">
        {!! $letterHead !!}
        <div class="title">{{ __('Grievance Report') }}</div>
    </div>

    <div class="date">
        {{ __('Date') }}: {{ $nepaliDate }}
    </div>

    <div class="filters" style="display: flex; align-items: center; gap: 10px;">
        {{ __('Applied Filters') }} :
        @if (count($filters))
            @foreach ($filters as $filter)
                <span>{{ $filter['label'] }}: {{ $filter['value'] }}</span>
            @endforeach
        @else
            <span>{{ __('No filters applied.') }}</span>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <td>{{ __('S.N') }}</td>
                <td>{{ __('Reg No') }}</td>
                <td>{{ __('Token') }}</td>
                <td>{{ __('Grievance Type') }}</td>
                <td>{{ __('Customer') }}</td>
                <td>{{ __('Ward') }}</td>
                <td>{{ __('Subject') }}</td>
                <td>{{ __('Created Date') }}</td>
                <td>{{ __('Suggestions') }}</td>
                <td>{{ __('Medium') }}</td>
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
        {{ __('E-Palika') }}
    </div>
</body>

</html>
