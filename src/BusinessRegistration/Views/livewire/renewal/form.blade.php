<div>
    <div class="card mt-2 mb-2">
        <div class="card-header">
            <div class="mb-4">
                <label
                    class="form-label fw-bold fs-7 d-block">{{ __('businessregistration::businessregistration.search_by_company_name/registration_number') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="name" wire:model.defer="search"
                        wire:keydown.enter.prevent="searchBusiness"
                        placeholder={{ __('businessregistration::businessregistration.enter_company_name/registration_number') }}>
                    <button class="btn btn-primary" type="button" wire:click="searchBusiness">
                        {{ __('businessregistration::businessregistration.search') }}
                    </button>

                    @if ($businessData)
                        <button class="btn btn-success" type="button"
                            wire:click="renewBusiness({{ $businessData->id }})">
                            {{ __('businessregistration::businessregistration.renew_business') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div>
        @if ($businessData)
            <div class="row g-2 mt-3">
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
                            $firstApplicant = $businessData->applicants->first();
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
                                        {{ $businessData->entity_name }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.fiscal_year') }}:</strong>
                                        {{ $businessData->fiscalYear?->year }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.application_date') }}:</strong>
                                        {{ $businessData->application_date }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.registration_number') }}:</strong>
                                        {{ $businessData->registration_number }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.status') }}:</strong>
                                        {{ $businessData->application_status }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>{{ __('businessregistration::businessregistration.business_status') }}:</strong>
                                        {{ $businessData->business_status?->label() }}</p>
                                </div>
                                <div class="col-12">
                                    <p><strong>{{ __('businessregistration::businessregistration.address') }}:</strong>
                                        {{ $businessData->businessProvince?->title ?? '' }}
                                        {{ $businessData->businessDistrict ? ', ' . $businessData->businessDistrict->title : '' }}
                                        {{ $businessData->businessLocalBody ? ', ' . $businessData->businessLocalBody->title : '' }}
                                        {{ $businessData->business_ward ? ', ' . __('businessregistration::businessregistration.ward') . ' ' . $businessData->business_ward : '' }}
                                        {{ $businessData->business_tole ? ', ' . $businessData->business_tole : '' }}
                                        {{ $businessData->business_street ? ', ' . $businessData->business_street : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
