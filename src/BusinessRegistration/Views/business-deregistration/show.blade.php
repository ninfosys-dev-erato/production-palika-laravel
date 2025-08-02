<x-layout.app header="{{ __('businessregistration::businessregistration.business_deregistration_details') }}">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('home') }}/businessstyle.css">
    @endpush
    <div>
        <!-- Header Card -->
        <div class="card header-card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6>
                    <i class="bx bx-building me-2"></i>
                    {{ __('businessregistration::businessregistration.deregistration_details') }}
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
                    @php
                        $firstApplicant = $businessDeRegistration->businessRegistration?->applicants->first();
                    @endphp
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

            {{-- Business Details Card --}}
            <div class="col-12 col-lg-7 d-flex">
                <div class="card border-0 bg-white bg-opacity-90 backdrop-blur-sm rounded-4 flex-fill">
                    <div class="card-header py-4 border-bottom border-light">
                        <h5 class="mb-0 d-flex align-items-center text-dark">
                            <i class="bx bx-buildings me-2 text-primary"></i>
                            {{ __('businessregistration::businessregistration.business_organization_industry_firm_details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row gy-2 mt-2">
                            <div class="col-sm-12">
                                <p><strong>{{ __('businessregistration::businessregistration.name') }}:</strong>
                                    {{ $businessDeRegistration->businessRegistration?->entity_name }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.fiscal_year') }}:</strong>
                                    {{ $businessDeRegistration->businessRegistration?->fiscalYear?->year }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.application_date') }}:</strong>
                                    {{ $businessDeRegistration->application_date }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.old_registration_number') }}:</strong>
                                    {{ $businessDeRegistration->businessRegistration?->registration_number }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.deregistration_registration_number') }}:</strong>
                                    {{ $businessDeRegistration?->registration_number }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.application_status') }}:</strong>
                                    {{ $businessDeRegistration->application_status }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.business_status') }}:</strong>
                                    {{ $businessDeRegistration->businessRegistration?->business_status?->label() }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.paid_amount') }}:</strong>
                                    {{ $businessDeRegistration->amount }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>{{ __('businessregistration::businessregistration.bill_no') }}:</strong>
                                    {{ $businessDeRegistration->bill_no }}</p>
                            </div>
                            <div class="col-12">
                                <p><strong>{{ __('businessregistration::businessregistration.address') }}:</strong>
                                    {{ $businessDeRegistration->businessRegistration?->businessProvince?->title ?? '' }}
                                    {{ $businessDeRegistration->businessRegistration?->businessDistrict ? ', ' . $businessDeRegistration->businessRegistration->businessDistrict->title : '' }}
                                    {{ $businessDeRegistration->businessRegistration?->businessLocalBody ? ', ' . $businessDeRegistration->businessRegistration->businessLocalBody->title : '' }}
                                    {{ $businessDeRegistration->businessRegistration?->business_ward ? ', ' . __('businessregistration::businessregistration.ward') . ' ' . $businessDeRegistration->businessRegistration->business_ward : '' }}
                                    {{ $businessDeRegistration->businessRegistration?->business_tole ? ', ' . $businessDeRegistration->businessRegistration->business_tole : '' }}
                                    {{ $businessDeRegistration->businessRegistration?->business_street ? ', ' . $businessDeRegistration->businessRegistration->business_street : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-2">

            @if ($businessDeRegistration->application_rejection_reason)
                <div class="alert alert-danger rounded-bottom-4 mb-0 px-4 py-3 ">
                    <strong>{{ __('businessregistration::businessregistration.rejection_reason') }}:</strong>
                    {{ $businessDeRegistration->application_rejection_reason }}
                </div>
            @endif
        </div>

        {{-- Additional Applicants Table --}}
        @php
            $applicants = $businessDeRegistration->businessRegistration?->applicants ?? collect();
        @endphp
        @if ($applicants->count() > 1)
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
                                    @foreach ($applicants->skip(1) as $applicant)
                                        <tr>
                                            <td>{{ $applicant->applicant_name }}</td>
                                            <td>
                                                {{ $applicant->applicantProvince->title ?? '' }}
                                                {{ $applicant->applicantDistrict ? ', ' . ($applicant->applicantDistrict->title ?? '') : '' }}
                                                {{ $applicant->applicantLocalBody ? ', ' . ($applicant->applicantLocalBody->title ?? '') : '' }}
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
                                            <td>{{ $applicant->citizenshipDistrict->title ?? '' }}</td>
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


    <div class="mb-3 mt-3">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="btn active btn-primary mx-2" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-business-detail" aria-controls="navs-pills-business-detail"
                    aria-selected="false">
                    {{ __('businessregistration::businessregistration.de_registration_application_detail') }}
                </button>
            </li>


            @if ($businessDeRegistration->application_status != \Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING)
                <li class="nav-item" role="presentation">
                    <button type="button" class="btn mx-2 btn-primary" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-bill" aria-controls="navs-pills-nill" aria-selected="false">
                        {{ __('businessregistration::businessregistration.payment') }}
                    </button>
                </li>
            @endif

            @if ($businessDeRegistration->application_status == \Src\BusinessRegistration\Enums\ApplicationStatusEnum::ACCEPTED)
                <li class="nav-item" role="presentation">
                    <button type="button" class="btn mx-2 btn-primary" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-letter" aria-controls="navs-pills-letter" aria-selected="false">
                        {{ __('businessregistration::businessregistration.business_registration_certificate') }}
                    </button>
                </li>
            @endif
        </ul>
    </div>

    <div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-business-detail" role="tabpanel">
                <livewire:business_registration.business_de_registration_show :businessDeRegistration="$businessDeRegistration" />
            </div>

            <div class="tab-pane fade" id="navs-pills-bill" role="tabpanel">
                <livewire:business_registration.business_de_registration_upload_bill :businessDeRegistration="$businessDeRegistration" />
            </div>

            <div class="tab-pane fade" id="navs-pills-letter" role="tabpanel">
                <livewire:business_registration.business_de_registration_preview :$businessDeRegistration />
            </div>
        </div>

    </div>
</x-layout.app>
