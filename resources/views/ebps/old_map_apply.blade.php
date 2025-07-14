<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/frontend/css/bootstrap.min.css" />

</head>

<body>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .header-logo {
            max-height: 60px;
        }

        .page-header {
            background: linear-gradient(135deg, #14539A, #0c3b75);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
        }

        .section-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
            background: #fff;
        }

        .section-header {
            background-color: #14539A;
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .section-subheader {
            background-color: #e9ecef;
            border-left: 4px solid #14539A;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: #14539A;
        }

        .data-row {
            display: flex;
            border-bottom: 1px solid #d9e2ef;
            padding: 0.75rem 0;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            width: 35%;
            font-weight: 500;
            color: #555;
        }

        .data-value {
            width: 65%;
            font-weight: 600;
        }

        .badge-fiscal-year {
            background-color: #F1C40F;
            color: #212529;
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.3rem;
        }

        .info-box {
            background-color: rgba(20, 83, 154, 0.05);
            border-left: 4px solid #14539A;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .registration-details {
            background-color: #fff8e1;
            border-left: 4px solid #F1C40F;
            padding: 1rem;
        }

        @media print {
            .section-card {
                break-inside: avoid;
            }

            .page-header {
                background: white !important;
                color: #14539A !important;
                border-bottom: 2px solid #14539A;
            }

            .section-header {
                background-color: #f1f1f1 !important;
                color: black !important;
                border-bottom: 1px solid #ddd;
            }

            .btn-print {
                display: none;
            }
        }
    </style>


    <div class="container mb-5 p-0">
        <!-- Main info card -->
        <div class="section-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-map-marked-alt me-2"></i> नक्सा दर्ता विवरण
                </div>
                <div>
                    <span class="badge badge-fiscal-year">
                        <i class="far fa-calendar-alt me-1"></i> आ.व. {{ $mapApply->fiscalYear->year }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="info-box mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-2">
                                <div class="data-label">दर्ता आईडी:</div>
                                <div class="data-value">{{ $mapApply->submission_id }}</div>
                            </div>
                            <div class="d-flex">
                                <div class="data-label">दर्ता मिति:</div>
                                <div class="data-value">{{ $mapApply->registration_date ?? 'Not Registered Yet' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-2">
                                <div class="data-label">दर्ता नं.:</div>
                                <div class="data-value">{{ $mapApply->registration_no }}</div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Section 1: Building Description -->
                <div class="section-subheader mb-3">
                    <i class="fas fa-building me-2"></i> १. प्रस्तावित भवनको विवरण
                </div>

                <div class="px-3 mb-4">
                    <div class="data-row">
                        <div class="data-label">१.१ निर्माण कार्यको किसिम:</div>
                        <div class="data-value">{{ $mapApply->constructionType->title }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">१.२ प्रयोजन:</div>
                        <div class="data-value">
                            {{ \Src\Ebps\Enums\PurposeOfConstructionEnum::from($mapApply->usage)->label() }}
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">१.३ भवन ऐन अनुसार वर्गीकरण:</div>
                        <div class="data-value">
                            {{ \Src\Ebps\Enums\BuildingStructureEnum::from($mapApply->building_structure)->label() }}
                        </div>

                    </div>
                </div>

                <!-- Section 2: Applicant Information -->
                <div class="section-subheader mb-3">
                    <i class="fas fa-user me-2"></i> २. घर धनीको विवरण
                </div>
                <div class="px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="data-row">
                                <div class="data-label">२.१ घर धनीको नाम:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->owner_name ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">२.२ फोन नं.:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->mobile_no ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">२.३ बुवाको नाम:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->father_name ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">२.४ हजुरबुवाको नाम:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->grandfather_name ?? 'Not Provided' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-row">
                                <div class="data-label">२.५ नागरिकता नम्बर:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->citizenship_no ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">२.६ नागरिकता लिएको मिति:</div>
                                <div class="data-value">
                                    {{ $mapApply->houseOwner->citizenship_issued_date ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">२.७ नागरिकता लिएको जिल्ला:</div>
                                <div class="data-value">
                                    {{ $mapApply->houseOwner->citizenship_issued_at ?? 'Not Provided' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="section-subheader mt-4 mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i> ठेगाना
                    </div>
                    <div class="col-md-6">
                        <div class="data-row">
                            <div class="data-label">प्रदेश:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->province->title ?? 'Not Provided' }}
                            </div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">जिल्ला:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->district->title ?? 'Not Provided' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="data-row">
                            <div class="data-label">पालिका:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->localBody->title ?? 'Not Provided' }}
                            </div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">वडा नं.:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->ward_no ?? 'Not Provided' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>