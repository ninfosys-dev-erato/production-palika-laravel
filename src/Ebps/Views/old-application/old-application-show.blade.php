<x-layout.app header="Old Map Application View">

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

        <button onclick="downloadPdf({{ $mapApply->id }})" class="btn btn-outline-primary">
            <i class="bx bx-printer"></i> Download PDF
        </button>



    </div>


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
                            <div class="data-row">
                                <div class="data-label">२.७ फोटो:</div>
                                @php
                                    $fileUrl = customFileAsset(
                                        config('src.Ebps.ebps.path'),
                                        $mapApply->houseOwner->photo,
                                        'local',
                                        'tempUrl',
                                    );
                                @endphp

                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bx bx-file me-1"></i>
                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
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

            <div class="section-subheader mt-5 d-flex align-items-center">
                <i class="fas fa-signature me-2 fs-4 text-primary"></i>
                <h5 class="mb-0 text-primary fw-semibold">{{ __('ebps::ebps.signature') }}</h5>
            </div>

            <div class="text-center border rounded p-4 bg-light mt-3">
                @if ($mapApply->signature)
                    @php
                        $fileUrl = customFileAsset(
                            config('src.Ebps.ebps.path'),
                            $mapApply->signature,
                            'local',
                            'tempUrl',
                        );
                    @endphp

                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bx bx-file me-1"></i>
                        {{ __('yojana::yojana.view_uploaded_file') }}
                    </a>
                @else
                    <div class="text-muted fst-italic">
                        <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                        {{ __('ebps::ebps._no_signature_uploaded') }}
                    </div>
                @endif
            </div>

            <div class="section-subheader mt-4">
                <i class="fas fa-signature me-2"></i> {{ __('ebps::ebps.other_documents') }}
            </div>

            <div class="row">
                @forelse ($documents as $document)
                    @php
                        $fileUrl = customFileAsset(config('src.Ebps.ebps.path'), $document->file, 'local', 'tempUrl');
                        $extension = pathinfo($document->file, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
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
            </div>

        </div>
    </div>
    </div>



</x-layout.app>

<script>
    function downloadPdf(id) {
        fetch(`/admin/ebps/old-applications/print-form/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'old_map_application_exports.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            })
            .catch(console.error);
    }
</script>
