@push('styles')
    <link rel="stylesheet" href="{{ asset('home') }}/businessstyle.css">
@endpush
@php
    use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
@endphp
<div>
    <div class="card mt-2">
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
                </div>
            </div>
        </div>
    </div>
    <form enctype="multipart/form-data" wire:submit.prevent="save">
        @csrf
        @if ($showData)
            <div class="min-vh-100 bg-gradient-peaceful py-5">
                <div>
                    <!-- Progress Header Card -->
                    <div class="nav-buttons-container mb-3">
                        <button type="button" class="nav-link {{ $activeTab === 'personal' ? 'active' : '' }}"
                            wire:click="setActiveTab('personal')">
                            <div class="nav-icon">
                                <i class='bx bx-user'></i>
                            </div>
                            <span
                                class="nav-text">{{ __('businessregistration::businessregistration.personal_detail') }}</span>
                            <div class="nav-indicator"></div>
                        </button>

                        <button type="button" class="nav-link {{ $activeTab === 'business' ? 'active' : '' }}"
                            wire:click="setActiveTab('business')">
                            <div class="nav-icon">
                                <i class='bx bx-buildings'></i>
                            </div>
                            <span
                                class="nav-text">{{ __('businessregistration::businessregistration.registration_detail') }}</span>
                            <div class="nav-indicator"></div>
                        </button>

                        <button type="button" class="nav-link {{ $activeTab === 'type' ? 'active' : '' }}"
                            wire:click="setActiveTab('type')">
                            <div class="nav-icon">
                                <i class='bx bx-check-circle'></i>
                            </div>
                            <span
                                class="nav-text">{{ __('businessregistration::businessregistration.type_selection') }}</span>
                            <div class="nav-indicator"></div>
                        </button>

                    </div>

                    <div class="card border-0 shadow-xl bg-white-translucent">
                        <div class="tab-content">
                            <!-- Personal Details Tab -->
                            <div class="tab-pane fade {{ $activeTab === 'personal' ? 'show active' : '' }}"
                                id="personal" role="tabpanel">
                                @foreach ($personalDetails as $index => $detail)
                                    <div class="divider divider-primary text-start text-primary mb-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.personal_detail') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.name') }}</label>
                                            <div class="form-control-plaintext">{{ $detail['applicant_name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.gender') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['gender'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.father_name') }}</label>
                                            <div class="form-control-plaintext">{{ $detail['father_name'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.grandfather_name') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['grandfather_name'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.phone_number') }}</label>
                                            <div class="form-control-plaintext">{{ $detail['phone'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.email_address') }}</label>
                                            <div class="form-control-plaintext">{{ $detail['email'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.citizenship_information') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.citizenship_number') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['citizenship_number'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.issuance_date') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['citizenship_issued_date'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.issued_district') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['citizenship_issued_district'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.citizenship_front') }}</label>
                                            <br>
                                            @if (!empty($detail['citizenship_front_url']))
                                                <a href="{{ $detail['citizenship_front_url'] }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                </a>
                                            @else
                                                <div class="form-control-plaintext">-</div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.citizenship_rear') }}</label>
                                            <br>
                                            @if (!empty($detail['citizenship_rear_url']))
                                                <a href="{{ $detail['citizenship_rear_url'] }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                </a>
                                            @else
                                                <div class="form-control-plaintext">-</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.personal_address_information') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.province') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['applicant_province'] ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.district') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['applicant_district'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.local_body') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['applicant_local_body'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.ward') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['applicant_ward'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.tole') }}</label>
                                            <div class="form-control-plaintext">{{ $detail['applicant_tole'] ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.street') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $detail['applicant_street'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                <div
                                    class="d-flex justify-content-between align-items-center pt-4 border-top border-light">
                                    <button type="button" class="btn btn-outline-peaceful" disabled>
                                        <i
                                            class="fas fa-arrow-left me-2"></i>{{ __('businessregistration::businessregistration.previous') }}
                                    </button>
                                    <div class="step-indicator">
                                        <span
                                            class="badge bg-light text-muted">{{ __('businessregistration::businessregistration.step_1_of_3') }}</span>
                                    </div>
                                    <button type="button" class="btn btn-primary-peaceful"
                                        wire:click="setActiveTab('business')">
                                        {{ __('businessregistration::businessregistration.next') }}<i
                                            class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>


                            <!-- Business Details Tab -->
                            <div class="tab-pane fade {{ $activeTab === 'business' ? 'show active' : '' }}"
                                id="business" role="tabpanel">
                                <div class="card-body p-1">
                                    <div class="divider divider-primary text-start text-primary mb-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.business_organization_industry_firm_details') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.fiscal_year') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->fiscalYear->year ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.application_date') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->application_date ?? '-' }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.business_organization_industry_firm_name') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->entity_name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.business_organization_industry_firm_nature_or_category_or_type') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->business_nature ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.main_goods_or_services') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->main_service_or_goods ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.purpose') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->purpose ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.business_organization_industry_firm_address') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.business_organization_industry_firm_province') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->businessProvince?->title ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.business_organization_industry_firm_district') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->businessDistrict?->title ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.business_organization_industry_firm_local_body') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->businessLocalBody?->title ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.ward') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->business_ward ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.tole') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->business_tole ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label
                                                class="form-label-peaceful">{{ __('businessregistration::businessregistration.street') }}</label>
                                            <div class="form-control-plaintext">
                                                {{ $businessRegistration->business_street ?? '-' }}</div>
                                        </div>
                                    </div>

                                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::BUSINESS->value)


                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.capital_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.capital_investment') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->capital_investment ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.working_capital') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->working_capital ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.fixed_capital') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->fixed_capital ?? '-' }}</div>
                                            </div>
                                        </div>





                                        <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.land/house_owner_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <label
                                                    class="form-label-peaceful d-block">{{ __('businessregistration::businessregistration.is_rented') }}</label>
                                                <div class="form-control-plaintext">
                                                    @if ($businessRegistration->is_rented == 1)
                                                        {{ __('businessregistration::businessregistration.yes') }}
                                                    @elseif ($businessRegistration->is_rented == 0)
                                                        {{ __('businessregistration::businessregistration.no') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.houseownername') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->houseownername ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.land/house_owner_phone') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->phone ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.monthly_rent') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->monthly_rent ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.rentagreement') }}</label>
                                                @if (!empty($businessRegistration['rentagreement_url']))
                                                    <a href="{{ $businessRegistration['rentagreement_url'] }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                        <i class="bx bx-file"></i>
                                                        {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                    </a>
                                                @else
                                                    <div class="form-control-plaintext">-</div>
                                                @endif
                                            </div>

                                        </div>

                                    @endif

                                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::FIRM->value)
                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.operation_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">

                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.capital_investment') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->capital_investment ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.operation_date') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->operation_date ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.land_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.houseownername') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->houseownername ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.east') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->east ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.west') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->west ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.north') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->north ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.south') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->south ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.landplotnumber') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->landplotnumber ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.area') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->area ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::INDUSTRY->value)
                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.operation_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.capital_investment') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->capital_investment ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.fixed_capital') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->fixed_capital ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.working_capital') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->working_capital ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.production_capacity') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->production_capacity ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.required_manpower') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->required_manpower ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.number_of_shifts') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->number_of_shifts ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.operation_starting_date') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->operation_date ?? '-' }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.industry_total_running_day') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->total_running_day ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::ORGANIZATION->value)
                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.operation_details') }}
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.financial_source') }}</label>
                                                <div class="form-control-plaintext">
                                                    {{ $businessRegistration->financial_source ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.uploaded_documents') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        @if (!empty($requiredBusinessDocuments))
                                            @foreach ($requiredBusinessDocuments as $doc)
                                                <div class="col-md-4">
                                                    <label
                                                        class="form-label-peaceful">{{ $doc['name'] ?? __('businessregistration::businessregistration.document') }}</label>
                                                    <br>
                                                    <a href="{{ $doc['url'] }}" target="_blank">
                                                        {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-12">
                                                {{ __('businessregistration::businessregistration.no_uploaded_documents') }}
                                            </div>
                                        @endif

                                    </div>

                                </div>


                                <div
                                    class="d-flex justify-content-between align-items-center pt-4 border-top border-light">
                                    <button type="button" class="btn btn-outline-peaceful"
                                        wire:click="setActiveTab('personal')">
                                        <i
                                            class="fas fa-arrow-left me-2"></i>{{ __('businessregistration::businessregistration.previous') }}
                                    </button>
                                    <div class="step-indicator">
                                        <span
                                            class="badge bg-light text-muted">{{ __('businessregistration::businessregistration.step_2_of_3') }}</span>
                                    </div>
                                    <button type="button" class="btn btn-primary-peaceful"
                                        wire:click="setActiveTab('type')">
                                        {{ __('businessregistration::businessregistration.next') }}<i
                                            class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Type Selection Tab -->
                            <div class="tab-pane fade {{ $activeTab === 'type' ? 'show active' : '' }}"
                                id="type" role="tabpanel">
                                <div class="card-body p-1">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label for="registration_type_id" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.select_de_registration_type') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select wire:model.live="businessDeRegistration.registration_type_id"
                                                class="form-control @error('businessRegistration.registration_type_id') is-invalid @enderror"
                                                id="registration_type_id" aria-label="Registration Type"
                                                wire:change.live="setFields($event.target.value)">
                                                <option value="">
                                                    {{ __('businessregistration::businessregistration.select_de_registration_type') }}
                                                </option>
                                                @foreach ($registrationTypes as $id => $value)
                                                    <option value="{{ $id }}">{{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('businessRegistration.registration_type_id')
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('businessRegistration.registration_type_id') }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="divider divider-primary text-start text-primary">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.business_de_registration_application_detail') }}
                                            </div>
                                        </div>
                                        <div class="row g-1">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.fiscal_year') }}</label>
                                                <select wire:model="businessDeRegistration.fiscal_year"
                                                    class="form-control" name="fiscal_year">
                                                    <option value="">
                                                        {{ __('businessregistration::businessregistration.fiscal_year') }}
                                                    </option>
                                                    @foreach ($fiscalYears as $id => $year)
                                                        <option value="{{ $id }}">{{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label-peaceful">{{ __('businessregistration::businessregistration.application_date') }}</label>
                                                <input wire:model="businessDeRegistration.application_date"
                                                    name="application_date" type="text"
                                                    class="form-control nepali-date"
                                                    placeholder="{{ __('businessregistration::businessregistration.application_date') }}">
                                            </div>

                                        </div>

                                    </div>



                                </div>


                                <div>
                                    <div id="dynamic-form">
                                        <div class="row">
                                            @if (!empty($data))
                                                @foreach ($data as $key => $field)
                                                    <div class="col-md-6">
                                                        <x-form.field :field="$field" />

                                                        @if ($field['type'] === 'file' && !empty($field['url']))
                                                            <a href="{{ $field['url'] }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary mt-2">
                                                                <i class="bx bx-file"></i>
                                                                {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                            </a>
                                                        @endif
                                                        @if ($field['type'] === 'file' && !empty($field['urls']) && is_array($field['urls']))
                                                            @foreach ($field['urls'] as $url)
                                                                <a href="{{ $url }}" target="_blank"
                                                                    class="btn btn-sm btn-outline-primary mt-2">
                                                                    <i class="bx bx-file"></i>
                                                                    {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-center pt-4 border-top border-light">
                                    <button type="button" class="btn btn-outline-peaceful"
                                        wire:click="setActiveTab('business')">
                                        <i
                                            class="fas fa-arrow-left me-2"></i>{{ __('businessregistration::businessregistration.previous') }}
                                    </button>
                                    <div class="step-indicator">
                                        <span
                                            class="badge bg-light text-muted">{{ __('businessregistration::businessregistration.step_3_of_3') }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-success-peaceful">
                                        <i
                                            class="fas fa-check me-2"></i>{{ __('businessregistration::businessregistration.submit') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
