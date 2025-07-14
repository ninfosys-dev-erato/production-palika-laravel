<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration </title>

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

        <div class="section-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-map-marked-alt me-2"></i> {{ __('ebps::ebps.building_registration_details') }}
                </div>
                <div>
                    <span class="badge badge-fiscal-year">
                        <i class="far fa-calendar-alt me-1"></i> आ.व. {{ $mapApply->fiscalYear->year }}
                    </span>
                </div>
            </div>

            <!-- <strong>{{ $mapApply->submission_id }}</strong> -->

            <div class="card-body">
                <!-- Building Details Section -->
                <div class="mb-4">

                    <!-- section 1 -->
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> १. प्रस्तावित भवनको विवरण
                    </div>

                    <div class="px-3 mb-4">
                        <div class="row mb-2">

                            <div class="data-row">
                                <div class="data-label">१.१ निर्माण भइसकेको किसिम :</div>
                                <div class="data-value">
                                    {{ $mapApply->buildingConstructionType->title ?? 'Not Provided' }}
                                </div>
                            </div>

                            <div class="data-row">
                                <div class="data-label">१.२ प्रयोग :</div>
                                <div class="data-value">आवासीय</div>
                            </div>
                        </div>


                        <div class="data-row">
                            <div class="data-label">१.३ भवनको ढलानको किसिम :</div>
                            <div class="data-value">{{ $mapApply->buildingRoofType->title ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.४ भवन निर्माण भएको साल :</div>
                            <div class="data-value">{{ $mapApply->year_of_house_built ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.५ भवनको तल्ला संख्या :</div>
                            <div class="data-value">{{ $mapApply->storey_no ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.६ भवनको कोठा संख्या :</div>
                            <div class="data-value">{{ $mapApply->no_of_rooms ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.७ भवनको जम्मा क्षेत्रफल :</div>
                            <div class="data-value">{{ $mapApply->area_of_building_plinth ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.८ अन्य निर्माण (भवन बाहेक जस्तै: कम्पाउणडवाल, टहरा)ले ढाकेको
                                क्षेत्रफल (वर्ग फिट/वर्ग मिटर) :</div>
                            <div class="data-value">{{ $mapApply->detail->other_construction_area ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.९ भवनको कुल उचाई जमिनको सतहबाट (मिटर/फिट) :</div>
                            <div class="data-value">{{ $mapApply->former_other_construction_area ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">१.१० भवन निर्माण र साबिक भवन निर्माणले ढाक्ने जम्मा क्षेत्रफल
                                (Ground Coverage) (वर्ग फिट/वर्ग मिटर) :</div>
                            <div class="data-value">{{ $mapApply->former_other_construction_area ?? 'Not Provided' }}
                            </div>
                        </div>
                    </div>


                    <!-- section 1.11 -->
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> १.११ भवन/निर्माण तला अनुसार क्षेत्रफल सम्बन्धि विवरण:
                    </div>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">क्र.स</th>
                                    <th class="text-dark">तल्ला</th>
                                    <th class="text-dark">निर्माणको क्षेत्रफल फिट/मिटर</th>
                                    <th class="text-dark">निर्माण भइसकेको जम्मा क्षेत्रफल वर्ग/फिट/मिटर</th>
                                    <th class="text-dark">उचाई</th>
                                    <th class="text-dark">कैफियत</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($mapApply->storeyDetails)
                                    @foreach ($mapApply->storeyDetails as $index => $detail)
                                        <tr>
                                            <td class="text-dark">{{ $index + 1 }}</td>
                                            <td class="text-dark">{{ $detail->storey->title }}</td>
                                            <td class="text-dark">{{ $detail->purposed_area }}</td>
                                            <td class="text-dark">{{ $detail->former_area }}</td>
                                            <td class="text-dark">{{ $detail->height }}</td>
                                            <td class="text-dark">{{ $detail->remarks }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Land Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> २. जग्गाको विवरण:
                    </div>

                    <div class="px-3 mb-4">

                        <div class="data-row">
                            <div class="data-label">२.१ कित्ता नं:</div>
                            <div class="data-value">{{ $mapApply->landDetail->area_sqm ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">२.२ सिट नं:</div>
                            <div class="data-value">{{ $mapApply->landDetail->seat_no ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">२.३ निर्माण भएको साल:</div>
                            <div class="data-value">{{ $mapApply->year_of_house_built ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">२.४ कित्ताको साबिक गा.वि.स:</div>
                            <div class="data-value">{{ $mapApply->landDetail->localBody->name ?? 'Not Provided' }}</div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">२.५ टोल:</div>
                            <div class="data-value">{{ $mapApply->landDetail->tole ?? 'Not Provided' }}</div>
                        </div>

                    </div>



                    <!-- char kila bibaran -->
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> चार किल्ला विवरण
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">क्र.स</th>
                                    <th class="text-dark">शीर्षक</th>
                                    <th class="text-dark">दिशा</th>
                                    <th class="text-dark">दुरी</th>
                                    <th class="text-dark">कित्ता नम्बर</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($mapApply->landDetail->fourBoundaries)
                                    @foreach ($mapApply->landDetail->fourBoundaries as $index => $detail)
                                        <tr>
                                            <td class="text-dark">{{ $index + 1 }}</td>
                                            <td class="text-dark">{{ $detail->title }}</td>
                                            <td class="text-dark">{{ $detail->direction }}</td>
                                            <td class="text-dark">{{ $detail->distance }}</td>
                                            <td class="text-dark">{{ $detail->lot_no }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Land Owner Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ३. जग्गा धनी विवरण
                    </div>

                    <div class="px-3 mb-4">
                        @if(isset($mapApply) && $mapApply->landOwner)
                            <div class="data-row">
                                <div class="data-label">३.१ नाम:</div>
                                <div class="data-value">{{ $mapApply->landOwner->owner_name ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.२ फोन नं:</div>
                                <div class="data-value">{{ $mapApply->landOwner->mobile_no ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.३ नागरिकता नं:</div>
                                <div class="data-value">{{ $mapApply->landOwner->citizenship_no ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.५ जारी मिति:</div>
                                <div class="data-value">
                                    {{ $mapApply->landOwner->citizenship_issued_date ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.६ जारी जिल्ला:</div>
                                <div class="data-value">{{ $mapApply->landOwner->citizenship_issued_at ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.७ प्रदेश:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->landOwner->province) ? $mapApply->landOwner->province->title : 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.८ पालिका:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->landOwner->localBody) ? $mapApply->landOwner->localBody->title : 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.९ टोल:</div>
                                <div class="data-value">{{ $mapApply->landOwner->tole ?? '-' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.१० फोटो:</div>
                                <div class="data-value">
                                    @if(isset($mapApply->landOwner->photo) && $mapApply->landOwner->photo)
                                        @php
                                            $photoPath = public_path('storage/' . $mapApply->landOwner->photo);
                                        @endphp
                                        @if(file_exists($photoPath))
                                            <img src="{{ asset('storage/' . $mapApply->landOwner->photo) }}" alt="Land Owner Photo"
                                                class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            <span class="text-muted">Photo not available</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No photo uploaded</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>जग्गा धनी विवरण उपलब्ध छैन।</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- House Owner Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ३. घर धनी विवरण
                    </div>
                    <div class="px-3 mb-4">
                        @if(isset($mapApply) && $mapApply->houseOwner)
                            <div class="data-row">
                                <div class="data-label">३.१ नाम:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->owner_name ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.२ फोन नं:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->mobile_no ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.३ नागरिकता नं:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->citizenship_no ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.५ जारी मिति:</div>
                                <div class="data-value">
                                    {{ $mapApply->houseOwner->citizenship_issued_date ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.६ जारी जिल्ला:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->citizenship_issued_at ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.७ प्रदेश:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->houseOwner->province) ? $mapApply->houseOwner->province->title : 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.८ पालिका:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->houseOwner->localBody) ? $mapApply->houseOwner->localBody->title : 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.९ टोल:</div>
                                <div class="data-value">{{ $mapApply->houseOwner->tole ?? '-' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">३.१० फोटो:</div>
                                <div class="data-value">
                                    @if(isset($mapApply->houseOwner->photo) && $mapApply->houseOwner->photo)
                                        @php
                                            $photoPath = public_path('storage/' . $mapApply->houseOwner->photo);
                                        @endphp
                                        @if(file_exists($photoPath))
                                            <img src="{{ asset('storage/' . $mapApply->houseOwner->photo) }}"
                                                alt="House Owner Photo" class="img-thumbnail"
                                                style="max-width: 100px; max-height: 100px;">
                                        @else
                                            <span class="text-muted">Photo not available</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No photo uploaded</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>घर धनी विवरण उपलब्ध छैन।</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Applicant Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ४. निवेदकको विवरण
                    </div>
                    <div class="px-3 mb-4">
                        @if(isset($mapApply))
                            <div class="data-row">
                                <div class="data-label">४.१ निवेदकको प्रकार:</div>
                                <div class="data-value">{{ $mapApply->applicant_type ?? 'Not Specified' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">४.२ नाम:</div>
                                <div class="data-value">{{ $mapApply->full_name ?? 'Not Provided' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">४.३ फोन नं:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->buildingDetail) ? ($mapApply->buildingDetail->mobile_no ?? 'Not Provided') : 'Not Provided' }}
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">४.४ उमेर:</div>
                                <div class="data-value">{{ $mapApply->age ?? '-' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="data-label">४.५ निर्माण मिति:</div>
                                <div class="data-value">
                                    {{ isset($mapApply->buildingDetail) ? ($mapApply->buildingDetail->build_date ?? 'Not Provided') : 'Not Provided' }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>निवेदकको विवरण उपलब्ध छैन।</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Four Boundaries Details Table -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ५. चार किल्ला विवरण
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-dark">क्र.सं.</th>
                                    <th class="text-dark">दिशा</th>
                                    <th class="text-dark">रखिएको चिन्ह</th>
                                    <th class="text-dark">लम्बाई</th>
                                    <th class="text-dark">चौडाई</th>
                                    <th class="text-dark">कैफियत</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($mapApply) && isset($mapApply->boundaries) && $mapApply->boundaries->count() > 0)
                                    @foreach ($mapApply->boundaries as $index => $boundary)
                                        <tr>
                                            <td class="text-dark">{{ $index + 1 }}</td>
                                            <td class="text-dark">{{ $boundary->direction ?? '-' }}</td>
                                            <td class="text-dark">{{ $boundary->mark ?? '-' }}</td>
                                            <td class="text-dark">{{ $boundary->length ?? '-' }}</td>
                                            <td class="text-dark">{{ $boundary->width ?? '-' }}</td>
                                            <td class="text-dark">{{ $boundary->remarks ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            चार किल्ला विवरण उपलब्ध छैन।
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Certification Section -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border p-4 bg-light">
                                <h5 class="fw-bold mb-4 text-dark">प्रमाणित गर्ने:</h5>

                                <p class="mb-2 text-dark">नाम:
                                    <span class="fw-medium">{{ $officerName ?? 'प्रकाश शर्मा' }}</span>
                                </p>
                                <p class="mb-2 text-dark">पद:
                                    <span class="fw-medium">{{ $officerPost ?? 'ईन्जिनियर' }}</span>
                                </p>
                                <div class="mt-4">
                                    <p class="mb-1 text-dark">सही:</p>
                                    <div class="border-bottom border-dark" style="width: 200px; height: 40px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>