<x-layout.business-app header="Map Apply View">
    <style>
        :root {
            --primary-color: #14539A;
            --secondary-color: #E04622;
            --accent-color: #F1C40F;
            --light-bg: #f8f9fa;
            --border-color: #d9e2ef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .container {
            background-color: white;
        }

        .section-card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 0 1.5rem;
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
            margin-bottom: 1.5rem;
        }

        .section-subheader {
            background-color: #e9ecef;
            border-left: 4px solid var(--primary-color);
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .data-row {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            padding: 0.6rem 0;
        }

        .data-label {
            width: 35%;
            font-weight: 500;
            color: #555;
        }

        .data-value {
            width: 65%;
            font-weight: 600;
            color: #222;
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
            margin-bottom: 1.5rem;
        }

        .table thead th {
            background-color: #e9ecef;
            color: var(--primary-color);
        }

        @media print {

            .btn-print,
            .btn-outline-primary {
                display: none !important;
            }

            .section-card {
                page-break-inside: avoid;
            }

            .section-header {
                background-color: #f1f1f1 !important;
                color: black !important;
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

    <div class="container mb-5 p-0 shadow-sm rounded">
        <!-- Header -->
        <div class="section-header">
            <div>
                <i class="fas fa-map-marked-alt me-2"></i> {{ __('ebps::ebps.map_apply_details') }}
            </div>
            <div>
                <span class="badge badge-fiscal-year"> आ.व. {{ $mapApply->fiscalYear->year ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="section-card">

            <!-- 1. Personal Information -->
            <div>

                <div class="section-subheader">
                    <i class="fas fa-user me-2"></i> {{ __('आवेदकको विवरण') }}
                </div>
                <div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.submission_id') }}:</div>
                        <div class="data-value">{{ $mapApply->submission_id ?? 'N/A' }}</div>
                    </div>

                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.full_name') }}:</div>
                        <div class="data-value">{{ $mapApply->full_name ?? 'N/A' }}</div>
                    </div>
                    {{-- <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.age') }}:</div>
                        <div class="data-value">{{ $mapApply->age ?? 'N/A' }}</div>
                    </div> --}}
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.applied_date') }}:</div>
                        <div class="data-value">{{ $mapApply->applied_date ?? 'N/A' }}</div>
                    </div>
                </div>


                <!-- 2. Application Details -->
                <div class="section-subheader mt-4">
                    <i class="fas fa-file-alt me-2"></i> {{ __('ebps::ebps.application_details') }}
                </div>
                <div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.usage') }}:</div>
                        <div class="data-value">{{ $mapApply->usage ?? 'N/A' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.fiscal_year') }}:</div>
                        <div class="data-value">{{ $mapApply->fiscalYear->year ?? 'N/A' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.construction_type') }}:</div>
                        <div class="data-value">{{ $mapApply->constructionType->title ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- 3. Land Details -->
                <div class="section-subheader mt-4">
                    <i class="fas fa-map-pin me-2"></i> {{ __('ebps::ebps.land_details') }}
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.local_body') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->localBody->title ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.ward') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->ward ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.tole') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->tole ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.area') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->area_sqm ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.lot_no') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->lot_no ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.seat_no') }}:</div>
                            <div class="data-value">{{ $mapApply->landDetail->seat_no ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- 4. Four Boundary Details -->
                <div class="section-subheader mt-4">
                    <i class="fas fa-border-all me-2"></i> {{ __('ebps::ebps.four_boundary_details') }}
                </div>
                <div>
                    @if ($mapApply->landDetail->fourBoundaries->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('ebps::ebps.title') }}</th>
                                        <th>{{ __('ebps::ebps.direction') }}</th>
                                        <th>{{ __('ebps::ebps.distance') }}</th>
                                        <th>{{ __('ebps::ebps.lot_no') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapApply->landDetail->fourBoundaries as $boundary)
                                        <tr>
                                            <td>{{ $boundary->title ?? 'N/A' }}</td>
                                            <td>{{ $boundary->direction ?? 'N/A' }}</td>
                                            <td>{{ $boundary->distance ?? 'N/A' }}</td>
                                            <td>{{ $boundary->lot_no ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0 mt-2">
                            <i class="ti ti-info-circle me-2"></i>
                            {{ __('ebps::ebps.no_boundary_details_available') }}.
                        </div>
                    @endif
                </div>

                <!-- 5. Signature -->
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
                            $fileUrl = customFileAsset(
                                config('src.Ebps.ebps.path'),
                                $document->file,
                                'local',
                                'tempUrl',
                            );
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
</x-layout.business-app>

<script>
    function downloadPdf(id) {
        fetch(`/admin/ebps/map-applies/print-form/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'map_apply_exports.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            })
            .catch(console.error);
    }
</script>
