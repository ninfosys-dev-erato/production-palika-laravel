<x-layout.app header="{{ __('ejalas::ejalas.complaint_registration_view') }}">
    <!-- Header Section with Breadcrumb and Actions -->
    <div class="container-fluid px-4 py-3">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="fw-bold text-primary mb-0">
                    <i class="bx bx-file me-2"></i>{{ __('ejalas::ejalas.complaint_details') }}
                </h4>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="d-flex justify-content-md-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                <i class="bx bx-home-alt"></i> {{ __('ejalas::ejalas.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none">{{ __('ejalas::ejalas.complaint_registration') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.view') }}</li>
                    </ol>
                </nav>
            </div>
        </div>


        <!-- Main Content -->
        <div class="row g-4">
            <!-- Complaint Summary Card -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bx bx-info-circle text-primary me-2"></i>{{ __('ejalas::ejalas.complaint_summary') }}
                        </h5>

                        <div>
                            @if ($complaintRegistration->status)
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    {{ __('ejalas::ejalas.active') }}
                                </span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                    {{ __('ejalas::ejalas.inactive') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.fiscal_year') }}</p>
                                <p class="fw-bold mb-0">{{ $complaintRegistration->fiscalYear->year }}</p>

                            </div>
                            <div class="col-md-6 col-lg-3">

                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.registration_no') }}</p>
                                <p class="fw-bold mb-0">{{ $complaintRegistration->reg_no }}</p>

                            </div>
                            <div class="col-md-6 col-lg-3">

                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.registration_date') }}</p>
                                <p class="fw-bold mb-0">
                                    {{ $complaintRegistration->reg_date }}

                                </p>

                            </div>
                            <div class="col-md-6 col-lg-3">

                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.old_registration_no') }}</p>
                                <p class="fw-bold mb-0">{{ $complaintRegistration->old_reg_no ?: 'N/A' }}</p>

                            </div>
                        </div>

                        <hr>

                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.registration_address') }}</p>
                                <p class="fw-bold">{{ $complaintRegistration->reg_address }}</p>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.priority') }}</p>
                                <p class="fw-bold">{{ $complaintRegistration->priority->name }} </p>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.dispute_matter') }}</p>
                                <p class="fw-bold">{{ $complaintRegistration->disputeArea?->title_en ?? 'n/a' }}</p>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <p class="text-muted small mb-1">{{ __('ejalas::ejalas.subject') }}</p>
                                <p class="fw-bold">{{ $complaintRegistration->subject }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Claim Request -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bx bx-detail text-primary me-2"></i>{{ __('ejalas::ejalas.description') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light rounded">
                            {{ $complaintRegistration->description }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bx bx-list-check text-primary me-2"></i>{{ __('ejalas::ejalas.claim_request') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light rounded">
                            {{ $complaintRegistration->claim_request }}
                        </div>
                    </div>
                </div>
            </div>


            <!-- Parties Information Tabs -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bx bx-list-check text-primary me-2"></i>{{ __('ejalas::ejalas.complainer_details') }}
                            <span class="badge bg-primary">{{ count($complainerDetails) }}</span>
                        </h5>
                        <hr>
                    </div>
                    <div class="card-body" style="height: 300px; overflow-y: auto;">
                        @foreach ($complainerDetails as $complainer)
                            <div class="row mb-2">
                                <div class="col-6"><strong> {{__('ejalas::ejalas.name')}}:</strong></div>
                                <div class="col-6">{{ $complainer->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Age:</strong></div>
                                <div class="col-6">{{ $complainer->age }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Phone No:</strong></div>
                                <div class="col-6">{{ $complainer->phone_no }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Citizenship No:</strong></div>
                                <div class="col-6">{{ $complainer->citizenship_no }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Gender:</strong></div>
                                <div class="col-6">{{ $complainer->gender }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Grandfather Name:</strong></div>
                                <div class="col-6">{{ $complainer->grandfather_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Father Name:</strong></div>
                                <div class="col-6">{{ $complainer->father_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Spouse Name:</strong></div>
                                <div class="col-6">{{ $complainer->spouse_name }}</div>
                            </div>
                            <!-- Permanent Address -->
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Province:</strong></div>
                                <div class="col-6">{{ $complainer->permanentProvince->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent District:</strong></div>
                                <div class="col-6">{{ $complainer->permanentDistrict->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Local Body:</strong></div>
                                <div class="col-6">{{ $complainer->permanentLocalBody->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Ward:</strong></div>
                                <div class="col-6">{{ $complainer->permanent_ward_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Tole:</strong></div>
                                <div class="col-6">{{ $complainer->permanent_tole }}</div>
                            </div>
                            <!-- Temporary Address -->
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Province:</strong></div>
                                <div class="col-6">{{ $complainer->temporaryProvince->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary District:</strong></div>
                                <div class="col-6">{{ $complainer->temporaryDistrict->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Local Body:</strong></div>
                                <div class="col-6">{{ $complainer->temporaryLocalBody->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Ward:</strong></div>
                                <div class="col-6">{{ $complainer->temporary_ward_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Tole:</strong></div>
                                <div class="col-6">{{ $complainer->temporary_tole }}</div>
                            </div>
                            <hr class="my-1">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h5> <i class="bx bx-group text-primary me-2"></i>{{ __('ejalas::ejalas.defender_details') }}
                            <span class="badge bg-primary">{{ count($defenderDetails) }}</span>
                        </h5>
                        <hr>
                    </div>
                    <div class="card-body" style="height: 300px; overflow-y: auto;">
                        @foreach ($defenderDetails as $defender)
                            <div class="row mb-2">
                                <div class="col-6"><strong> {{__('ejalas::ejalas.name')}}:</strong></div>
                                <div class="col-6">{{ $defender->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Age:</strong></div>
                                <div class="col-6">{{ $defender->age }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Phone No:</strong></div>
                                <div class="col-6">{{ $defender->phone_no }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Citizenship No:</strong></div>
                                <div class="col-6">{{ $defender->citizenship_no }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Gender:</strong></div>
                                <div class="col-6">{{ $defender->gender }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Grandfather Name:</strong></div>
                                <div class="col-6">{{ $defender->grandfather_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Father Name:</strong></div>
                                <div class="col-6">{{ $defender->father_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Spouse Name:</strong></div>
                                <div class="col-6">{{ $defender->spouse_name }}</div>
                            </div>
                            <!-- Permanent Address -->
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Province:</strong></div>
                                <div class="col-6">{{ $defender->permanentProvince->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent District:</strong></div>
                                <div class="col-6">{{ $defender->permanentDistrict->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Local Body:</strong></div>
                                <div class="col-6">{{ $defender->permanentLocalBody->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Ward:</strong></div>
                                <div class="col-6">{{ $defender->permanent_ward_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Permanent Tole:</strong></div>
                                <div class="col-6">{{ $defender->permanent_tole }}</div>
                            </div>
                            <!-- Temporary Address -->
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Province:</strong></div>
                                <div class="col-6">{{ $defender->temporaryProvince->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary District:</strong></div>
                                <div class="col-6">{{ $defender->temporaryDistrict->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Local Body:</strong></div>
                                <div class="col-6">{{ $defender->temporaryLocalBody->title ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Ward:</strong></div>
                                <div class="col-6">{{ $defender->temporary_ward_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Temporary Tole:</strong></div>
                                <div class="col-6">{{ $defender->temporary_tole }}</div>
                            </div>
                            <hr class="mt-1">
                        @endforeach
                    </div>
                </div>

            </div>
</x-layout.app>
