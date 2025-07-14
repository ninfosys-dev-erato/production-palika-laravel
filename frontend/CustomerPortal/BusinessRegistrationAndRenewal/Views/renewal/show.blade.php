<x-layout.customer-app header="Renewal Detail">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('Renewal Detail') }}</h5>
        <a href="javascript:history.back()" class="btn btn-info">
            <i class="bx bx-arrow-back"></i>{{ __('Back') }}
        </a>
    </div>

    <div class="mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0 text-primary">{{ $businessRenewal->registration->entity_name ?? 'N/A' }}</h5>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-warning"></i>
                                {{ __('Registration Number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->registration_no ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-hash text-primary"></i>
                                {{ __('Registration Date') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->registration->registration_date ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-warning"></i>
                                {{ __('Fiscal Year') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->fiscalYear->year ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-info"></i>
                                {{ __('Renewal Date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->renew_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-check text-success"></i>
                                {{ __('Date To Be Maintained') }}</div>
                            <div class="mt-1">{{ $businessRenewal->date_to_be_maintained ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-dollar text-primary"></i>
                                {{ __('Renewal Amount') }}</div>
                            <div class="mt-1">{{ $businessRenewal->renew_amount ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-warning text-danger"></i>
                                {{ __('Penalty Amount') }}</div>
                            <div class="mt-1">{{ $businessRenewal->penalty_amount ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-receipt text-success"></i>
                                {{ __('Payment Receipt') }}</div>
                            <div class="mt-1">{{ $businessRenewal->payment_receipt ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-secondary"></i>
                                {{ __('Payment Receipt Date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->payment_receipt_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-alt text-info"></i>
                                {{ __('Renewal Application Date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->created_at->format('d M, Y') ?? 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('Application Status') }}</div>
                            <span
                                class="badge {{ match ($businessRenewal->application_status) {
                                    'pending' => 'bg-warning',
                                    'rejected' => 'bg-danger',
                                    'sent for payment' => 'bg-info',
                                    'bill uploaded' => 'bg-primary',
                                    'sent for approval' => 'bg-secondary',
                                    'accepted' => 'bg-success',
                                    'sent for renewal' => 'bg-dark',
                                    default => 'bg-light text-dark',
                                } }}">
                                {{ \Src\BusinessRegistration\Enums\ApplicationStatusEnum::getForWeb()[$businessRenewal->application_status] ?? 'Unknown' }}
                            </span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <ul class="nav nav-tabs card-header-tabs d-flex justify-content-center" id="renewalTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-primary" id="business-list-tab" data-bs-toggle="tab"
                            href="#business-list" role="tab" aria-controls="business-list" aria-selected="true">
                            <i class="bx bx-list-ul me-1"></i> {{ __('Business Registration Lists') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-primary" id="required-docs-tab" data-bs-toggle="tab"
                            href="#required-docs" role="tab" aria-controls="required-docs" aria-selected="false">
                            <i class="bx bx-file me-1"></i> {{ __('Required Documents') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="renewalTabsContent">
                    <!-- Business Registration Lists Tab -->
                    <div class="tab-pane fade show active p-3" id="business-list" role="tabpanel"
                        aria-labelledby="business-list-tab">
                        <livewire:customer_portal.business_registration_and_renewal.business_renewal_action
                            :$businessRenewal />
                    </div>

                    <!-- Required Documents Tab -->
                    <div class="tab-pane fade p-3" id="required-docs" role="tabpanel"
                        aria-labelledby="required-docs-tab">
                        <livewire:customer_portal.business_registration_and_renewal.business_renewal_requested_documents
                            :$businessRenewal />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
