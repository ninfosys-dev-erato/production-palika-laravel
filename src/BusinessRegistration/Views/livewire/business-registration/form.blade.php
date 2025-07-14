<form wire:submit.prevent="save" enctype="multipart/form-data">
    @csrf

    @if ($businessRegistrationType == \Src\BusinessRegistration\Enums\BusinessRegistrationType::DEREGISTRATION)
        <div class="mb-4">
            <label for="phone"
                class="form-label fw-bold fs-7 d-block">{{ __('businessregistration::businessregistration.search_by_company_name') }}</label>
            <div class="input-group">
                <input type="text" class="form-control" id="name" wire:model.defer="search"
                    placeholder={{ __('Enter company name') }}>
                <button class="btn btn-outline-primary" type="button" wire:click.prevent="search"
                    wire:click="searchBusiness">
                    {{ __('Search') }}
                </button>
            </div>
            @error('phone')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        </div>
    @endif

    @if ($showData)
        <div class="divider divider-primary text-start text-primary font-14">
            <h5 class="divider-text ">{{ __('businessregistration::businessregistration.primary_detail') }}</h5>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="fiscal_year_id"
                                class="form-label">{{ __('businessregistration::businessregistration.fiscal_year') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-fiscal_year_id-field"
                                wire:model="businessRegistration.fiscal_year_id" name="fiscal_year_id"
                                class="form-select" id="fiscal_year_id" disabled>
                                <option>{{ __('businessregistration::businessregistration.select_fiscal_year') }}
                                </option>
                                @foreach ($fiscalYears as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('fiscal_year_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="application_date">{{ __('businessregistration::businessregistration.application_date') }}</label>
                        <span class="text-danger">*</span>
                        <input dusk="businessregistration-businessRegistration.application_date-field" type="text"
                            name="businessRegistration.application_date" id="application_date"
                            class="nepali-date form-control {{ $errors->has('businessRegistration.application_date') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('businessRegistration.application_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:model="businessRegistration.application_date"
                            placeholder="{{ __('businessregistration::businessregistration.select_date') }}"
                            {{ $this->isReadonly ? 'readonly' : '' }} />

                        @error('businessRegistration.application_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="entity_name"
                                class="form-label">{{ __('Business | Organization | Industry Name') }}</label>
                            <span class="text-danger">*</span>
                            <input dusk="businessregistration-entity_name-field"
                                wire:model="businessRegistration.entity_name" name="entity_name" type="text"
                                class="form-control {{ $errors->has('businessRegistration.entity_name') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.entity_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                placeholder="{{ __('Business | Organization | Industry Name') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }} />
                            <div>
                                @error('businessRegistration.entity_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="Applicant Name"
                                class="form-label">{{ __('businessregistration::businessregistration.applicant_name') }}</label>
                            <span class="text-danger">*</span>
                            <input dusk="businessregistration-applicant_name-field"
                                wire:model="businessRegistration.applicant_name" name="applicant_name" type="text"
                                class="form-control" placeholder="{{ __('Enter applicant name') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }}>
                            <div>
                                @error('businessRegistration.applicant_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="Applicant Name"
                                class="form-label">{{ __('businessregistration::businessregistration.applicant_number') }}</label>
                            <span class="text-danger">*</span>
                            <input dusk="businessregistration-applicant_number-field"
                                wire:model="businessRegistration.applicant_number" name="applicant_number"
                                type="number" class="form-control" placeholder="{{ __('Enter applicant number') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }}>
                            <div>
                                @error('businessRegistration.applicant_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="mobile_no"
                                class="form-label">{{ __('Business | Organization | Industry Contact Info') }}</label>
                            <input dusk="businessregistration-mobile_no-field"
                                wire:model="businessRegistration.mobile_no" name="mobile_no" type="tel"
                                class="form-control"
                                placeholder="{{ __('Business | Organization | Industry Contact Info') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }}>
                            <div>
                                @error('businessRegistration.mobile_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3" wire:ignore>
                        <div class="form-group">
                            <label for="business_nature"
                                class="form-label">{{ __('businessregistration::businessregistration.select_nature') }}</label>
                            <select dusk="businessregistration-business_nature-field"
                                wire:model.live="businessRegistration.business_nature" id="business_nature"
                                class="form-control {{ $errors->has('businessRegistration.business_nature') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.business_nature') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                {{ $this->isReadonly ? 'disabled' : '' }}>
                                <option>{{ __('businessregistration::businessregistration.select_business_nature') }}
                                </option>
                                @foreach ($businessNatures as $label => $value)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.business_nature')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6 mb-3" wire:ignore>
                        <div class="form-group">
                            <label for="department_id"
                                class="form-label">{{ __('businessregistration::businessregistration.select_department') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-department_id-field"
                                wire:model.live="businessRegistration.department_id" id="department_id" required
                                class="form-control {{ $errors->has('businessRegistration.department_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.department_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                {{ $this->isReadonly ? 'disabled' : '' }}>
                                <option>{{ __('businessregistration::businessregistration.select_department') }}
                                </option>
                                @foreach ($departments as $label => $value)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.department_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div> --}}


                    <div class="divider divider-primary text-start text-primary font-14">
                        <h5 class="divider-text ">
                            {{ __('businessregistration::businessregistration.business_address_details') }}
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="province_id"
                                class="form-label">{{ __('businessregistration::businessregistration.province') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-province_id-field"
                                wire:model.live="businessRegistration.province_id" name="province_id"
                                wire:change="getDistricts"
                                class="form-control {{ $errors->has('businessRegistration.province_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                {{ $this->isReadonly ? 'disabled' : '' }}>
                                >
                                <option value="" selected hidden>
                                    {{ __('businessregistration::businessregistration.select_province') }}</option>
                                <!-- Placeholder -->
                                @foreach ($provinces as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.province_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="district_id"
                                class="form-label">{{ __('businessregistration::businessregistration.district') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-district_id-field"
                                wire:model.live="businessRegistration.district_id" name="district_id"
                                wire:change="getLocalBodies"
                                class="form-control {{ $errors->has('businessRegistration.local_body_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                {{ $this->isReadonly ? 'disabled' : '' }}>

                                <option value="" selected hidden>
                                    {{ __('businessregistration::businessregistration.select_district') }}</option>
                                @foreach ($districts as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.district_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="local_body_id"
                                class="form-label">{{ __('businessregistration::businessregistration.local_body') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-local_body_id-field"
                                wire:model.live="businessRegistration.local_body_id" name="local_body_id"
                                class="form-control {{ $errors->has('businessRegistration.local_body_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:change="getWards" {{ $this->isReadonly ? 'disabled' : '' }}>
                                <option value="" selected hidden>
                                    {{ __('businessregistration::businessregistration.select_local_body') }}</option>
                                @foreach ($localBodies as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.local_body_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="ward_no"
                                class="form-label">{{ __('businessregistration::businessregistration.ward') }}</label>
                            <span class="text-danger">*</span>
                            <select dusk="businessregistration-ward_no-field"
                                wire:model.live="businessRegistration.ward_no" name="ward_no"
                                class="form-control {{ $errors->has('businessRegistration.ward_no') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('businessRegistration.ward_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                {{ $this->isReadonly ? 'disabled' : '' }}>
                                <option value="" selected hidden>
                                    {{ __('businessregistration::businessregistration.select_ward') }}</option>
                                @foreach ($wards as $id => $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('businessRegistration.ward_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="tole"
                                class="form-label">{{ __('businessregistration::businessregistration.enter_tole') }}</label>
                            <input dusk="businessregistration-tole-field" wire:model="businessRegistration.tole"
                                name="tole" type="text" class="form-control"
                                placeholder="{{ __('businessregistration::businessregistration.enter_tole') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }}>
                            <div>
                                @error('businessRegistration.tole')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="way"
                                class="form-label">{{ __('businessregistration::businessregistration.enter_street') }}</label>
                            <input dusk="businessregistration-way-field" wire:model="businessRegistration.way"
                                name="way" type="text" class="form-control"
                                placeholder="{{ __('businessregistration::businessregistration.enter_street') }}"
                                {{ $this->isReadonly ? 'readonly' : '' }}>
                            <div>
                                @error('businessRegistration.way')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider divider-primary text-start text-primary">
            <h5 class="divider-text ">{{ __('Business | Organization | Industry Detail') }}</h5>
        </div>
        <div class="card mb-4">

            <div class="card-body">
                <div class="row">
                    @if ($showCategory && $action != App\Enums\Action::UPDATE)
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label
                                    class="form-label">{{ __('businessregistration::businessregistration.select_registration_category') }}</label>
                                <span class="text-danger">*</span>
                                <select
                                    class="form-select {{ $errors->has('businessRegistration.category_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('businessRegistration.category_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:change.live="getRegistrationTypes($event.target.value)"
                                    wire:model ="registrationCategory">
                                    <option value="" selected hidden>
                                        {{ __('businessregistration::businessregistration.select_registration_category') }}
                                    </option>
                                    @foreach ($registrationCategories as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('businessRegistration.category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="registration_type_id"
                                    class="form-label">{{ __('businessregistration::businessregistration.select_registration_type') }}</label>
                                <span class="text-danger">*</span>
                                <select wire:model.live="businessRegistration.registration_type_id"
                                    class="form-control {{ $errors->has('businessRegistration.registration_type_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('businessRegistration.registration_type_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:change.live="setFields($event.target.value)">
                                    <option>
                                        {{ __('businessregistration::businessregistration.select_registration_type') }}
                                    </option>
                                    @foreach ($registrationTypes as $label => $value)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('businessRegistration.registration_type_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($hasDepartment)

                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="operator_id"
                                    class="form-label">{{ __('businessregistration::businessregistration.select_operator') }}</label>
                                <span class="text-danger">*</span>
                                <select wire:model.live="businessRegistration.operator_id"
                                    class="form-control {{ $errors->has('businessRegistration.operator_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('businessRegistration.operator_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    <option>{{ __('businessregistration::businessregistration.select_operator') }}
                                    </option>
                                    @foreach ($departmentUser as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>

                                <div>
                                    @error('businessRegistration.operator_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="preparer_id"
                                    class="form-label">{{ __('businessregistration::businessregistration.select_prepare') }}</label>
                                <span class="text-danger">*</span>
                                <select wire:model.live="businessRegistration.preparer_id"
                                    class="form-control {{ $errors->has('businessRegistration.preparer_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('businessRegistration.preparer_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    <option>{{ __('businessregistration::businessregistration.select_prepare') }}
                                    </option>
                                    @foreach ($departmentUser as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('businessRegistration.preparer_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="approver_id"
                                    class="form-label">{{ __('businessregistration::businessregistration.select_approver') }}</label>
                                <span class="text-danger">*</span>
                                <select wire:model.live="businessRegistration.approver_id"
                                    class="form-control {{ $errors->has('businessRegistration.approver_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('businessRegistration.approver_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    <option>{{ __('businessregistration::businessregistration.select_approver') }}
                                    </option>
                                    @foreach ($departmentUser as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('businessRegistration.approver_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="dynamic-form">
                        @if (!empty($data))

                            @foreach ($data as $key => $field)
                                <x-form.field :field="$field" />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif


    <div class="col-12">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('businessregistration::businessregistration.save') }}</button>
        <a href="{{ route('admin.business-registration.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('businessregistration::businessregistration.back') }}</a>
    </div>

</form>


@script
    <script>
        $(document).ready(function() {

            const natureSelect = $('#business_nature');
            natureSelect.select2();

            natureSelect.on('change', function() {
                @this.set('businessRegistration.business_nature', $(this).val());
            })

            const departmentSelect = $('#department_id');
            departmentSelect.select2();

            departmentSelect.on('change', function() {
                @this.set('businessRegistration.department_id', $(this).val());
            })
        })
    </script>
@endscript
