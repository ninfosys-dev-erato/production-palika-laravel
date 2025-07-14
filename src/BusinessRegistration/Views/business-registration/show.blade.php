<x-layout.app header="Business Registration Details">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">
            {{ __('businessregistration::businessregistration.business_registration_details') }}</h5>
        <a href="javascript:history.back()" class="btn btn-info">
            <i class="bx bx-arrow-back"></i>{{ __('businessregistration::businessregistration.back') }}
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
                                {{ __('businessregistration::businessregistration.registration_number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRegistration->registration_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-certification text-success"></i>
                                {{ __('businessregistration::businessregistration.certificate_number') }}</div>
                            <div class="mt-1 fw-bold">{{ $businessRegistration->certificate_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-map text-warning"></i>
                                {{ __('businessregistration::businessregistration.address') }}
                            </div>
                            <div class="mt-1 fw-bold">
                                {{ $businessRegistration->province->title ?? '' }}{{ $businessRegistration->district ? ', ' . $businessRegistration->district->title : '' }}{{ $businessRegistration->localBody ? ', ' . $businessRegistration->localBody->title : '' }}{{ $businessRegistration->ward_no ? ', ward-' . $businessRegistration->ward_no : '' }}{{ $businessRegistration->tole ? ', ' . $businessRegistration->tole : '' }}{{ $businessRegistration->way ? ', ' . $businessRegistration->way : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar text-info"></i>
                                {{ __('businessregistration::businessregistration.application_date') }}</div>
                            <div class="mt-1">{{ $businessRegistration->application_date_en ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-calendar-check text-secondary"></i>
                                {{ __('businessregistration::businessregistration.registration_date') }}</div>
                            <div class="mt-1">{{ $businessRegistration->registration_date ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('businessregistration::businessregistration.business_status') }}</div>
                            <span
                                class="badge {{ $businessRegistration->business_status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($businessRegistration->business_status ?? 'N/A') }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small"><i class="bx bx-briefcase text-primary"></i>
                                {{ __('businessregistration::businessregistration.application_status') }}</div>
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
                                    {{ __('businessregistration::businessregistration.application_rejection_reason') }}
                                </div>
                                <div class="mt-1">{{ $businessRegistration->application_rejection_reason ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($businessRegistration->application_status == 'accepted')
                        @if (empty($businessRegistration->records->first()->reg_no))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.business-registration.business.register', ['id' => $businessRegistration->id]) }}"
                                    class="btn btn-info">
                                    {{ __('businessregistration::businessregistration.register_business') }}
                                </a>
                            </div>
                        @else
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.file_records.show', ['id' => $businessRegistration->records->first()->id]) }}"
                                    class="btn btn-info">
                                    {{ __('recommendation::recommendation.view_registerd_file') }}
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-business-detail" aria-controls="navs-pills-business-detail"
                        aria-selected="false">
                        {{ __('businessregistration::businessregistration.business_registration_application_detail') }}
                    </button>
                </li>


                @if ($businessRegistration->application_status != \Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING->value)
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-bill" aria-controls="navs-pills-nill" aria-selected="false">
                            {{ __('businessregistration::businessregistration.payment') }}
                        </button>
                    </li>
                @endif

                @if ($businessRegistration->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED->value)
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-letter" aria-controls="navs-pills-letter" aria-selected="false">
                            {{ __('businessregistration::businessregistration.business_registration_certificate') }}
                        </button>
                    </li>
                @endif
            </ul>
        </div>

        <div class="card" style="position: relative;">
            <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
                <div class="btn-group" role="group" aria-label="Recommendation Actions">
                    <livewire:business_registration.business_registration_reject :$businessRegistration />
                    &nbsp;

                    @if ($businessRegistration->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED->value)
                        {{-- <button type="button" class="btn btn-info" onclick="printDiv()" data-bs-toggle="tooltip"
                            data-bs-placement="top" title='Print Certificate'>
                            <i class="bx bx-printer"></i> {{ __('businessregistration::businessregistration.print') }}
                        </button>
                        <button type="button" class="btn btn-info" onclick="Livewire.dispatch('print-business')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title='Print Document'>
                            <i class="bx bx-printer"></i> {{ __('businessregistration::businessregistration.print') }}
                        </button> --}}
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-business-detail" role="tabpanel">
                        <livewire:business_registration.business_registration_show :$businessRegistration />
                    </div>

                    <div class="tab-pane fade" id="navs-pills-bill" role="tabpanel">
                        <livewire:business_registration.business_registration_upload_bill :$businessRegistration />
                    </div>

                    <div class="tab-pane fade" id="navs-pills-letter" role="tabpanel">
                        {{-- <div class="col-md-12">
                            <div style="border-radius: 10px; text-align: center;">
                                <div id="printContent" style="width: 210mm; display: inline-block;">
                                    <style>
                                        {{ $businessRegistration->registrationType?->form?->styles ?? '' }}
                                    </style>
                                    {!! $template !!}
                                </div>
                            </div>
                        </div> --}}
                        <livewire:business_registration.business_registration_preview :$businessRegistration />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
