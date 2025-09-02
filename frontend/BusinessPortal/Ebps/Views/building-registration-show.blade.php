<x-layout.business-app header="Business Registration">
    <style>
        :root {
            --primary-color: #14539A;
            --secondary-color: #E04622;
            --accent-color: #F1C40F;
            --light-bg: #fff;
            --border-color: #d9e2ef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .header-logo {
            max-height: 60px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #0c3b75);
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
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0.5rem 0.5rem 0 0;
            /* margin-bottom: 1.5rem; */
        }

        .section-subheader {
            background-color: #e9ecef;
            border-left: 4px solid var(--primary-color);
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .data-row {
            display: flex;
            border-bottom: 1px solid var(--border-color);
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
            background-color: var(--accent-color);
            color: #212529;
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.3rem;
        }

        .info-box {
            background-color: rgba(20, 83, 154, 0.05);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .registration-details {
            background-color: #fff8e1;
            border-left: 4px solid var(--accent-color);
            padding: 1rem;
        }


        @media print {
            .section-card {
                break-inside: avoid;
            }

            .page-header {
                background: white !important;
                color: var(--primary-color) !important;
                border-bottom: 2px solid var(--primary-color);
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

    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>

        {{-- <button onclick="downloadPdf({{ $mapApply->id }})" class="btn btn-outline-primary">
            <i class="bx bx-printer"></i> Download PDF
        </button> --}}
    </div>

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
                            <div class="data-value">{{ $mapApply->landDetail->localBody->name ?? 'Not Provided' }}
                            </div>
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
                                @if ($mapApply?->landDetail?->fourBoundaries)
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
                            <div class="data-value">
                                {{ $mapApply->landOwner->citizenship_issued_at ?? 'Not Provided' }}
                            </div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">३.७ प्रदेश:</div>
                            <div class="data-value">{{ $mapApply->landOwner->province->title ?? 'Not Provided' }}
                            </div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">३.८ पालिका:</div>
                            <div class="data-value">{{ $mapApply->landOwner->localBody->title ?? 'Not Provided' }}
                            </div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">३.९ टोल:</div>
                            <div class="data-value">{{ $mapApply->landOwner->tole ?? '-' }}</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">३.१० फोटो:</div>
                            <div class="data-value">
                                <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $mapApply->landOwner->photo, 'local', 'tempUrl') }}"
                                    target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- House Owner Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ३. घर धनी विवरण
                    </div>
                    <div class="px-3 mb-4">
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
                            <div class="data-value">{{ $mapApply->houseOwner->citizenship_no ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">३.५ जारी मिति:</div>
                            <div class="data-value">
                                {{ $mapApply->houseOwner->citizenship_issued_date ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">३.६ जारी जिल्ला:</div>
                            <div class="data-value">
                                {{ $mapApply->houseOwner->citizenship_issued_at ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">३.७ प्रदेश:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->province->title ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">३.८ पालिका:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->localBody->title ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">३.९ टोल:</div>
                            <div class="data-value">{{ $mapApply->houseOwner->tole ?? '-' }}</div>

                        </div>

                        <div class="data-row">
                            <div class="data-label">३.१० फोटो:</div>
                            <div class="data-value">


                                <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $mapApply->houseOwner->photo, 'local', 'tempUrl') }}"
                                    target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>


                            </div>
                        </div>
                    </div>

                </div>

                <!-- Applicant Details Section -->
                <div class="mb-4">
                    <div class="section-subheader mb-3">
                        <i class="fas fa-building me-2"></i> ४. निवेदकको विवरण
                    </div>
                    <div class="px-3 mb-4">


                        <div class="data-row">
                            <div class="data-label">४.१ निवेदकको प्रकार:</div>
                            <div class="data-value">{{ $mapApply->applicant_type }}</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">४.२ नाम:</div>
                            <div class="data-value">{{ $mapApply->full_name }}</div>
                        </div>
                        <div class="data-row">
                            <div class="data-label">४.३ फोन नं:</div>
                            <div class="data-value">{{ $mapApply->buildingDetail->mobile_no ?? '१२३' }}</div>
                        </div>

                        {{-- <div class="data-row">
                            <strong class="data-label">४.४ उमेर:</strong>
                            <span class="data-value">{{ $mapApply->age ?? '-' }}</span>
                        </div> --}}
                        <div class="data-row">

                            <div class="data-label">४.४ निर्माण मिति:</div>
                            <div class="data-value">{{ $mapApply->buildingDetail->build_date ?? '२०८१-०१-२५' }}
                            </div>
                        </div>
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
                                @php $boundary = $mapApply->boundaries ?? []; @endphp
                                @foreach ($boundary as $index => $b)
                                    <tr>
                                        <td class="text-dark">{{ $index + 1 }}</td>
                                        <td class="text-dark">{{ $b->direction }}</td>
                                        <td class="text-dark">{{ $b->mark }}</td>
                                        <td class="text-dark">{{ $b->length }}</td>
                                        <td class="text-dark">{{ $b->width }}</td>
                                        <td class="text-dark">{{ $b->remarks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="section-subheader">
                    <i class="fas fa-user me-2"></i> {{ __('संस्था/परामर्शदाताहरु') }}
                </div>
                <div>
                    <div class="data-row">
                        <div class="data-label">{{ __('परामर्शदाता') }}:</div>
                        <div class="data-value">{{ $organization->org_name_ne ?? 'N/A' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('इमेल') }}:</div>
                        <div class="data-value">{{ $organization->org_email ?? 'N/A' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('फोन नम्बर') }}:</div>
                        <div class="data-value">{{ $organization->org_contact ?? 'N/A' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ठेगाना') }}:</div>
                        <div class="data-value">
                            {{ $organization->localBody->title . ', ' . $organization->district->title ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="section-subheader mt-4">
                    <i class="fas fa-signature me-2"></i> {{ __('ebps::ebps.other_documents') }}
                </div>

                <div class="row">
                    @forelse ($documents as $document)
                        @php
                            $fileUrl = customFileAsset(
                                config('src.Ebps.ebps.path'),
                                $document->file,
                                'local',
                                'tempUrl',
                            );
                        @endphp

                        <div class="col-md-4 mb-3 text-center">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="text-truncate" title="{{ $document->title }}">{{ $document->title }}
                                    </h6>
                                    <a href="{{ $fileUrl }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted fst-italic">
                            <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                            {{ __('ebps::ebps.no_documents_uploaded') }}.
                        </div>
                    @endforelse

                    <!-- Add Document Uploader -->
                    <livewire:ebps.map_apply_document_uploader :mapApplyId="$mapApply->id" />
                </div>


                <!-- Certification Section -->
                <!-- <div class="mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border p-4 bg-light">
                                <h5 class="fw-bold mb-4 text-dark">प्रमाणित गर्ने:</h5>

                                <p class="mb-2 text-dark">नाम: <span
                                        class="fw-medium">{{ $officerName ?? 'प्रकाश शर्मा' }}</span></p>
                                <p class="mb-2 text-dark">पद: <span
                                        class="fw-medium">{{ $officerPost ?? 'ईन्जिनियर' }}</span></p>
                                <div class="mt-4">
                                    <p class="mb-1 text-dark">सही:</p>
                                    <div class="border-bottom border-dark" style="width: 200px; height: 40px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <div class="border border-2 border-dark rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 150px; height: 150px;">
                                    <p class="mb-0 fw-bold text-dark">कार्यालयको छाप</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div> -->
            </div>


            <!-- Action Buttons -->
            {{-- <div class="d-flex justify-content-end gap-2 mb-4">
                <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> प्रिन्ट गर्नुहोस्
                </button>
                <button type="button" class="btn btn-dark">
                    <i class="bi bi-check-square me-1"></i> स्वीकृत गर्नुहोस्
                </button>
            </div> --}}
        </div>
    </div>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        @media print {
            body {
                font-size: 12pt;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }

            .btn,
            .no-print {
                display: none !important;
            }
        }

        /* Ensure dark text throughout */
        .text-dark {
            color: #1f1e1e;
        }

        /* Simple styling for info boxes */
        .border {
            border-color: #dee2e6;
        }

        /* Table styling */
        .table {
            color: #1f1e1e;
        }

        .table th {
            font-weight: 600;
        }

        .table td,
        .table th {
            padding: 0.75rem;
            vertical-align: middle;
        }
    </style>

    <script>
        function downloadPdf(id) {
            fetch(`/admin/ebps/building-registrations/print-form/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'building_registration_exports.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                })
                .catch(console.error);
        }

        // Listen for document upload event and refresh the page
        document.addEventListener('livewire:init', () => {
            Livewire.on('document-uploaded', () => {
                // Refresh the page to show the newly uploaded document
                window.location.reload();
            });
        });
    </script>
</x-layout.business-app>
