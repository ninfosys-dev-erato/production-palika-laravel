<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <title>Project Cost Estimation</title> --}}
    <style>
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

        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        /* th {
            background-color: #f2f2f2;
        } */

        .no-border {
            border: none !important;
        }

        .bold {
            font-weight: bold;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table td {
            width: 33%;
            vertical-align: top;
            padding: 10px;
            border: none;
            text-align: left;
            /* Make content stick to left */
        }

        .signature-table p {
            margin: 5px 0;
        }

        figure.table,
        figure.table table,
        figure.table td,
        figure.table th {
            border: none !important;
            border-collapse: collapse;
        }

        @media print {
            body {
                margin: 0;
            }

            .signature-table {
                page-break-inside: avoid;
            }
        }


        /* Ensure A4 Size */
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 7mm 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }

    </style>
</head>

<body>

    <div class="main-container">
        <!-- <table class="main-table">
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
        </table> -->
        {!! $header !!}
   

    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr style="border: none;">
            <td style="width: 70%; text-align: left; vertical-align: top; border: none;">
                <p>कार्यालय वा परियोजनाको नामः {{ $plan->project_name }}</p>
                <p>कार्यक्रम/योजनाको नाम: {{ $plan->project_name }}</p>
                <p>कार्यान्वयन हुने स्थलः {{ $plan->location }}</p>
                <p>सम्पन्न हुने अनुमानित अवधिः ........................................</p>
            </td>
            <td style="width: 30%; text-align: right; vertical-align: top; border: none;">
                <p><strong>आर्थिक वर्ष:</strong> {{ getSetting('fiscal-year') }}<br>
                    <strong>बजेट उप शीर्षक नः</strong>
                </p>
            </td>
        </tr>
    </table>


    @php
        $totalAmount = 0;
        $totalAmountWithoutVat = 0;
    @endphp
    <table>

        <thead>
            <tr>
                <th>सि.न.</th>
                <th>काम/सेवाको विवरण (आइटम)</th>
                <th>एकाइ</th>
                <th>दर</th>
                <th>परिमाण</th>
                <th>जम्मा लगत</th>
                <th>अनुमानित दरको स्रोत</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($costEstimation?->costEstimationDetail as $record)
                @php
                    $amount = (float) $record->amount;
                    $vat = (float) $record->vat_amount;
                    $totalAmount += $amount;
                    $totalAmountWithoutVat += $amount - $vat;
                @endphp
                <tr>
                    <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                    <td>
                        {{ replaceNumbers($record->activity?->title, true) }}
                    </td>

                    <td>
                        {{ replaceNumbers($record->unitRelation->symbol, true) }}
                    </td>
                    <td>
                        रु {{ replaceNumbers($record->rate, true) }}
                    </td>
                    <td>
                        {{ replaceNumbers($record->quantity, true) }}
                    </td>
                    
                    <td>
                        रु {{ replaceNumbers($record->amount, true) }}
                    </td>
                    <td>
                        रु {{ replaceNumbers($record->vat_amount, true) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="no-border bold" style="text-align:right">खुद लागत अनुमान</td>
                <td colspan="2" class="bold">रु {{ replaceNumbers($totalAmount, true) }}</td>
            </tr>
            <tr>
                <td colspan="5" class="no-border" style="text-align:right">कन्टेन्जेन्सी +(पुर्वधार)</td>
                <td colspan="2">रु {{ replaceNumbers($totalConfig, true) }}</td>
            </tr>
            <tr>
                <td colspan="5" class="no-border" style="text-align:right">जम्मा रकम</td>
                <td colspan="2">रु {{ replaceNumbers(($totalAmount + $totalConfig), true) }}</td>
            </tr>
            <tr>
                <td colspan="5" class="no-border bold" style="text-align:right">लगभग</td>
                <td colspan="2" class="bold">रु {{ replaceNumbers($totalAmountWithoutVat, true) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td>
                <p><strong>तयार गर्नेः</strong></p>
                <p>हस्ताक्षरः</p>
                <p>नामः</p>
                <p>पदः</p>
                <p>मितिः {{ $nepaliDate }}</p>
            </td>
            <td>
                <p><strong>जाँच गर्नेः</strong></p>
                <p>हस्ताक्षरः</p>
                <p>नामः</p>
                <p>पदः</p>
                <p>मितिः {{ $nepaliDate }}</p>
            </td>
            <td>
                <p><strong>स्वीकृत गर्नेः</strong></p>
                <p>हस्ताक्षरः</p>
                <p>नामः</p>
                <p>पदः</p>
                <p>मितिः {{ $nepaliDate }}</p>
            </td>
        </tr>
    </table>
</div>


</body>

</html>
