<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <i class="fas fa-user me-2"></i> {{ __('ebps::ebps.personal_information') }}
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
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.age') }}:</div>
                        <div class="data-value">{{ $mapApply->age ?? 'N/A' }}</div>
                    </div>
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
                        <div class="data-value">
                            {{ $mapApply->fiscalYear->year ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">{{ __('ebps::ebps.construction_type') }}:</div>
                        <div class="data-value">
                            {{ $mapApply->constructionType->title ?? 'N/A' }}
                        </div>
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
                            <div class="data-value">
                                {{ $mapApply->landDetail->localBody->title ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.ward') }}:</div>
                            <div class="data-value">
                                {{ $mapApply->landDetail->ward ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.tole') }}:</div>
                            <div class="data-value">
                                {{ $mapApply->landDetail->tole ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.area') }}:</div>
                            <div class="data-value">
                                {{ $mapApply->landDetail->area_sqm ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.lot_no') }}:</div>
                            <div class="data-value">
                                {{ $mapApply->landDetail->lot_no ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="data-row">
                            <div class="data-label">{{ __('ebps::ebps.seat_no') }}:</div>
                            <div class="data-value">
                                {{ $mapApply->landDetail->seat_no ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Four Boundary Details -->
                <div class="section-subheader mt-4">
                    <i class="fas fa-border-all me-2"></i> {{ __('ebps::ebps.four_boundary_details') }}
                </div>
                <div>
                    @if ($mapApply->landDetail->fourBoundaries && $mapApply->landDetail->fourBoundaries->isNotEmpty())
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


                @if (isset($mapApply->signature))

                    <!-- 5. Signature -->
                    <div class="section-subheader mt-4">
                        <i class="fas fa-signature me-2"></i> {{ __('ebps::ebps.signature') }}
                    </div>
                    <div class="text-center">
                        @if (file_exists($mapApply->signature))
                            <div class="border p-3 rounded d-inline-block shadow-sm bg-light bg-opacity-50 mb-2">
                                <img src="{{ asset('storage/' . $mapApply->signature) }}" alt="Signature"
                                    class="img-fluid rounded" style="max-width: 200px;">
                            </div>
                            <div class="small text-muted">{{ __('ebps::ebps.signature') }}</div>
                        @else
                            <div class="text-muted fst-italic">
                                <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                {{ __('ebps::ebps._no_signature_uploaded') }}.
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>


</body>

</html>