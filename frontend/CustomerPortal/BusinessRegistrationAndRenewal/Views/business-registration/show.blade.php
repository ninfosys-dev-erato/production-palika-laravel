<x-layout.customer-app header="Business Registration Details">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('Business Registration Details') }}</h5>
        <a href="javascript:history.back()" class="btn btn-info">
            <i class="bx bx-arrow-back"></i>{{ __('Back') }}
        </a>
    </div>

    <div class="mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0 text-primary">{{ $businessRegistration->entity_name ?? 'N/A' }}</h5>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-hash text-primary"></i>
                                {{ __('Registration Number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRegistration->registration_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-certification text-success"></i>
                                {{ __('Certificate Number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRegistration->certificate_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-map text-warning"></i> {{ __('Address') }}
                            </div>
                            <div class="mt-1 fw-bold">
                                {{ $businessRegistration->province->title ?? '' }}{{ $businessRegistration->district ? ', ' . $businessRegistration->district->title : '' }}{{ $businessRegistration->localBody ? ', ' . $businessRegistration->localBody->title : '' }}{{ $businessRegistration->ward_no ? ', ward-' . $businessRegistration->ward_no : '' }}{{ $businessRegistration->tole ? ', ' . $businessRegistration->tole : '' }}{{ $businessRegistration->way ? ', ' . $businessRegistration->way : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-info"></i>
                                {{ __('Application Date') }}</div>
                            <div class="mt-1">{{ $businessRegistration->application_date_en ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-check text-secondary"></i>
                                {{ __('Registration Date') }}</div>
                            <div class="mt-1">{{ $businessRegistration->registration_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('Business Status') }}</div>
                            <span
                                class="badge {{ $businessRegistration->business_status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($businessRegistration->business_status ?? 'N/A') }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('Application Status') }}</div>
                            <span
                                class="badge {{ match ($businessRegistration->application_status) {
                                    'pending' => 'bg-warning',
                                    'rejected' => 'bg-danger',
                                    'sent for payment' => 'bg-info',
                                    'bill uploaded' => 'bg-primary',
                                    'sent for approval' => 'bg-secondary',
                                    'accepted' => 'bg-success',
                                    'sent for renewal' => 'bg-dark',
                                    default => 'bg-light text-dark',
                                } }}">
                                {{ \Src\BusinessRegistration\Enums\ApplicationStatusEnum::getForWeb()[$businessRegistration->application_status] ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>

                    @if ($businessRegistration->application_status === 'rejected')
                        <div class="col-md-12">
                            <div class="mt-3">
                                <div class="text-muted small"><i class="bx bx-error text-danger"></i>
                                    {{ __('Application Rejection Reason') }}</div>
                                <div class="mt-1">{{ $businessRegistration->application_rejection_reason ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-grievance-detail" aria-controls="navs-pills-recommendation-detail"
                        aria-selected="false">
                        {{ __('Business Registration Application Detail') }}
                    </button>
                </li>


                @if ($businessRegistration->application_status != \Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING->value)
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-bill" aria-controls="navs-pills-nill" aria-selected="false">
                            {{ __('Payment') }}
                        </button>
                    </li>
                @endif

                @if ($businessRegistration->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED->value)
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-letter" aria-controls="navs-pills-letter" aria-selected="false">
                            {{ __('Business Registration Certificate') }}
                        </button>
                    </li>
                @endif
            </ul>
        </div>

        <div class="card" style="position: relative;">
            <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
                <div class="btn-group" role="group" aria-label="Recommendation Actions">

                    @if (
                        $businessRegistration->application_status ==
                            \Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING->value ||
                            $businessRegistration->application_status ==
                                \Src\BusinessRegistration\Enums\ApplicationStatusEnum::REJECTED->value)
                        <a href="{{ route('customer.business-registration.business-registration.edit', $businessRegistration->id) }}"
                            class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ __('Edit') }}">
                            <i class="bx bx-edit"></i> {{ __('Edit') }}
                        </a>
                    @endif

                    @if ($businessRegistration->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED->value)
                        <button type="button" class="btn btn-info"
                            onclick="Livewire.dispatch('print-customer-business')" data-bs-toggle="tooltip"
                            data-bs-placement="top" title='Print Business Registration Certificate'>
                            <i class="bx bx-printer"></i> {{ __('Print') }}
                        </button>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-grievance-detail" role="tabpanel">
                        <livewire:customer_portal.business_registration_and_renewal.business_registration_show
                            :$businessRegistration />
                    </div>

                    <div class="tab-pane fade" id="navs-pills-bill" role="tabpanel">
                        <livewire:customer_portal.business_registration_and_renewal.business_registration_upload_bill
                            :$businessRegistration />
                    </div>

                    <div class="tab-pane fade" id="navs-pills-letter" role="tabpanel">
                        <div class="col-md-12">
                            <div style="border-radius: 10px; text-align: center;">
                                <div id="printContent" style="width: 210mm; display: inline-block;">
                                    <style>
                                        {{ $businessRegistration->registrationType?->form?->styles ?? '' }}
                                    </style>
                                    {!! $template !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
