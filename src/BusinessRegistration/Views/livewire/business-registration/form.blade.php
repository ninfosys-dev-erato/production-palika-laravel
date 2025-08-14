@push('styles')
    <link rel="stylesheet" href="{{ asset('home') }}/businessstyle.css">
@endpush
@php
    use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
    use App\Enums\Action;
@endphp
<form wire:submit.prevent="save" enctype="multipart/form-data">
    @csrf

    <div class="min-vh-100 bg-gradient-peaceful py-5">
        <div>
            <!-- Progress Header Card -->
            <div class="nav-buttons-container mb-3">
                <button type="button" class="nav-link {{ $activeTab === 'personal' ? 'active' : '' }}"
                    wire:click="setActiveTab('personal')">
                    <div class="nav-icon">
                        <i class='bx bx-user'></i>
                    </div>
                    <span class="nav-text">{{ __('businessregistration::businessregistration.personal_detail') }}</span>
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
                    <span class="nav-text">{{ __('businessregistration::businessregistration.type_selection') }}</span>
                    <div class="nav-indicator"></div>
                </button>

            </div>

            <!-- Main Form Card -->
            <div class="card border-0 shadow-xl bg-white-translucent">

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade {{ $activeTab === 'personal' ? 'show active' : '' }}" id="personal"
                        role="tabpanel">
                        <!-- Phone Search for this personal detail -->
                        @if ($action === App\Enums\Action::CREATE && !$isCustomer)
                            <livewire:phone_search />
                        @endif
                        @foreach ($personalDetails as $index => $detail)
                            <div wire:key="personal-detail-{{ $index }}">
                                <!-- Personal Details Header -->
                                <div class="divider divider-primary text-start text-primary mb-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.personal_detail') }}
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <!-- Applicant Name -->
                                    <div class="col-md-6">
                                        <label for="applicant_name" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.applicant_name"
                                            name="applicant_name" type="text"
                                            class="form-control  @error('personalDetails.' . $index . '.applicant_name') is-invalid @enderror"
                                            id="applicant_name"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_enter_full_name') }}">
                                        @error('personalDetails.' . $index . '.applicant_name')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.gender') }}
                                        </label>
                                        <select wire:model="personalDetails.{{ $index }}.gender" name="gender"
                                            class="form-control @error('businessRegistration.gender') is-invalid @enderror"
                                            id="gender">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.select_gender') }}
                                            </option>
                                            @foreach ($genders as $option)
                                                <option value="{{ $option['value'] }}">{{ $option['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('businessRegistration.gender')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Father's Name -->
                                    <div class="col-md-6">
                                        <label for="father_name" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.father_name') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.father_name"
                                            name="father_name" type="text"
                                            class="form-control @error('businessRegistration.father_name') is-invalid @enderror"
                                            id="father_name"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_enter_father_name') }}">
                                        @error('businessRegistration.father_name')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Grandfather's Name -->
                                    <div class="col-md-6">
                                        <label for="grandfather_name" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.grandfather_name') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.grandfather_name"
                                            name="grandfather_name" type="text"
                                            class="form-control @error('businessRegistration.grandfather_name') is-invalid @enderror"
                                            id="grandfather_name"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_enter_grandfather_name') }}">
                                        @error('businessRegistration.grandfather_name')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.phone_number') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.phone" name="phone"
                                            type="text"
                                            class="form-control @error('businessRegistration.phone') is-invalid @enderror"
                                            id="phone"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_phone') }}">
                                        @error('businessRegistration.phone')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.email_address') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.email" name="email"
                                            type="text"
                                            class="form-control @error('businessRegistration.email') is-invalid @enderror"
                                            id="email"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_email') }}">
                                        @error('businessRegistration.email')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Citizenship Details Header -->
                                <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.citizenship_information') }}
                                    </div>
                                </div>
                                <div class="row g-4">

                                    <!-- Citizenship Number -->
                                    <div class="col-md-4">
                                        <label for="citizenship_number" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.citizenship_number') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.citizenship_number"
                                            name="citizenship_number" type="text"
                                            class="form-control @error('businessRegistration.citizenship_number') is-invalid @enderror"
                                            id="citizenship_number"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_citizenship_number') }}">
                                        @error('businessRegistration.citizenship_number')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Citizenship Issuance Date -->
                                    <div class="col-md-4">
                                        <label for="citizenship_issued_date_{{ $index }}"
                                            class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.issuance_date') }}
                                        </label>
                                        <input
                                            wire:model="personalDetails.{{ $index }}.citizenship_issued_date"
                                            name="citizenship_issued_date" type="text"
                                            class="form-control nepali-date @error('businessRegistration.citizenship_issued_date') is-invalid @enderror"
                                            id="citizenship_issued_date_{{ $index }}">
                                        @error('businessRegistration.citizenship_issued_date')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Citizenship Issued District -->
                                    <div class="col-md-4">
                                        <label for="citizenship_issued_district" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.issued_district') }}
                                        </label>
                                        <select
                                            wire:model="personalDetails.{{ $index }}.citizenship_issued_district"
                                            name="citizenship_issued_district"
                                            class="form-control @error('businessRegistration.citizenship_issued_district') is-invalid @enderror"
                                            id="citizenship_issued_district">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.placeholder_issued_district') }}
                                            </option>
                                            @foreach ($citizenshipDistricts as $id => $title)
                                                <option value="{{ $id }}">{{ $title }}</option>
                                            @endforeach
                                        </select>



                                        @error('businessRegistration.citizenship_issued_district')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Citizenship Front Upload -->
                                    <div class="col-md-6">
                                        <label for="citizenship_front_{{ $index }}"
                                            class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.upload_citizenship_front') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.citizenship_front"
                                            type="file" class="form-control"
                                            id="citizenship_front_{{ $index }}" accept="image/*">
                                        <div wire:loading
                                            wire:target="personalDetails.{{ $index }}.citizenship_front">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Uploading...
                                        </div>
                                        @if (!empty($detail['citizenship_front_url']))
                                            <a href="{{ $detail['citizenship_front_url'] }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file"></i>
                                                {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Citizenship Rear Upload -->
                                    <div class="col-md-6">
                                        <label for="citizenship_rear_{{ $index }}"
                                            class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.upload_citizenship_rear') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.citizenship_rear"
                                            type="file" class="form-control"
                                            id="citizenship_rear_{{ $index }}" accept="image/*">
                                        <div wire:loading
                                            wire:target="personalDetails.{{ $index }}.citizenship_rear">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Uploading...
                                        </div>

                                        @if (!empty($detail['citizenship_rear_url']))
                                            <a href="{{ $detail['citizenship_rear_url'] }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file"></i>
                                                {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Personal Address Header -->
                                <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.personal_address_information') }}
                                    </div>
                                </div>
                                <div class="row g-4">

                                    <!-- Province -->
                                    <div class="col-md-4">
                                        <label for="applicant_province" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.province') }}
                                        </label>
                                        <select
                                            wire:model.live="personalDetails.{{ $index }}.applicant_province"
                                            class="form-control" name="applicant_province"
                                            wire:change="getApplicantDistricts({{ $index }})">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.select_province') }}
                                            </option>
                                            @foreach ($provinces as $id => $title)
                                                <option value="{{ $id }}">{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- District -->
                                    <div class="col-md-4">
                                        <label for="applicant_district" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.district') }}
                                        </label>
                                        <select
                                            wire:model.live="personalDetails.{{ $index }}.applicant_district"
                                            wire:key="personalDetails-{{ $index }}-{{ $personalDetails[$index]['applicant_province'] ?? 'none' }}"
                                            class="form-control" name="applicant_district"
                                            wire:change="getApplicantLocalBodies({{ $index }})">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.select_district') }}
                                            </option>
                                            @foreach ($applicantDistricts[$index] ?? [] as $id => $title)
                                                <option value="{{ $id }}">{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Local Body -->
                                    <div class="col-md-4">
                                        <label for="applicant_local_body" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.local_body') }}
                                        </label>
                                        <select
                                            wire:model.live="personalDetails.{{ $index }}.applicant_local_body"
                                            wire:key="personalDetails-{{ $index }}-{{ $personalDetails[$index]['applicant_district'] ?? 'none' }}"
                                            class="form-control" name="applicant_local_body"
                                            wire:change="getApplicantWards({{ $index }})">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.select_local_body') }}
                                            </option>
                                            @foreach ($applicantLocalBodies[$index] ?? [] as $id => $title)
                                                <option value="{{ $id }}">{{ $title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Ward -->
                                    <div class="col-md-4">
                                        <label for="applicant_ward" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.ward') }}
                                        </label>
                                        <select wire:model.live="personalDetails.{{ $index }}.applicant_ward"
                                            wire:key="personalDetails-{{ $index }}-{{ $personalDetails[$index]['applicant_local_body'] ?? 'none' }}"
                                            class="form-control" name="applicant_ward">
                                            <option value="">
                                                {{ __('businessregistration::businessregistration.select_ward') }}
                                            </option>
                                            @foreach ($applicantWards[$index] ?? [] as $id => $title)
                                                <option value="{{ $title }}">
                                                    {{ replaceNumbers($title, true) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tole -->
                                    <div class="col-md-4">
                                        <label for="tole" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.tole') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.applicant_tole"
                                            type="text" class="form-control" id="tole"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_tole') }}">
                                    </div>

                                    <!-- Street -->
                                    <div class="col-md-4">
                                        <label for="street" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.street') }}
                                        </label>
                                        <input wire:model="personalDetails.{{ $index }}.applicant_street"
                                            type="text" class="form-control" id="street"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_street') }}">
                                    </div>
                                </div>

                                <!-- Action Buttons -->
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

                            <!-- Remove button for each personal detail -->
                            @if (count($personalDetails) > 1)
                                <div class="d-flex justify-content-start mb-2 mt-2">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removePersonalDetail({{ $index }})">
                                        <i class="fas fa-trash me-1"></i>
                                        {{ __('businessregistration::businessregistration.remove_personal_info') }}
                                    </button>
                                </div>
                            @endif
                        @endforeach

                        <!-- Add new personal detail button -->
                        <div class="d-flex justify-content-start mb-2 mt-2">
                            <button type="button" class="btn btn-outline-primary" wire:click="addPersonalDetail">
                                <i class="fas fa-plus me-1"></i>
                                {{ __('businessregistration::businessregistration.add_new_personal_info') }}
                            </button>
                        </div>

                    </div>


                    <!-- Business Details Tab -->
                    <div class="tab-pane fade {{ $activeTab === 'business' ? 'show active' : '' }}" id="business"
                        role="tabpanel">
                        <div class="card-body p-1">
                            <!-- Business Details Header -->
                            <div class="divider divider-primary text-start text-primary mb-4">
                                <div class="divider-text fw-bold fs-6">
                                    {{ __('businessregistration::businessregistration.business_organization_industry_firm_details') }}
                                </div>
                            </div>
                            <div class="row g-4">
                                <!-- Fiscal Year -->
                                <div class="col-md-6">
                                    <label for="fiscal_year" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.fiscal_year') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select wire:model="businessRegistration.fiscal_year"
                                        class="form-control @error('businessRegistration.fiscal_year') is-invalid @enderror"
                                        name="fiscal_year" wire:change="fiscalYearChanged($event.target.value)">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.fiscal_year') }}
                                        </option>
                                        @foreach ($fiscalYears as $id => $year)
                                            <option value="{{ $id }}">{{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('businessRegistration.fiscal_year')
                                        <div class="invalid-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Registration Date -->
                                <div class="col-md-6">
                                    <label for="application_date" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.application_date') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input wire:model="businessRegistration.application_date" name="application_date"
                                        type="text"
                                        class="nepali-date form-control @error('businessRegistration.application_date') is-invalid @enderror"
                                        id="application_date">
                                    @error('businessRegistration.application_date')
                                        <div class="invalid-message">
                                            {{ $errors->first('businessRegistration.application_date') }}</div>
                                    @enderror
                                </div>


                                @if ($action == Action::CREATE && !$isCustomer)
                                    <div class="col-md-12">
                                        <label class="form-label-peaceful d-block">
                                            {{ __('businessregistration::businessregistration.do_you_want_to_enter_custom_registration_number?') }}
                                        </label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="is_previously_registered_yes" name="is_previouslyRegistered"
                                                    wire:model="is_previouslyRegistered" value="1"
                                                    wire:change="previouslyRegisteredChanged($event.target.value)">
                                                <label class="form-check-label"
                                                    for="is_previously_registered_yes">{{ __('businessregistration::businessregistration.yes') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    id="is_previously_registered_no" name="is_previouslyRegistered"
                                                    wire:model="is_previouslyRegistered" value="0"
                                                    wire:change="previouslyRegisteredChanged($event.target.value)">
                                                <label class="form-check-label"
                                                    for="is_previously_registered_no">{{ __('businessregistration::businessregistration.no') }}</label>
                                            </div>
                                        </div>
                                        @error('businessRegistration.is_previouslyRegistered')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                @if ($showRegistrationDetailsFields)
                                    <!-- Registration Date -->
                                    <div class="col-md-6">
                                        <label for="registration_date" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.registration_date') }}
                                        </label>
                                        <input wire:model="businessRegistration.registration_date"
                                            name="registration_date" type="text" class="form-control nepali-date"
                                            id="registration_date"
                                            placeholder="{{ __('businessregistration::businessregistration.enter_registration_date') }}">
                                        @error('businessRegistration.registration_date')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="registration_number" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.registration_number') }}
                                        </label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input wire:model="businessRegistration.registration_number"
                                                name="registration_number" type="number" class="form-control w-50"
                                                id="registration_number" min="1">
                                            <span>
                                                <span class="fw-bold">/ {{ $selectedFiscalYearText }}</span>
                                            </span>

                                        </div>
                                        @error('businessRegistration.registration_number')
                                            <div class="invalid-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif


                                <!-- Entity Name -->
                                <div class="col-12">
                                    <label for="entity_name" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input wire:model="businessRegistration.entity_name" name="entity_name"
                                        type="text"
                                        class="form-control @error('businessRegistration.entity_name') is-invalid @enderror"
                                        id="entity_name"
                                        placeholder="{{ __('businessregistration::businessregistration.business_organization_industry_firm_name') }}">
                                    @error('businessRegistration.entity_name')
                                        <div class="invalid-message">
                                            {{ $errors->first('businessRegistration.entity_name') }}</div>
                                    @enderror
                                </div>

                                <!-- Business Nature -->
                                <div class="col-md-6">
                                    <label for="business_nature" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_nature') }}
                                    </label>

                                    <input wire:model="businessRegistration.business_nature" name="business_nature"
                                        type="text"
                                        class="form-control @error('businessRegistration.business_nature') is-invalid @enderror"
                                        id="business_nature"
                                        placeholder="{{ __('businessregistration::businessregistration.business_organization_industry_firm_nature') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="business_category" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_category_or_type') }}
                                    </label>

                                    <input wire:model="businessRegistration.business_category"
                                        name="business_category" type="text"
                                        class="form-control @error('businessRegistration.business_category') is-invalid @enderror"
                                        id="business_category"
                                        placeholder="{{ __('businessregistration::businessregistration.business_organization_industry_firm_category_or_type') }}">
                                </div>

                                <!-- Main Goods/Services -->
                                <div class="col-md-6">
                                    <label for="main_service_or_goods" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.main_goods_or_services') }}
                                    </label>
                                    <input wire:model="businessRegistration.main_service_or_goods"
                                        name="main_service_or_goods" type="text"
                                        class="form-control @error('businessRegistration.main_service_or_goods') is-invalid @enderror"
                                        id="main_service_or_goods"
                                        placeholder="{{ __('businessregistration::businessregistration.placeholder_main_goods_services') }}">
                                    @error('businessRegistration.main_service_or_goods')
                                        <div class="invalid-message">
                                            {{ $errors->first('businessRegistration.main_service_or_goods') }}</div>
                                    @enderror
                                </div>

                                <!-- purpose -->
                                <div class="col-md-6">
                                    <label for="purpose" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.purpose') }}
                                    </label>
                                    <input wire:model="businessRegistration.purpose" name="purpose" type="text"
                                        class="form-control @error('businessRegistration.purpose') is-invalid @enderror"
                                        id="purpose"
                                        placeholder="{{ __('businessregistration::businessregistration.placeholder_purpose') }}">
                                    @error('businessRegistration.purpose')
                                        <div class="invalid-message">
                                            {{ $errors->first('businessRegistration.purpose') }}</div>
                                    @enderror
                                </div>
                            </div>






                            <!-- Business Address Header -->
                            <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                <div class="divider-text fw-bold fs-6">
                                    {{ __('businessregistration::businessregistration.business_organization_industry_firm_address') }}
                                </div>
                            </div>
                            <div class="row g-4">
                                <!-- Province -->
                                <div class="col-md-4">
                                    <label for="business_province" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_province') }}
                                    </label>
                                    <select wire:model.defer="businessRegistration.business_province"
                                        class="form-control" name="business_province"
                                        wire:change="getBusinessDistricts">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.select_province') }}
                                        </option>
                                        @foreach ($provinces as $id => $title)
                                            <option value="{{ $id }}">{{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- District -->
                                <div class="col-md-4">
                                    <label for="business_district" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_district') }}
                                    </label>
                                    <select wire:model="businessRegistration.business_district" class="form-control"
                                        name="business_district" wire:change="getBusinessLocalBodies">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.select_district') }}
                                        </option>
                                        @foreach ($businessDistricts as $id => $title)
                                            <option value="{{ $id }}">{{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Local Body -->
                                <div class="col-md-4">
                                    <label for="business_local_body" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.business_organization_industry_firm_local_body') }}
                                    </label>
                                    <select wire:model.live="businessRegistration.business_local_body"
                                        class="form-control" name="business_local_body"
                                        wire:change="getBusinessWards">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.select_local_body') }}
                                        </option>
                                        @foreach ($businessLocalBodies as $id => $title)
                                            <option value="{{ $id }}">{{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ward -->
                                <div class="col-md-4">
                                    <label for="business_ward" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.ward') }}
                                    </label>
                                    <select wire:model.live="businessRegistration.business_ward" class="form-control"
                                        name="business_ward">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.select_ward') }}
                                        </option>
                                        @foreach ($businessWards as $id => $title)
                                            <option value="{{ $title }}"> {{ replaceNumbers($title, true) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tole -->
                                <div class="col-md-4">
                                    <label for="business_tole" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.tole') }}
                                    </label>
                                    <input wire:model="businessRegistration.business_tole" type="text"
                                        class="form-control" id="business_tole"
                                        placeholder="{{ __('businessregistration::businessregistration.placeholder_tole') }}">
                                </div>

                                <!-- Street -->
                                <div class="col-md-4">
                                    <label for="business_street" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.street') }}
                                    </label>
                                    <input wire:model="businessRegistration.business_street" type="text"
                                        class="form-control" id="business_street"
                                        placeholder="{{ __('businessregistration::businessregistration.placeholder_street') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top border-light">
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
                    <div class="tab-pane fade {{ $activeTab === 'type' ? 'show active' : '' }}" id="type"
                        role="tabpanel">
                        <div class="card-body p-1">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="registration_type_id" class="form-label-peaceful">
                                        {{ __('businessregistration::businessregistration.select_registration_type') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select wire:model.live="businessRegistration.registration_type_id"
                                        class="form-control @error('businessRegistration.registration_type_id') is-invalid @enderror"
                                        id="registration_type_id" aria-label="Registration Type"
                                        wire:change.live="setFields($event.target.value)">
                                        <option value="">
                                            {{ __('businessregistration::businessregistration.select_registration_type') }}
                                        </option>
                                        @foreach ($registrationTypes as $id => $value)
                                            <option value="{{ $id }}">{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('businessRegistration.registration_type_id')
                                        <div class="invalid-message">
                                            {{ $errors->first('businessRegistration.registration_type_id') }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div wire:key="registration-type-{{ $registrationTypeEnum }}">
                                @if ($registrationTypeEnum == RegistrationCategoryEnum::BUSINESS->value)


                                    <div class="divider divider-primary text-start text-primary mb-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.capital_details') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <!-- Capital Investment -->
                                        <div class="col-md-6">
                                            <label for="capital_investment" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.capital_investment') }}
                                            </label>
                                            <input wire:model="businessRegistration.capital_investment"
                                                name="capital_investment" type="text" class="form-control"
                                                id="capital_investment"
                                                placeholder="{{ __('businessregistration::businessregistration.placeholder_capital_investment') }}">
                                        </div>
                                        <!-- Working Capital -->
                                        <div class="col-md-6">
                                            <label for="working_capital" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.working_capital') }}
                                            </label>
                                            <input wire:model="businessRegistration.working_capital"
                                                name="working_capital" type="text" class="form-control"
                                                id="working_capital"
                                                placeholder="{{ __('businessregistration::businessregistration.placeholder_working_capital') }}">
                                        </div>
                                        <!-- Fixed Capital -->
                                        <div class="col-md-6">
                                            <label for="fixed_capital" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.fixed_capital') }}
                                            </label>
                                            <input wire:model="businessRegistration.fixed_capital"
                                                name="fixed_capital" type="text" class="form-control"
                                                id="fixed_capital"
                                                placeholder="{{ __('businessregistration::businessregistration.placeholder_fixed_capital') }}">
                                        </div>
                                        <!-- Operation Date -->
                                        <div class="col-md-6">
                                            <label for="operation_date" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.operation_date') }}
                                            </label>
                                            <input wire:model="businessRegistration.operation_date"
                                                name="operation_date" type="text" class="form-control nepali-date"
                                                id="operation_date"
                                                placeholder="{{ __('businessregistration::businessregistration.placeholder_operation_date') }}">
                                        </div>
                                        <!-- Area -->
                                        <div class="col-md-6">
                                            <label for="area" class="form-label-peaceful">
                                                {{ __('businessregistration::businessregistration.area') }}
                                            </label>
                                            <input wire:model="businessRegistration.business_area"
                                                name="business_area" type="text" class="form-control"
                                                id="business_area"
                                                placeholder="{{ __('businessregistration::businessregistration.placeholder_area') }}">
                                        </div>
                                    </div>





                                    <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.land/house_owner_details') }}
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="form-label-peaceful d-block">
                                                {{ __('businessregistration::businessregistration.is_rented') }}
                                            </label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="is_rented_yes"
                                                        name="is_rented" wire:model="businessRegistration.is_rented"
                                                        value="1"
                                                        wire:change="rentStatusChanged($event.target.value)">
                                                    <label class="form-check-label"
                                                        for="is_rented_yes">{{ __('businessregistration::businessregistration.yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="is_rented_no"
                                                        name="is_rented" wire:model="businessRegistration.is_rented"
                                                        value="0"
                                                        wire:change="rentStatusChanged($event.target.value)">
                                                    <label class="form-check-label"
                                                        for="is_rented_no">{{ __('businessregistration::businessregistration.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($showRentFields)


                                            <!-- House Owner Name -->
                                            <div class="col-md-6">
                                                <label for="houseownername" class="form-label-peaceful">
                                                    {{ __('businessregistration::businessregistration.houseownername') }}
                                                </label>
                                                <input wire:model="businessRegistration.houseownername"
                                                    name="houseownername" type="text" class="form-control"
                                                    id="houseownername"
                                                    placeholder="{{ __('businessregistration::businessregistration.placeholder_houseownername') }}">
                                            </div>
                                            <!-- Phone -->
                                            <div class="col-md-6">
                                                <label for="business_phone" class="form-label-peaceful">
                                                    {{ __('businessregistration::businessregistration.land/house_owner_phone') }}
                                                </label>
                                                <input wire:model="businessRegistration.house_owner_phone"
                                                    name="text" type="text" class="form-control"
                                                    id="business_phone"
                                                    placeholder="{{ __('businessregistration::businessregistration.placeholder_land/house_owner_phone') }}">
                                            </div>
                                            <!-- Monthly Rent -->
                                            <div class="col-md-6">
                                                <label for="monthly_rent" class="form-label-peaceful">
                                                    {{ __('businessregistration::businessregistration.monthly_rent') }}
                                                </label>
                                                <input wire:model="businessRegistration.monthly_rent"
                                                    name="monthly_rent" type="text" class="form-control"
                                                    id="monthly_rent"
                                                    placeholder="{{ __('businessregistration::businessregistration.placeholder_monthly_rent') }}">
                                            </div>
                                            <!-- Rent Agreement File -->
                                            <div class="col-md-6">
                                                <label for="rentagreement" class="form-label-peaceful">
                                                    {{ __('businessregistration::businessregistration.rentagreement') }}
                                                </label>
                                                <input wire:model="rentagreement" name="rentagreement" type="file"
                                                    class="form-control" id="rentagreement">
                                                <div wire:loading wire:target="rentagreement">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    Uploading...
                                                </div>

                                                @if ($rentagreement_url)
                                                    <a href="{{ $rentagreement_url }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary mt-2">
                                                        <i class="bx bx-file"></i>
                                                        {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                @endif
                            </div>

                            @if ($registrationTypeEnum == RegistrationCategoryEnum::FIRM->value)
                                <div class="divider divider-primary text-start text-primary mb-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.operation_details') }}
                                    </div>
                                </div>
                                <div class="row g-4">

                                    <!-- Capital Investment -->

                                    <div class="col-md-6">
                                        <label for="capital_investment" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.capital_investment') }}
                                        </label>
                                        <input wire:model="businessRegistration.capital_investment"
                                            name="capital_investment" type="text" class="form-control"
                                            id="capital_investment"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_capital_investment') }}">
                                    </div>
                                    <!-- Operation Date -->
                                    <div class="col-md-6">
                                        <label for="operation_date" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.operation_date') }}
                                        </label>
                                        <input wire:model="businessRegistration.operation_date" name="operation_date"
                                            type="text" class="form-control nepali-date" id="operation_date"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_operation_date') }}">
                                    </div>
                                </div>
                                <div class="divider divider-primary text-start text-primary mb-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.land_details') }}
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <!-- House Owner Name -->
                                    <div class="col-md-6">
                                        <label for="firm_houseownername" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.houseownername') }}
                                        </label>
                                        <input wire:model="businessRegistration.houseownername" name="houseownername"
                                            type="text" class="form-control" id="firm_houseownername"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_houseownername') }}">
                                    </div>
                                    <!-- East -->
                                    <div class="col-md-6">
                                        <label for="east" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.east') }}
                                        </label>
                                        <input wire:model="businessRegistration.east" name="east" type="text"
                                            class="form-control" id="east"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_east') }}">
                                    </div>
                                    <!-- West -->
                                    <div class="col-md-6">
                                        <label for="west" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.west') }}
                                        </label>
                                        <input wire:model="businessRegistration.west" name="west" type="text"
                                            class="form-control" id="west"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_west') }}">
                                    </div>
                                    <!-- North -->
                                    <div class="col-md-6">
                                        <label for="north" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.north') }}
                                        </label>
                                        <input wire:model="businessRegistration.north" name="north" type="text"
                                            class="form-control" id="north"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_north') }}">
                                    </div>
                                    <!-- South -->
                                    <div class="col-md-6">
                                        <label for="south" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.south') }}
                                        </label>
                                        <input wire:model="businessRegistration.south" name="south" type="text"
                                            class="form-control" id="south"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_south') }}">
                                    </div>
                                    <!-- Land Plot Number -->
                                    <div class="col-md-6">
                                        <label for="landplotnumber" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.landplotnumber') }}
                                        </label>
                                        <input wire:model="businessRegistration.landplotnumber" name="landplotnumber"
                                            type="text" class="form-control" id="landplotnumber"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_landplotnumber') }}">
                                    </div>
                                    <!-- Area -->
                                    <div class="col-md-6">
                                        <label for="area" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.area') }}
                                        </label>
                                        <input wire:model="businessRegistration.area" name="area" type="text"
                                            class="form-control" id="area"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_area') }}">
                                    </div>
                                </div>
                            @endif
                            @if ($registrationTypeEnum == RegistrationCategoryEnum::INDUSTRY->value)
                                <div class="divider divider-primary text-start text-primary mb-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.operation_details') }}
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <!-- Capital Investment -->
                                    <div class="col-md-6">
                                        <label for="capital_investment" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.capital_investment') }}
                                        </label>
                                        <input wire:model="businessRegistration.capital_investment"
                                            name="capital_investment" type="text" class="form-control"
                                            id="capital_investment"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_capital_investment') }}">
                                    </div>
                                    <!-- Fixed Capital -->
                                    <div class="col-md-6">
                                        <label for="fixed_capital" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.fixed_capital') }}
                                        </label>
                                        <input wire:model="businessRegistration.fixed_capital" name="fixed_capital"
                                            type="text" class="form-control" id="fixed_capital"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_fixed_capital') }}">
                                    </div>
                                    <!-- Working Capital -->
                                    <div class="col-md-6">
                                        <label for="working_capital" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.working_capital') }}
                                        </label>
                                        <input wire:model="businessRegistration.working_capital"
                                            name="working_capital" type="text" class="form-control"
                                            id="working_capital"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_working_capital') }}">
                                    </div>
                                    <!-- Total Capacity -->
                                    <div class="col-md-6">
                                        <label for="production_capacity" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.production_capacity') }}
                                        </label>
                                        <input wire:model="businessRegistration.production_capacity"
                                            name="production_capacity" type="text" class="form-control"
                                            id="production_capacity"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_production_capacity') }}">
                                    </div>

                                    <!-- Required Manpower -->
                                    <div class="col-md-6">
                                        <label for="required_manpower" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.required_manpower') }}
                                        </label>
                                        <input wire:model="businessRegistration.required_manpower"
                                            name="required_manpower" type="text" class="form-control"
                                            id="required_manpower"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_required_manpower') }}">
                                    </div>
                                    <!-- Required electric power -->
                                    <div class="col-md-6">
                                        <label for="required_electric_power" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.required_electric_power') }}
                                        </label>
                                        <input wire:model="businessRegistration.required_electric_power"
                                            name="required_electric_power" type="text" class="form-control"
                                            id="required_electric_power"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_required_electric_power') }}">
                                    </div>
                                    <!-- Number of Shifts for Industry Operation -->
                                    <div class="col-md-6">
                                        <label for="number_of_shifts" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.number_of_shifts') }}
                                        </label>
                                        <input wire:model="businessRegistration.number_of_shifts"
                                            name="number_of_shifts" type="text" class="form-control"
                                            id="number_of_shifts"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_number_of_shifts') }}">
                                    </div>
                                    <!-- Operation Date -->
                                    <div class="col-md-6">
                                        <label for="operation_date" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.operation_starting_date') }}
                                        </label>
                                        <input wire:model="businessRegistration.operation_date" name="operation_date"
                                            type="text" class="form-control nepali-date" id="operation_date"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_operation_date') }}">
                                    </div>
                                    <!-- industry total running day -->
                                    <div class="col-md-6">
                                        <label for="total_running_day" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.industry_total_running_day') }}
                                        </label>
                                        <input wire:model="businessRegistration.total_running_day"
                                            name="total_running_day" type="text" class="form-control nepali-date"
                                            id="total_running_day"
                                            placeholder="{{ __('businessregistration::businessregistration.industry_total_running_day') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="others" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.others') }}
                                        </label>
                                        <input wire:model="businessRegistration.others" name="others" type="text"
                                            class="form-control nepali-date" id="others"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_others') }}">
                                    </div>
                                </div>
                            @endif
                            @if ($registrationTypeEnum == RegistrationCategoryEnum::ORGANIZATION->value)
                                <div class="divider divider-primary text-start text-primary mb-4">
                                    <div class="divider-text fw-bold fs-6">
                                        {{ __('businessregistration::businessregistration.operation_details') }}
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <!-- Financial Source -->
                                    <div class="col-md-6">
                                        <label for="financial_source" class="form-label-peaceful">
                                            {{ __('businessregistration::businessregistration.financial_source') }}
                                        </label>
                                        <input wire:model="businessRegistration.financial_source"
                                            name="financial_source" type="text" class="form-control"
                                            id="financial_source"
                                            placeholder="{{ __('businessregistration::businessregistration.placeholder_financial_source') }}">
                                    </div>
                                </div>
                                <div class="row g-4 mt-3">
                                    <div class="divider divider-primary text-start text-primary mb-4">
                                        <div class="divider-text fw-bold fs-6">
                                            {{ __('businessregistration::businessregistration.add_organization_members_position') }}
                                        </div>
                                    </div>
                                    <div class="col-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('businessregistration::businessregistration.name') }}
                                                        </th>
                                                        <th>{{ __('businessregistration::businessregistration.address') }}
                                                        </th>
                                                        <th>{{ __('businessregistration::businessregistration.phone_number') }}
                                                        </th>
                                                        <th>{{ __('businessregistration::businessregistration.position') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($personalDetails as $index => $detail)
                                                        <tr>
                                                            <td>{{ $detail['applicant_name'] }}</td>
                                                            <td>
                                                                {{ $detail['applicant_province'] ? $provinces[$detail['applicant_province']] ?? '' : '' }}
                                                                {{ $detail['applicant_district'] ? ', ' . ($applicantDistricts[$index][$detail['applicant_district']] ?? '') : '' }}
                                                                {{ $detail['applicant_local_body'] ? ', ' . ($applicantLocalBodies[$index][$detail['applicant_local_body']] ?? '') : '' }}
                                                                {{ $detail['applicant_ward'] ? ', ' . ($applicantWards[$index][$detail['applicant_ward']] ?? '') : '' }}
                                                                {{ $detail['applicant_tole'] ? ', ' . $detail['applicant_tole'] : '' }}
                                                                {{ $detail['applicant_street'] ? ', ' . $detail['applicant_street'] : '' }}
                                                            </td>
                                                            <td>{{ $detail['phone'] }}</td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    wire:model="personalDetails.{{ $index }}.position"
                                                                    placeholder="{{ __('businessregistration::businessregistration.position') }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="divider divider-primary text-start text-primary mb-4 mt-4">
                            <div class="divider-text fw-bold fs-6">
                                {{ __('businessregistration::businessregistration.required_documents') }}
                            </div>
                        </div>
                        <div class="row g-4">
                            @foreach ($requiredBusinessDocuments as $field => $label)
                                <div class="col-md-6">
                                    <label class="form-label-peaceful">{{ $label['ne'] }}</label>
                                    <input type="file" wire:model="businessRequiredDoc.{{ $field }}"
                                        class="form-control" id="{{ $field }}">
                                    <div wire:loading wire:target="businessRequiredDoc.{{ $field }}">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        {{ __('businessregistration::businessregistration.uploading') }}
                                    </div>

                                    @php
                                        $urlProp = $field . '_url';
                                    @endphp

                                    @if (!empty($businessRequiredDocUrl[$urlProp]))
                                        <a href="{{ $businessRequiredDocUrl[$urlProp] }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="bx bx-file"></i>
                                            {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                        </a>
                                    @endif

                                </div>
                            @endforeach
                        </div>

                        <div>
                            <div id="dynamic-form">
                                <div class="row">
                                    @if (!empty($data))
                                        <div class="divider divider-primary text-start text-primary mb-4">
                                            <div class="divider-text fw-bold fs-6">
                                                {{ __('businessregistration::businessregistration.additional_information') }}
                                            </div>
                                        </div>
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
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top border-light">
                            <button type="button" class="btn btn-outline-peaceful"
                                wire:click="setActiveTab('business')">
                                <i
                                    class="fas fa-arrow-left me-2"></i>{{ __('businessregistration::businessregistration.previous') }}
                            </button>

                            <div class="step-indicator">
                                <span
                                    class="badge bg-light text-muted">{{ __('businessregistration::businessregistration.step_3_of_3') }}</span>
                            </div>

                            <button type="submit" class="btn btn-success-peaceful" wire:loading.attr="disabled">
                                <i class="fas fa-check me-2"></i>
                                <span
                                    wire:loading.remove>{{ __('businessregistration::businessregistration.submit_registration') }}</span>
                                <span
                                    wire:loading>{{ __('businessregistration::businessregistration.submitting') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>




@script
    <script>
        $(document).ready(function() {

            const natureSelect = $('#business_nature');
            natureSelect.select2();
            natureSelect.on('change', function() {
                @this.set('businessRegistration.business_nature', $(this).val());
            });

            const departmentSelect = $('#department_id');
            departmentSelect.select2();
            departmentSelect.on('change', function() {
                @this.set('businessRegistration.department_id', $(this).val());
            });



            // Function to initialize Nepali date pickers
            function initNepaliDatePickers() {
                console.log('Initializing Nepali date pickers...');
                document.querySelectorAll('.nepali-date').forEach(input => {

                    if (!input || typeof input.nepaliDatePicker !== 'function') return;

                    // Preserve current value
                    const currentValue = input.value;

                    // Destroy existing picker if present
                    if (input._nepaliDatePicker) {
                        try {
                            input._nepaliDatePicker.destroy();
                        } catch (_) {}
                    }

                    // Initialize picker
                    try {
                        input.nepaliDatePicker({
                            language: "ne",
                            ndpYear: true,
                            ndpMonth: true,
                            unicodeDate: true,
                            onChange: () => {
                                input.dispatchEvent(new Event('input', {
                                    bubbles: true
                                }));
                            }
                        });

                        // Restore previous value
                        input.value = currentValue;

                    } catch (error) {
                        console.error('Nepali date picker init failed for', input.id || input.name, error);
                    }
                });
            }

            // Function to set up Livewire listeners
            function setupLivewireListeners() {


                initNepaliDatePickers();

                if (typeof Livewire !== 'undefined') {
                    Livewire.on('init-registration-date', () => {
                        setTimeout(() => {
                            initNepaliDatePickers();
                        }, 100);
                    });


                    Livewire.hook('message.processed', () => {

                        setTimeout(() => {
                            initNepaliDatePickers();
                        }, 100);
                    });


                } else {
                    setTimeout(setupLivewireListeners, 500);
                }
            }

            // Try to set up listeners immediately
            setupLivewireListeners();

            // Also try the event listener approach
            document.addEventListener('livewire:initialized', () => {
                setupLivewireListeners();
            });


        });
    </script>
@endscript
