<x-layout.customer-app header="Map Apply View">

    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>
    </div>

    <div class="container py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body border-start border-dark border-3 bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 mb-1 fw-bold text-primary">{{ __('ebps::ebps.building_registration_details') }}</h2>
                        <p class="small mb-0 text-primary">{{ __('ebps::ebps.submission_id') }}:
                            <strong>{{ $mapApply->submission_id }}</strong>
                        </p>
                    </div>
                    <div>
                        <span class="badge bg-primary">{{ $mapApply->fiscalYear->year ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm h-100 mb-4">
            <div class="card-body">
                <!-- Building Details Section -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">१. प्रस्तावित भवनको विवरण</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.१ निर्माण भइसकेको किसिम :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->buildingConstructionType->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.२ प्रयोग :</strong>
                                <span class="text-dark">आवासीय</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.३ भवनको ढलानको किसिम :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->buildingRoofType->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.४ भवन निर्माण भएको साल :</strong>
                                <span class="text-dark">{{ $mapApply->year_of_house_built ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.५ भवनको तल्ला संख्या :</strong>
                                <span class="text-dark">{{ $mapApply->storey_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.६ भवनको कोठा संख्या :</strong>
                                <span class="text-dark">{{ $mapApply->no_of_rooms ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.७ भवनको जम्मा क्षेत्रफल :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->area_of_building_plinth ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.८ अन्य निर्माण (भवन बाहेक जस्तै:कम्पाउणडवाल,
                                    टहरा)ले ढाकेको क्षेत्रफल (वर्ग फिट/वर्ग मिटर) :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->detail->other_construction_area ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.९ भवनको कुल उचाई जमिनको सतहबाट (मिटर/फिट)
                                    :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->former_other_construction_area ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">१.१० भवन निर्माण र साबिक भवन निर्माणले ढाक्ने
                                    जम्मा क्षेत्रफल(Ground Coverage)(वर्ग फिट/वर्ग मिटर) :</strong>
                                <span
                                    class="text-dark">{{ $mapApply->former_other_construction_area ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 text-dark">१.११ भवन/निर्माण तला अनुसार क्षेत्रफल सम्बन्धि विवरण:</h5>
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
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">२. जग्गाको विवरण</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">२.१ कित्ता नं:</strong>
                                <span class="text-dark">{{ $mapApply->landDetail->area_sqm ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">२.२ सिट नं:</strong>
                                <span class="text-dark">{{ $mapApply->landDetail->seat_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">२.३ निर्माण भएको साल:</strong>
                                <span class="text-dark">{{ $mapApply->year_of_house_built }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">२.४ कित्ताको साबिक गा.वि.स:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landDetail->localBody->name ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">२.५ टोल:</strong>
                                <span class="text-dark">{{ $mapApply->landDetail->tole ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 text-dark">चार किल्ला विवरण</h5>
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
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">३. जग्गा धनी विवरण</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.१ नाम:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->owner_name ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.२ फोन नं:</strong>
                                <span class="text-dark">{{ $mapApply->landOwner->mobile_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.३ नागरिकता नं:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->citizenship_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.५ जारी मिति:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->citizenship_issued_date ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.६ जारी जिल्ला:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->citizenship_issued_at ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.७ प्रदेश:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->province->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.८ पालिका:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->landOwner->localBody->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.९ टोल:</strong>
                                <span class="text-dark">{{ $mapApply->landOwner->tole ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light text-center">
                                <strong class="d-block mb-2 text-dark">३.१० फोटो:</strong>
                                <div class="border p-2 d-inline-block">
                                    <img src="{{ asset('path/to/photo.jpg') }}" alt="Land Owner Photo"
                                        class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- House Owner Details Section -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">३. घर धनी विवरण</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.१ नाम:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->owner_name ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.२ फोन नं:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->mobile_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.३ नागरिकता नं:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->citizenship_no ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.५ जारी मिति:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->citizenship_issued_date ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.६ जारी जिल्ला:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->citizenship_issued_at ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.७ प्रदेश:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->province->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.८ पालिका:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->houseOwner->localBody->title ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">३.९ टोल:</strong>
                                <span class="text-dark">{{ $mapApply->landOwner->tole ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light text-center">
                                <strong class="d-block mb-2 text-dark">३.१० फोटो:</strong>
                                <div class="border p-2 d-inline-block">
                                    <img src="{{ asset('path/to/photo.jpg') }}" alt="House Owner Photo"
                                        class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicant Details Section -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">४. निवेदकको विवरण</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">४.१ निवेदकको प्रकार:</strong>
                                <span class="text-dark">{{ $mapApply->applicant_type }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">४.२ नाम:</strong>
                                <span class="text-dark">{{ $mapApply->full_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">४.३ फोन नं:</strong>
                                <span class="text-dark">{{ $mapApply->buildingDetail->mobile_no ?? '१२३' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">४.४ उमेर:</strong>
                                <span class="text-dark">{{ $mapApply->age ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 h-100 bg-light">
                                <strong class="d-block mb-1 text-dark">४.५ निर्माण मिति:</strong>
                                <span
                                    class="text-dark">{{ $mapApply->buildingDetail->build_date ?? '२०८१-०१-२५' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Four Boundaries Details Table -->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">५. चार किल्ला विवरण</h4>
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

                <!-- Certification Section -->
                {{-- <div class="mt-5 pt-4 border-top">
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
                                    <div class="border-bottom border-dark" style="width: 200px; height: 40px;"></div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> प्रिन्ट गर्नुहोस्
            </button>
            <button type="button" class="btn btn-dark">
                <i class="bi bi-check-square me-1"></i> स्वीकृत गर्नुहोस्
            </button>
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
</x-layout.customer-app>
