<!DOCTYPE html>
<html lang="ne">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Devanagari, 'Times New Roman', serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .text-center {
            text-align: center;
            margin: 5px 0;
        }

        .info-container {
            margin: 20px 0;
            overflow: hidden;
        }

        .left-info {
            float: left;
            width: 50%;
            text-align: left;
        }

        .right-info {
            float: right;
            width: 50%;
            text-align: right;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .main-table th {
            background-color: #f0f0f0;
        }

        .signature-section {
            margin-top: 40px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
            margin-top: 20px;
        }

        .signature-cell {
            width: 33.33%;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
            margin-top: 30px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>

    <h2 class="text-center">{{ $employeeMarking->anusuchi->name }}</h2>
    <p class="text-center">(दफा ४ को उपदफा (१) र (२) संग सम्बन्धित)</p>
    <p class="text-center">निर्देशन तथा परिपत्रको पालना र यथ कामकाजमा खटिने कर्मचारीलाई कार्यसम्पादनको आधारमा</p>
    <p class="text-center">प्रमुख प्रशासकीय अधिकृतले अङ्क प्रदान गर्ने फाराम</p>

    <div class="info-container clearfix">
        <div class="left-info">सालः {{ $employeeMarking->fiscal_year }}</div>
        <div class="right-info">महिनाः {{ nepaliMonthName($employeeMarking->month) }}</div>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">क्र.स.</th>
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">शाखा/कार्यालय</th>
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">कर्मचारीको नाम</th>
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">पद</th>
                @if (count($employeeMarking->anusuchi->criterion) > 0)
                    @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                        <th colspan="2">{{ $criterion->name }}</th>
                    @endforeach
                @endif
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">कुल प्राप्ताङ्क</th>
                <th rowspan="{{ count($employeeMarking->anusuchi->criterion) > 0 ? 2 : 1 }}">कैफियत</th>
            </tr>
            @if (count($employeeMarking->anusuchi->criterion) > 0)
                <tr>
                    @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                        <th>पूर्णाङ्क</th>
                        <th>प्राप्ताङ्क</th>
                    @endforeach
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach ($groupedScores as $employeeId => $scores)
                @php
                    $employee = $scores->first()->employee;
                    $totalObtained = $scores->sum('score_obtained');
                    $remarks = $scores->first()->remarks;
                @endphp
                <tr>
                    <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                    <td>{{ $employee->branch?->title }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->designation?->title }}</td>
                    @if (count($employeeMarking->anusuchi->criterion) > 0)
                        @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                            @php
                                $score = $scores->firstWhere('criteria_id', $criterion->id);
                            @endphp
                            <td>{{ $score?->score_out_of ?? '-' }}</td>
                            <td>{{ $score?->score_obtained ?? '-' }}</td>
                        @endforeach
                    @endif
                    <td>{{ $totalObtained }}</td>
                    <td>{{ $remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="signature-section">
        <div class="signature-block">
            <p>प्रमुख प्रशासकीय अधिकृतको / Signee</p>
            <p>{{ $employeeMarking->user->name }}</p>
        </div>
        <div class="signature-block">
            <p>सही:</p>
        </div>
        <div class="signature-block">
            <p>मितिः {{ $employeeMarking->date_from }}</p>
        </div>
    </div>
</body>

</html>
