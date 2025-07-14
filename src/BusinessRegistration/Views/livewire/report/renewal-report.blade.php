<form wire:submit.prevent="search">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('businessregistration::businessregistration.registered_business_report') }}
        </h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click = "export" class="btn btn-outline-primary btn-sm">
                {{ __('businessregistration::businessregistration.export') }}
            </button>
            <button type="button" wire:click = "downloadPdf" class="btn btn-outline-primary btn-sm">
                {{ __('businessregistration::businessregistration.pdf') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('Search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Input Fields -->

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.start_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="startDate" id="start_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('businessregistration::businessregistration.start_date') }}">
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.end_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="endDate" id="end_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('businessregistration::businessregistration.end_date') }}">
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.business_category') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedCategory">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($categories as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.business_nature') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedNature">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($natures as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.business_type') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedType">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($types as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-items-center mt-3">
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.ward') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedWard">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($wards as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.application_status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select"
                                wire:model="selectedApplicationStatus">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($applicationStatus as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('businessregistration::businessregistration.business_status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select"
                                wire:model="selectedBusinessStatus">
                                <option value="">
                                    {{ __('businessregistration::businessregistration.select_an_option') }}</option>
                                @foreach ($businessStatus as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">


                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                            wire:target="search">
                            <span wire:loading wire:target="search">
                                <i class="bx bx-loader bx-spin me-1"></i>
                            </span>
                            <span wire:loading.remove wire:target="search">
                                <i class="bx bx-search me-1"></i>
                                {{ __('businessregistration::businessregistration.search') }}
                            </span>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i>
                            {{ __('businessregistration::businessregistration.clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($renewalBusinessData && $renewalBusinessData->count())
        <div class="container mt-4">
            <div class="card shadow table-responsive" id="printContent">
                <table class="table table-bordered table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>क्र.स.</th>
                            <th>दर्ता नं</th>
                            <th>संस्था/फर्मको नाम</th>
                            <th>संस्था/फर्मको ठेगाना</th>
                            <th>संस्था/फर्मको प्रकार</th>
                            <th>व्यवसायीको नाम</th>
                            <th>समपर्क न‌</th>
                            <th>संस्थापकको ठेगाना</th>
                            <th>दर्ता मिती </th>
                            <th>पछिल्लो नविकरण मिति</th>
                            <th>नविकरण रकम</th>
                            <th>जरिवाना रकम</th>
                            <th>रसिद नं</th>
                            <th>रसिद मिति</th>
                            <th>स्थिति</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $businessNumber = 1; @endphp
                        @foreach ($renewalBusinessData as $data)
                            @if ($data->registration && $data->registration->applicants->count() > 0)
                                @foreach ($data->registration->applicants as $index => $applicant)
                                    <tr>
                                        <td>
                                            @if ($index == 0)
                                                {{ replaceNumbers($businessNumber, true) }}
                                            @else
                                                {{ replaceNumbers($businessNumber, true) }}.{{ replaceNumbers($index, true) }}
                                            @endif
                                        </td>
                                        <td>{{ replaceNumbers($data->registration_no, true) }}</td>
                                        <td>{{ $data->registration->entity_name }}</td>
                                        <td>
                                            @php
                                                $businessAddress = collect([
                                                    $data->registration->businessProvince->title ?? null,
                                                    $data->registration->businessDistrict->title ?? null,
                                                    $data->registration->businessLocalBody->title ?? null,
                                                    $data->registration->business_ward
                                                        ? 'वडा नं. ' . $data->registration->business_ward
                                                        : null,
                                                    $data->registration->business_tole ?? null,
                                                    $data->registration->business_street ?? null,
                                                ])
                                                    ->filter()
                                                    ->implode(', ');
                                            @endphp
                                            {{ $businessAddress }}
                                        </td>
                                        <td>{{ $data->registration->registrationType->registrationCategory->title_ne ?? '' }}
                                        </td>
                                        <td>{{ $applicant->applicant_name ?? '' }}</td>
                                        <td>{{ $applicant->phone ?? '' }}</td>
                                        <td>
                                            @php
                                                $applicantAddress = collect([
                                                    $applicant->applicantProvince->title ?? null,
                                                    $applicant->applicantDistrict->title ?? null,
                                                    $applicant->applicantLocalBody->title ?? null,
                                                    $applicant->applicant_ward
                                                        ? 'वडा नं. ' . $applicant->applicant_ward
                                                        : null,
                                                    $applicant->applicant_tole ?? null,
                                                    $applicant->applicant_street ?? null,
                                                ])
                                                    ->filter()
                                                    ->implode(', ');
                                            @endphp
                                            {{ $applicantAddress }}
                                        </td>
                                        <td>{{ replaceNumbers($data->renew_date, true) }}</td>
                                        <td>{{ replaceNumbers($data->date_to_be_maintained, true) }}</td>
                                        <td>{{ replaceNumbers($data->renew_amount, true) }}</td>
                                        <td>{{ replaceNumbers($data->penalty_amount, true) }}</td>
                                        <td>{{ replaceNumbers($data->bill_no, true) }}</td>
                                        <td>{{ replaceNumbers($data->payment_receipt_date, true) }}</td>
                                        <td>{{ Src\BusinessRegistration\Enums\ApplicationStatusEnum::getNepaliLabel($data->application_status) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @php $businessNumber++; @endphp
                            @else
                                <tr>
                                    <td>{{ replaceNumbers($businessNumber, true) }}</td>
                                    <td>{{ replaceNumbers($data->registration_no, true) }}</td>
                                    <td>{{ $data->registration->entity_name ?? '' }}</td>
                                    <td>
                                        @php
                                            $businessAddress = collect([
                                                $data->registration->businessProvince->title ?? null,
                                                $data->registration->businessDistrict->title ?? null,
                                                $data->registration->businessLocalBody->title ?? null,
                                                $data->registration->business_ward
                                                    ? 'वडा नं. ' . $data->registration->business_ward
                                                    : null,
                                                $data->registration->business_tole ?? null,
                                                $data->registration->business_street ?? null,
                                            ])
                                                ->filter()
                                                ->implode(', ');
                                        @endphp
                                        {{ $businessAddress }}
                                    </td>
                                    <td>{{ $data->registration->registrationType->registrationCategory->title_ne ?? '' }}
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{ replaceNumbers($data->renew_date, true) }}</td>
                                    <td>{{ replaceNumbers($data->date_to_be_maintained, true) }}</td>
                                    <td>{{ replaceNumbers($data->renew_amount, true) }}</td>
                                    <td>{{ replaceNumbers($data->penalty_amount, true) }}</td>
                                    <td>{{ replaceNumbers($data->bill_no, true) }}</td>
                                    <td>{{ replaceNumbers($data->payment_receipt_date, true) }}</td>
                                    <td>{{ Src\BusinessRegistration\Enums\ApplicationStatusEnum::getNepaliLabel($data->application_status) }}
                                    </td>
                                </tr>
                                @php $businessNumber++; @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="container mt-4">
            <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                style="min-height: 200px;">
                <h5 class="text-center">{{ __('No Data To Show') }}</h5>

                @error('startDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror

                @error('endDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror
            </div>
        </div>
    @endif

</form>
