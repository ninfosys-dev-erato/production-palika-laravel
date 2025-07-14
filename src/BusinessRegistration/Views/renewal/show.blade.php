<x-layout.app header="Renewal Detail">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('businessregistration::businessregistration.renewal_detail') }}</h5>
        <a href="javascript:history.back()" class="btn btn-info">
            <i class="bx bx-arrow-back"></i>{{ __('businessregistration::businessregistration.back') }}
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
                                {{ __('businessregistration::businessregistration.registration_number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->registration_no ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-hash text-primary"></i>
                                {{ __('businessregistration::businessregistration.registration_date') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->registration->registration_date ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-warning"></i>
                                {{ __('businessregistration::businessregistration.fiscal_year') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRenewal->fiscalYear->year ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-info"></i>
                                {{ __('businessregistration::businessregistration.renewal_date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->renew_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-check text-success"></i>
                                {{ __('businessregistration::businessregistration.date_to_be_maintained') }}</div>
                            <div class="mt-1">{{ $businessRenewal->date_to_be_maintained ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-dollar text-primary"></i>
                                {{ __('businessregistration::businessregistration.renewal_amount') }}</div>
                            <div class="mt-1">{{ $businessRenewal->renew_amount ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-warning text-danger"></i>
                                {{ __('businessregistration::businessregistration.penalty_amount') }}</div>
                            <div class="mt-1">{{ $businessRenewal->penalty_amount ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-receipt text-success"></i>
                                {{ __('businessregistration::businessregistration.payment_receipt') }}</div>
                            <div class="mt-1">{{ $businessRenewal->payment_receipt ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-secondary"></i>
                                {{ __('businessregistration::businessregistration.payment_receipt_date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->payment_receipt_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-alt text-info"></i>
                                {{ __('businessregistration::businessregistration.renewal_application_date') }}</div>
                            <div class="mt-1">{{ $businessRenewal->created_at->format('d M, Y') ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('businessregistration::businessregistration.application_status') }}</div>
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
                                {{ \Src\BusinessRegistration\Enums\ApplicationStatusEnum::getForWeb()[$businessRenewal->application_status->value] ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 mt-3">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-grievance-detail" aria-controls="navs-pills-recommendation-detail"
                        aria-selected="false">
                    {{ __('businessregistration::businessregistration.business_renewal_action') }}
                </button>
            </li>


            @if (
                $businessRenewal->application_status ==
                    \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED)
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-bill" aria-controls="navs-pills-nill" aria-selected="false">
                        {{ __('businessregistration::businessregistration.certificate') }}
                    </button>
                </li>
            @endif
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-documents" aria-controls="navs-pills-documents" aria-selected="false">
                    {{ __('businessregistration::businessregistration.documents') }}
                </button>
            </li>
        </ul>
    </div>
    <div class="card" style="position: relative;">
        <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
            <div class="btn-group" role="group" aria-label="Recommendation Actions">
                @if (
                    $businessRenewal->application_status ==
                        \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED)
                    <button type="button" class="btn btn-info" onclick="Livewire.dispatch('print-renewal')" data-bs-toggle="tooltip"
                            data-bs-placement="top" title='Print Recommendation'>
                        <i class="bx bx-printer"></i> {{ __('businessregistration::businessregistration.print') }}
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-grievance-detail" role="tabpanel">
                    <livewire:business_registration.business_renewal_action :$businessRenewal/>
                </div>

                <div class="tab-pane fade" id="navs-pills-bill" role="tabpanel">
                    <div class="col-md-12">
                        <div style="border-radius: 10px; text-align: center;">
                            <div id="printContent" style="width: 210mm; display: inline-block;">
                                <livewire:business_registration.business_renewal_template
                                        :$businessRenewal/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-documents" role="tabpanel">
                    <div class="col-md-12">
                                <livewire:business_registration.business_renewal_requested_documents
                                        :$businessRenewal/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>

<script>
    function printDiv() {
        const printContent = document.getElementById('printContent');
        if (!printContent) {
            alert('No content found for printing.');
            return;
        }

        const printContents = printContent.innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        setTimeout(() => {
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }, 100);
    }
</script>
