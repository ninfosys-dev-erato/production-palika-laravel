<x-layout.customer-app header="Map Apply View">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body bg-opacity-10 border-start border-primary border-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 fw-bold text-primary">{{ __('ebps::ebps.map_apply_details') }}</h2>
                    <p class="small mb-0">{{ __('ebps::ebps.submission_id') }}: <strong>{{ $mapApply->submission_id }}</strong></p>
                </div>
                <div>
                    <span class="badge bg-primary">{{ $mapApply->fiscalYear->year ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Personal Information Card -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-user-circle text-primary me-2"></i>
                        <h3 class="h5 fw-semibold mb-0 text-primary">{{ __('ebps::ebps.personal_information') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">{{ __('ebps::ebps.full_name') }}</label>
                            <div class="fw-medium">{{ $mapApply->full_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">{{ __('ebps::ebps.age') }}</label>
                            <div class="fw-medium">{{ $mapApply->age ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">{{ __('ebps::ebps.applied_date') }}</label>
                            <div class="fw-medium">{{ $mapApply->applied_date ?? 'N/A' }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Application Details Card -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-file-description text-primary me-2"></i>
                        <h3 class="h5 fw-semibold mb-0 text-primary">{{__('ebps::ebps.application_details')}}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">{{__('ebps::ebps.usage')}}</label>
                            <div class="fw-medium">{{ $mapApply->usage ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">{{__('ebps::ebps.fiscal_year')}}</label>
                            <div class="fw-medium">{{ $mapApply->fiscalYear->year ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small">{{__('ebps::ebps.construction_type')}}</label>
                            <div class="fw-medium">{{ $mapApply->constructionType->title ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Land Details Card -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-map-pin text-primary me-2"></i>
                        <h3 class="h5 fw-semibold mb-0 text-primary">{{__('ebps::ebps.land_details')}}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.local_body') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->localBody->title ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.ward') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->ward ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.tole') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->tole ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.area') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->area_sqm ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.lot_no') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->lot_no ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light bg-opacity-50">
                                <label class="form-label text-muted small">{{ __('ebps::ebps.seat_no') }}</label>
                                <div class="fw-medium">{{ $mapApply->landDetail->seat_no ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Four Boundary Details Card -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-border-all text-primary me-2"></i>
                        <h3 class="h5 fw-semibold mb-0 text-primary">{{ __('ebps::ebps.four_boundary_details') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    @if ($mapApply->landDetail->fourBoundaries->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
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
                        <div class="alert alert-info mb-0">
                            <i class="ti ti-info-circle me-2"></i>
                            {{ __('ebps::ebps.no_boundary_details_available') }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Signature Card -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-signature text-primary me-2"></i>
                        <h3 class="h5 fw-semibold mb-0 text-primary">{{ __('ebps::ebps.signature') }}</h3>
                    </div>
                </div>
                <div class="card-body text-center">
                    @if ($mapApply->signature)
                        <div class="border p-3 rounded d-inline-block shadow-sm bg-light bg-opacity-50 mb-2">
                            <img src="{{ asset('storage/' . $mapApply->signature) }}" alt="Signature"
                                class="img-fluid rounded" style="max-width: 200px;">
                        </div>
                        <div class="small text-muted">{{ __('ebps::ebps.signature') }}</div>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-muted fst-italic">
                                <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                {{ __('ebps::ebps.no_signature_uploaded') }}.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
