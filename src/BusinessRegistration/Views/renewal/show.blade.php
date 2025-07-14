<x-layout.app header="Renewal Detail">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('home') }}/businessstyle.css">
    @endpush

    <div>
        <!-- Header Card -->
        <div class="card header-card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6>
                    <i class="bx bx-building me-2"></i>
                    {{ __('businessregistration::businessregistration.business_renewal_details') }}
                </h6>
                <a href="javascript:history.back()" class="btn-back">
                    <i class="bx bx-arrow-back me-2"></i>
                    {{ __('businessregistration::businessregistration.back') }}
                </a>
            </div>
        </div>

        <div class="row g-2">
            {{-- Personal Details Card --}}
            <div class="col-12 col-lg-5 d-flex">
                <div class="card border-0 bg-white bg-opacity-90 backdrop-blur-sm rounded-4 flex-fill">
                    <div class="card-header py-4 border-bottom border-light">
                        <h5 class="mb-0 d-flex align-items-center text-dark">
                            <i class="bx bx-user me-2 text-primary"></i>
                            {{ __('businessregistration::businessregistration.personal_details') }}
                        </h5>
                    </div>
                    @php $firstApplicant = $businessRenewal->registration->applicants->first(); @endphp
                    @if ($firstApplicant)
                        <div class="card-body">
                            <div class="row gy-1 mt-2">
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.name') }}:</strong>
                                        {{ $firstApplicant->applicant_name }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.gender') }}:</strong>
                                        {{ ucfirst($firstApplicant->gender) }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.phone') }}:</strong>
                                        {{ $firstApplicant->phone }}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.father_name') }}:</strong>
                                        {{ $firstApplicant->father_name }}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.grandfather_name') }}:</strong>
                                        {{ $firstApplicant->grandfather_name }}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.email_address') }}:</strong>
                                        {{ $firstApplicant->email }}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.citizenship_number') }}:</strong>
                                        {{ $firstApplicant->citizenship_number }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.district') }}:</strong>
                                        {{ $firstApplicant->citizenshipDistrict?->title ?? '' }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.date') }}:</strong>
                                        {{ $firstApplicant->citizenship_issued_date }}</p>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.position') }}:</strong>
                                        {{ $firstApplicant->position }}</p>
                                </div>
                                <div class="col-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.address') }}:</strong>
                                        {{ $firstApplicant->applicantProvince->title ?? '' }}
                                        {{ $firstApplicant->applicantDistrict ? ', ' . ($firstApplicant->applicantDistrict->title ?? '') : '' }}
                                        {{ $firstApplicant->applicantLocalBody ? ', ' . ($firstApplicant->applicantLocalBody->title ?? '') : '' }}
                                        {{ $firstApplicant->applicant_ward ? ', वार्ड ' . $firstApplicant->applicant_ward : '' }}
                                        {{ $firstApplicant->applicant_tole ? ', ' . $firstApplicant->applicant_tole : '' }}
                                        {{ $firstApplicant->applicant_street ? ', ' . $firstApplicant->applicant_street : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body text-muted">
                            {{ __('businessregistration::businessregistration.no_applicant_information_available') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Renewal Details Card --}}
            <div class="col-12 col-lg-7 d-flex">
                <div class="card border-0 bg-white bg-opacity-90 backdrop-blur-sm rounded-4 flex-fill">
                    <div class="card-header py-4 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="mb-0 d-flex align-items-center text-dark">
                                <i class="bx bx-buildings me-2 text-primary"></i>
                                {{ __('businessregistration::businessregistration.business_renewal_details') }}
                            </h5>
                            @if ($businessRenewal->application_status == 'accepted')
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="Livewire.dispatch('print-renewal')" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title='Print Recommendation'>
                                    <i class="bx bx-printer me-1"></i>
                                    {{ __('businessregistration::businessregistration.print') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-2 mt-2">
                            <div class="col-sm-12">
                                <p><strong>{{ __('businessregistration::businessregistration.name') }}:</strong>
                                    {{ $businessRenewal->registration->entity_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.fiscal_year') }}:</strong>
                                    {{ $businessRenewal->fiscalYear->year ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.registration_date') }}:</strong>
                                    {{ $businessRenewal->registration->registration_date ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.renewal_application_date') }}:</strong>
                                    {{ $businessRenewal->nepali_created_at ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.renewal_date') }}:</strong>
                                    {{ $businessRenewal->renew_date ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.registration_number') }}:</strong>
                                    {{ $businessRenewal->registration_no ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.status') }}:</strong>
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
                                        {!! \Src\BusinessRegistration\Enums\ApplicationStatusEnum::tryFrom(
                                            $businessRenewal->application_status->value,
                                        )?->label() ?? '' !!}
                                    </span>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.renewal_amount') }}:</strong>
                                    {{ $businessRenewal->renew_amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.penalty_amount') }}:</strong>
                                    {{ $businessRenewal->penalty_amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.payment_receipt_date') }}:</strong>
                                    {{ $businessRenewal->payment_receipt_date ?? 'N/A' }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>{{ __('businessregistration::businessregistration.address') }}:</strong>
                                    {{ $businessRenewal->registration->businessProvince?->title ?? '' }}
                                    {{ $businessRenewal->registration->businessDistrict ? ', ' . $businessRenewal->registration->businessDistrict->title : '' }}
                                    {{ $businessRenewal->registration->businessLocalBody ? ', ' . $businessRenewal->registration->businessLocalBody->title : '' }}
                                    {{ $businessRenewal->registration->business_ward ? ', ' . __('businessregistration::businessregistration.ward') . ' ' . $businessRenewal->registration->business_ward : '' }}
                                    {{ $businessRenewal->registration->business_tole ? ', ' . $businessRenewal->registration->business_tole : '' }}
                                    {{ $businessRenewal->registration->business_street ? ', ' . $businessRenewal->registration->business_street : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Applicants Table --}}
        @if ($businessRenewal->registration->applicants->count() > 1)
            <div class="card row g-2 mt-4">
                <div class="col-12">
                    <div>
                        <div class="clean-header text-primary">
                            {{ __('businessregistration::businessregistration.additional_applicants_details') }}
                        </div>
                        <div class="table-responsive px-2">
                            <table class="table table-hover table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>{{ __('businessregistration::businessregistration.name') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.address') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.gender') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.father_name') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.grandfather_name') }}
                                        </th>
                                        <th>{{ __('businessregistration::businessregistration.phone') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.email_address') }}</th>
                                        <th>{{ __('businessregistration::businessregistration.citizenship_number') }}
                                        </th>
                                        <th>{{ __('businessregistration::businessregistration.citizenship_issued_date') }}
                                        </th>
                                        <th>{{ __('businessregistration::businessregistration.citizenship_issued_district') }}
                                        </th>
                                        <th>{{ __('businessregistration::businessregistration.position') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($businessRenewal->registration->applicants->skip(1) as $applicant)
                                        <tr>
                                            <td>{{ $applicant->applicant_name }}</td>
                                            <td>
                                                {{ $applicant->applicant_province ? $applicant->applicantProvince->title ?? '' : '' }}
                                                {{ $applicant->applicant_district ? ', ' . ($applicant->applicantDistrict->title ?? '') : '' }}
                                                {{ $applicant->applicant_local_body ? ', ' . ($applicant->applicantLocalBody->title ?? '') : '' }}
                                                {{ $applicant->applicant_ward ? ', ' . __('businessregistration::businessregistration.ward') . ' ' . $applicant->applicant_ward : '' }}
                                                {{ $applicant->applicant_tole ? ', ' . $applicant->applicant_tole : '' }}
                                                {{ $applicant->applicant_street ? ', ' . $applicant->applicant_street : '' }}
                                            </td>
                                            <td>{{ $applicant->gender }}</td>
                                            <td>{{ $applicant->father_name }}</td>
                                            <td>{{ $applicant->grandfather_name }}</td>
                                            <td>{{ $applicant->phone }}</td>
                                            <td>{{ $applicant->email }}</td>
                                            <td>{{ $applicant->citizenship_number }}</td>
                                            <td>{{ $applicant->citizenship_issued_date }}</td>
                                            <td>{{ $applicant->citizenshipIssuedDistrict->title ?? '' }}</td>
                                            <td>{{ $applicant->position }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-1 mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Left-side buttons -->
            <div class="d-flex gap-2" role="tablist">
                <button type="button" class="btn active btn-primary" role="tab" data-bs-toggle="pill"
                    data-bs-target="#navs-pills-renewal-action" aria-controls="navs-pills-renewal-action"
                    aria-selected="true">
                    {{ __('businessregistration::businessregistration.business_renewal_action') }}
                </button>

                @if ($businessRenewal->application_status != \Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING)
                    <button type="button" class="btn mx-2 btn-primary" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-payment" aria-controls="navs-pills-payment" aria-selected="false">
                        {{ __('businessregistration::businessregistration.payment') }}
                    </button>
                @endif

                <button type="button" class="btn btn-primary" role="tab" data-bs-toggle="pill"
                    data-bs-target="#navs-pills-documents" aria-controls="navs-pills-documents" aria-selected="false">
                    {{ __('businessregistration::businessregistration.documents') }}
                </button>

                @if ($businessRenewal->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED)
                    <button type="button" class="btn btn-primary" role="tab" data-bs-toggle="pill"
                        data-bs-target="#navs-pills-certificate" aria-controls="navs-pills-certificate"
                        aria-selected="false">
                        {{ __('businessregistration::businessregistration.certificate') }}
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-renewal-action" role="tabpanel"
            aria-labelledby="navs-pills-renewal-action-tab">
            <livewire:business_registration.business_renewal_action :$businessRenewal />
        </div>

        <div class="tab-pane fade" id="navs-pills-payment" role="tabpanel" aria-labelledby="navs-pills-payment-tab">
            <livewire:business_registration.business_renewal_upload_bill :$businessRenewal />
        </div>

        <div class="tab-pane fade" id="navs-pills-documents" role="tabpanel"
            aria-labelledby="navs-pills-documents-tab">
            <livewire:business_registration.business_renewal_requested_documents :$businessRenewal />
        </div>

        <div class="tab-pane fade" id="navs-pills-certificate" role="tabpanel"
            aria-labelledby="navs-pills-certificate-tab">
            <div class="col-md-12">
                <div style="border-radius: 10px; text-align: center;">
                    <div id="printContent" style="width: 210mm; display: inline-block;">
                        <livewire:business_registration.business_renewal_template :$businessRenewal />
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.app>
