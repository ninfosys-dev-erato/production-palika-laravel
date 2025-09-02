@push('styles')
    <link rel="stylesheet" href="{{ asset('home') }}/businessstyle.css">
@endpush


<div class="my-3">
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
            <span class="nav-text">{{ __('businessregistration::businessregistration.registration_detail') }}</span>
            <div class="nav-indicator"></div>
        </button>

    </div>

    <div class="card border-0 shadow-xl bg-white-translucent">
        <div class="tab-content">
            <!-- Personal Details Tab -->
            <div class="tab-pane fade {{ $activeTab === 'personal' ? 'show active' : '' }}" id="personal"
                role="tabpanel">

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
                                <input wire:model="personalDetails.{{ $index }}.father_name" name="father_name"
                                    type="text"
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
                                <label for="citizenship_issued_date_{{ $index }}" class="form-label-peaceful">
                                    {{ __('businessregistration::businessregistration.issuance_date') }}
                                </label>
                                <input wire:model="personalDetails.{{ $index }}.citizenship_issued_date"
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
                                <select wire:model="personalDetails.{{ $index }}.citizenship_issued_district"
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
                                <label for="citizenship_front_{{ $index }}" class="form-label-peaceful">
                                    {{ __('businessregistration::businessregistration.upload_citizenship_front') }}
                                </label>
                                <input wire:model="personalDetails.{{ $index }}.citizenship_front"
                                    type="file" class="form-control" id="citizenship_front_{{ $index }}"
                                    accept="image/*">
                                <div wire:loading wire:target="personalDetails.{{ $index }}.citizenship_front">
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
                                <label for="citizenship_rear_{{ $index }}" class="form-label-peaceful">
                                    {{ __('businessregistration::businessregistration.upload_citizenship_rear') }}
                                </label>
                                <input wire:model="personalDetails.{{ $index }}.citizenship_rear"
                                    type="file" class="form-control" id="citizenship_rear_{{ $index }}"
                                    accept="image/*">
                                <div wire:loading wire:target="personalDetails.{{ $index }}.citizenship_rear">
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
                                <select wire:model.live="personalDetails.{{ $index }}.applicant_province"
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
                                <select wire:model.live="personalDetails.{{ $index }}.applicant_district"
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
                                <select wire:model.live="personalDetails.{{ $index }}.applicant_local_body"
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
                                <input wire:model="personalDetails.{{ $index }}.applicant_tole" type="text"
                                    class="form-control" id="tole"
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

                    </div>
                    @if (count($personalDetails) > 1)
                        <div class="d-flex justify-content-start mb-2 mt-2">
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="removePersonalDetail({{ $index }})">
                                <i class="fas fa-trash me-1"></i>
                                {{ __('businessregistration::businessregistration.remove_personal_info') }}
                            </button>
                        </div>
                    @endif
                    <div class="d-flex justify-content-start mb-2 mt-2">
                        <button type="button" class="btn btn-outline-primary" wire:click="addPersonalDetail">
                            <i class="fas fa-plus me-1"></i>
                            {{ __('businessregistration::businessregistration.add_new_personal_info') }}
                        </button>
                    </div>
                @endforeach
            </div>





            <div class="tab-pane fade {{ $activeTab === 'business' ? 'show active' : '' }}" id="business"
                role="tabpanel">



            </div>
        </div>

    </div>

</div>
