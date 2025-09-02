<!DOCTYPE html>
<html lang="ne">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Application Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;

            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
            border-bottom: 3px solid #34495e;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }


        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }

        .card-header h5 {
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 10px;
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .form-control-plaintext {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 12px;
            font-weight: 500;
            color: #333;
            min-height: 40px;
            display: flex;
            align-items: center;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control-plaintext:hover {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
        }

        .form-control-plaintext:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table th {
            background: #f8f9fa;
            color: #2c3e50;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #ddd;
            font-size: 0.85rem;
        }

        .table td {
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e8f4fd;
        }


        .declaration-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .declaration-box h6 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .declaration-box p {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
            text-align: justify;
        }

        .signature-line {
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 12px;
            color: #666;
            font-weight: 500;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-dark {
            color: #333;
        }

        .fw-bold {
            font-weight: 700;
        }

        .fw-medium {
            font-weight: 500;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .border {
            border: 1px solid #ddd;
        }

        .rounded {
            border-radius: 4px;
        }

        .p-3 {
            padding: 1rem;
        }

        .align-middle {
            vertical-align: middle;
        }

        .btn {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            text-align: center;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .content {
                padding: 20px;
            }

            .card-body {
                padding: 15px;
            }

            .table-responsive {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.3rem;
            }

            .content {
                padding: 15px;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
            }

            .card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #000;
            }

            .header {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>नक्सा आवेदन विवरण</h1>
            <button class="btn btn-primary" onclick="printDiv()">Print</button>
        </div>

        <div class="content" id="printContent">
            <!-- Detail filled by consultancy Section -->
            <div class="card">
                <div class="card-header">
                    <h5>कन्सल्टेन्सी द्वारा भरिएको विवरण</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">1. जग्गाधनीको नाम, जात:</label>
                            <div class="form-control-plaintext fw-bold">
                                {{ $mapApplyDetail->mapApply?->full_name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">2. घरधनीको नाम, जात:</label>
                            <div class="form-control-plaintext fw-bold">
                                {{ $mapApplyDetail->mapApply?->full_name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">3. भू-उपयोग क्षेत्र</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->landUseArea->title ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">4. निर्माणको प्रयोजन</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->construction_purpose_id ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">5. भू-उपयोगमा परिवर्तन (विवरण)</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->land_use_area_changes ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">5.1 उपयोगमा परिवर्तन (विवरण)</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->usage_changes ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">6. प्रस्तावित निर्माण वा उपयोगमा परिवर्तनको लागि मापदण्ड बमोजिम
                                स्वीकृतिको किसिम</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->change_acceptance_type ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">7. निर्माणको लागि प्रस्तावित जग्गाको कित्ता नं.</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->mapApply?->landDetail?->lot_no ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">8. जग्गाधनी प्रमाण पुर्जा अनुसारको जग्गाको वास्तविक क्षेत्रफल
                                (sqm)</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->mapApply?->landDetail?->area_sqm ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">9. फिल्ड नाप अनुसारको जग्गाको वास्तविक क्षेत्रफल (sqm)</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->field_measurement_area ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">10. प्रस्तावित भवनको प्लिन्थको क्षेत्रफल (sqm)</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->building_plinth_area ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Construction Details Section -->
            <div class="card">
                <div class="card-header">
                    <h5>11. उद्देश्य वा पूर्व भवन/निर्माण तला र क्षेत्र विवरण</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>तल्ला</th>
                                    <th>उद्देश्य निर्माण क्षेत्र</th>
                                    <th>पूर्व निर्माण क्षेत्र</th>
                                    <th>कुल क्षेत्रफल</th>
                                    <th>उचाई</th>
                                    <th>कैफियत</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($constructionStoreyPurpose) && is_array($constructionStoreyPurpose) && count($constructionStoreyPurpose) > 0)
                                    @foreach ($constructionStoreyPurpose as $index => $purpose)
                                        @if (is_array($purpose))
                                            <tr>
                                                <td>{{ $purpose['storey_id'] ?? '-' }}</td>
                                                <td>{{ replaceNumbers($purpose['purposed_area'] ?? '-', true) }}</td>
                                                <td>{{ replaceNumbers($purpose['former_area'] ?? '-', true) }}</td>
                                                <td>
                                                    @php
                                                        $purposedArea = $purpose['purposed_area'] ?? 0;
                                                        $formerArea = $purpose['former_area'] ?? 0;
                                                        $totalArea =
                                                            $purpose['total_area'] ?? $purposedArea + $formerArea;
                                                    @endphp
                                                    {{ replaceNumbers($totalArea, true) }}
                                                </td>
                                                <td>{{ replaceNumbers($purpose['height'] ?? '-', true) }}</td>
                                                <td>{{ $purpose['remarks'] ?? '-' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No data') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Other Construction Details -->
            <div class="card">
                <div class="card-header">
                    <h5>अन्य निर्माण विवरणहरू</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">12. प्रस्तावित अन्य निर्माणले ढाक्ने क्षेत्रफल</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->other_construction_area ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">13. साविक अन्य निर्माणले काटिसकेको</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->former_other_construction_area ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">14. निर्माणको किसिम</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->buildingConstructionType->title ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">15. भवनको गाह्रोमा प्रयोग सामाग्री</label>
                            <div class="form-control-plaintext">{{ $mapApplyDetail->material_used ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">16. भवनको छानाको किसिम</label>
                            <div class="form-control-plaintext">
                                {{ $mapApplyDetail->buildingRoofType->title ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distance From Road Section -->
            @php
                $directions = [
                    'front' => 'अगाडि',
                    'right' => 'दायाँ',
                    'left' => 'बायाँ',
                    'back' => 'पछाडि',
                ];
            @endphp

            <div class="card">
                <div class="card-header">
                    <h5>17. सडकदेखि प्रस्तावित भवनसम्मको दूरी</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th rowspan="2">जग्गाको</th>
                                    <th rowspan="2">सडकको चौडाइ</th>
                                    <th colspan="2">घरदेखि सडकको केन्द्रसम्मको दूरी</th>
                                    <th colspan="2">घरदेखि सडकको छेउसम्मको दूरी</th>
                                    <th colspan="2">घरदेखि बाटोको दायाँपट्टिको दूरी</th>
                                    <th colspan="2">फिर्ता सेट गर्नुहोस्</th>
                                </tr>
                                <tr>
                                    <th>छोडिएको</th>
                                    <th>बायाँ तिर न्यूनतम दूरी</th>
                                    <th>छोडिएको</th>
                                    <th>बायाँ तिर न्यूनतम दूरी</th>
                                    <th>छोडिएको</th>
                                    <th>बायाँ तिर न्यूनतम दूरी</th>
                                    <th>छोडिएको</th>
                                    <th>बायाँ तिर न्यूनतम दूरी</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($roads) && is_array($roads))
                                    @foreach ($directions as $key => $label)
                                        @php
                                            $row = isset($roads[$key]) && is_array($roads[$key]) ? $roads[$key] : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>{{ $row && isset($row['width']) ? replaceNumbers($row['width'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['dist_from_middle']) ? replaceNumbers($row['dist_from_middle'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['min_dist_from_middle']) ? replaceNumbers($row['min_dist_from_middle'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['dist_from_side']) ? replaceNumbers($row['dist_from_side'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['min_dist_from_side']) ? replaceNumbers($row['min_dist_from_side'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['dist_from_right']) ? replaceNumbers($row['dist_from_right'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['min_dist_from_right']) ? replaceNumbers($row['min_dist_from_right'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['setback']) ? replaceNumbers($row['setback'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['min_setback']) ? replaceNumbers($row['min_setback'], true) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">{{ __('No data') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Distance From Outer Wall Section -->
            @php
                $wallDirections = [
                    'east' => 'पूर्व',
                    'west' => 'पश्चिम',
                    'north' => 'उत्तर',
                    'south' => 'दक्षिण',
                ];
            @endphp

            <div class="card">
                <div class="card-header">
                    <h5>18. बाहिरी पर्खालदेखि सिमानासम्मको दूरी</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>दिशा</th>
                                    <th>सडक छ</th>
                                    <th>ढोका/झ्यालहरू छन्</th>
                                    <th>बायाँ तिर न्यूनतम दूरी</th>
                                    <th>छोडिएको</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($distanceToWall) && is_array($distanceToWall))
                                    @foreach ($wallDirections as $key => $label)
                                        @php
                                            $row =
                                                isset($distanceToWall[$key]) && is_array($distanceToWall[$key])
                                                    ? $distanceToWall[$key]
                                                    : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>
                                                @if ($row && isset($row['has_road']))
                                                    {{ $row['has_road'] ? __('छ') : __('छैन') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row && isset($row['does_have_wall_door']))
                                                    {{ $row['does_have_wall_door'] ? __('छ') : __('छैन') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $row && isset($row['min_dist_left']) ? replaceNumbers($row['min_dist_left'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['dist_left']) ? replaceNumbers($row['dist_left'], true) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No data') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cantilever Distance Section -->
            @php
                $cantileverDirections = [
                    'front' => 'अगाडि',
                    'right' => 'दायाँ',
                    'left' => 'बायाँ',
                    'back' => 'पछाडि',
                ];
            @endphp

            <div class="card">
                <div class="card-header">
                    <h5>20. Cantilever दूरी</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>दिशा</th>
                                    <th>उद्देश्य दूरी</th>
                                    <th>स्वीकृत गर्न सकिने न्यूनतम दूरी</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($cantileverDetails) && is_array($cantileverDetails))
                                    @foreach ($cantileverDirections as $key => $label)
                                        @php
                                            $row =
                                                isset($cantileverDetails[$key]) && is_array($cantileverDetails[$key])
                                                    ? $cantileverDetails[$key]
                                                    : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>{{ $row && isset($row['distance']) ? replaceNumbers($row['distance'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['minimum']) ? replaceNumbers($row['minimum'], true) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('No data') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- High Tension Line Detail -->
            @php
                $tensionDirections = [
                    'front' => 'अगाडि',
                    'right' => 'दायाँ',
                    'left' => 'बायाँ',
                    'back' => 'पछाडि',
                ];
            @endphp

            <div class="card">
                <div class="card-header">
                    <h5>21. उच्च तनाव रेखा विवरण</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>दिशा</th>
                                    <th>उद्देश्य दूरी</th>
                                    <th>स्वीकृत गर्न सकिने न्यूनतम दूरी</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($highTensionDetails) && is_array($highTensionDetails))
                                    @foreach ($tensionDirections as $key => $label)
                                        @php
                                            $row =
                                                isset($highTensionDetails[$key]) && is_array($highTensionDetails[$key])
                                                    ? $highTensionDetails[$key]
                                                    : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>{{ $row && isset($row['distance']) ? replaceNumbers($row['distance'], true) : '-' }}
                                            </td>
                                            <td>{{ $row && isset($row['minimum']) ? replaceNumbers($row['minimum'], true) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('No data') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Declaration Section -->
            <div class="card declaration-section">
                <div class="card-header">
                    <h5>घोषणा</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="declaration-box">
                                <h6>नक्सा बनाउनेको तर्फबाट</h6>
                                <p>मैले नक्सा बनाउने प्राविधिकले गर्नुपर्ने कुराहरुको अध्ययन गर्न दरखास्तवाला श्री
                                    {{ $mapApplyDetail->mapApply?->full_name ?? '-' }} को नक्सा बनाएको हुँ । उक्त नक्सा
                                    तोकिएको मापदण्ड विपरित बनाइएको ठहरे
                                    नियमानुसार सहुँला बुझाउँला ।</p>
                                <div class="signature-line">सही : ..............................</div>
                                <div class="signature-line">नाम, थर : .................................</div>
                                <div class="signature-line">योग्यता एवं पद : .................................</div>
                                <div class="signature-line">कन्सल्टीङ फर्मको नाम : .................................
                                </div>
                                <div class="signature-line">उप-महान.पा.मा दर्ता भएका व्यवसाय प्रमाण-पत्रको नं.
                                    .................................</div>
                                <div class="signature-line">फर्मको छाप : .................................</div>
                                <div class="signature-line">मिति :
                                    {{ replaceNumbers(ne_date(date('Y-m-d'), 'MM dd yyyy | l'), toNepali: true) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="declaration-box">
                                <h6>नक्सा पास एवं निर्माण इजाजतको लागि दरखास्त गर्नेको तर्फबाट</h6>
                                <p>नक्सा पास एवं निर्माण इजाजतको लागि दरखास्त गर्नेको तर्फबाट माथि उल्लिखित प्राविधिक
                                    विवरण एवं उप-महानगरपालिकाको मापदण्ड बमोजिम नक्सा अनुसार निर्माण कार्य गर्न म/ हामी
                                    मञ्जुर छु/छौँ । मापदण्ड विपरित र ठीक विपरित गर्दा कानुन बमोजिम सहुँला बुझाउँला।</p>
                                <div class="signature-line">सही : .................................</div>
                                <div class="signature-line">नाम, थर :
                                    {{ $mapApplyDetail->mapApply?->full_name ?? '-' }}</div>
                                <div class="signature-line">मिति :
                                    {{ replaceNumbers(ne_date(date('Y-m-d'), 'MM dd yyyy | l'), toNepali: true) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('printContent');

            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;

            let heightLeft = imgHeight;
            let position = 0;

            // Add first page
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Add more pages only if needed
            while (heightLeft > 1) {
                position -= pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
                heightLeft -= pdfHeight;
            }

            // Trigger browser print dialog
            pdf.autoPrint();
            window.open(pdf.output('bloburl'), '_blank');
            console.log('printed');
        }
    </script>
</body>

</html>
