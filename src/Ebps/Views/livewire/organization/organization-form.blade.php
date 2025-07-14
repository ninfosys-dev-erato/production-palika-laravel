<div>
    <div class="overflow-hidden p-2">
        <form wire:submit.prevent="submitFormData">
            @switch($currentStep)
                @case(2)
                    <div>
                        <center>
                            <p style="padding: 10px; color:red;">
                                Note: (*) Please upload file must be in photo and less than 200kb.
                            </p>
                        </center>
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">

                                    <div class="fs-4 fw-bold text-primary mb-3">{{ __('ebps::ebps.company_detail') }}</div>

                                    <div class="mb-3">
                                        <label for="organizationDetail.logo" class="form-label">
                                            कम्पनी लोगो (छापा) <span class="text-danger">*</span>
                                        </label>
                                        <input type="file"
                                            class="form-control {{ $organizationDetail['logo'] ? 'is-valid' : '' }}"
                                            id="organizationDetail.logo" wire:model="organizationDetail.logo" />
                                        @error('organizationDetail.logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="organizationDetail.company_registration_document" class="form-label">
                                            कम्पनी दर्ता प्रमाणपत्र <span class="text-danger">*</span>
                                        </label>
                                        <input type="file"
                                            class="form-control {{ $organizationDetail['company_registration_document'] ? 'is-valid' : '' }}"
                                            id="organizationDetail.company_registration_document"
                                            wire:model="organizationDetail.company_registration_document" />
                                        @error('organizationDetail.company_registration_document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">

                                    <div class="fs-4 fw-bold text-primary mb-3">
                                        {{ __('ebps::ebps.organization_registration_detail') }}</div>

                                    <div class="mb-3">
                                        <label for="organizationDetail.org_registration_date" class="form-label">
                                            व्यवसाय दर्ता मिति (बि.स.) <span class="text-danger">*</span>
                                        </label>
                                        <input name="organizationDetail.org_registration_date" id="org_registration_date"
                                            class="nepali-date form-control @error('organizationDetail.org_registration_date') is-invalid @enderror"
                                            type="text" placeholder="दर्ता मिति (YYYY-MM-DD)"
                                            wire:model="organizationDetail.org_registration_date" />
                                        @error('organizationDetail.org_registration_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="organizationDetail.org_registration_document" class="form-label">
                                            व्यवसाय दर्ता प्रमाणपत्र <span class="text-danger">*</span>
                                        </label>
                                        <input type="file"
                                            class="form-control {{ $organizationDetail['org_registration_document'] ? 'is-valid' : '' }}"
                                            id="organizationDetail.org_registration_document"
                                            wire:model="organizationDetail.org_registration_document" />
                                        @error('organizationDetail.org_registration_document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">

                                    <div class="fs-4 fw-bold text-primary mb-3">{{ __('ebps::ebps.org_pan_registration_date') }}
                                    </div>

                                    <div class="mb-3">
                                        <label for="organizationDetail.org_pan_registration_date" class="form-label">
                                            स्थायी लेखा नं.दर्ता मिति (बि. स.) <span class="text-danger">*</span>
                                        </label>
                                        <input name="organizationDetail.org_pan_registration_date"
                                            id="org_pan_registration_date"
                                            class="form-control @error('organizationDetail.org_pan_registration_date') is-invalid @enderror nepali-date"
                                            type="text" placeholder="दर्ता मिति (YYYY-MM-DD)"
                                            wire:model="organizationDetail.org_pan_registration_date" />
                                        @error('organizationDetail.org_pan_registration_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="organizationDetail.org_pan_document" class="form-label">
                                            स्थायी लेखा नं. प्रमाणपत्र <span class="text-danger">*</span>
                                        </label>
                                        <input type="file"
                                            class="form-control {{ $organizationDetail['org_pan_document'] ? 'is-valid' : '' }}"
                                            id="organizationDetail.org_pan_document"
                                            wire:model="organizationDetail.org_pan_document" />
                                        @error('organizationDetail.org_pan_document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">

                                    <div class="fs-4 fw-bold text-primary mb-3">{{ __('कर चुक्ता ववरण') }}</div>

                                    <div class="mb-3">
                                        <label for="taxClearance.document" class="form-label">
                                            कर चुक्ता प्रमाणपत्र <span class="text-danger">*</span>
                                        </label>
                                        <input type="file"
                                            class="form-control {{ $taxClearance['document'] ? 'is-valid' : '' }}"
                                            id="taxClearance.document" wire:model="taxClearance.document" />
                                        @error('taxClearance.document')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="taxClearance.year" class="form-label">
                                            कर चुक्ता गरेको आर्थिक वर्ष <span class="text-danger">*</span>
                                        </label>
                                        <input name="taxClearance.year"
                                            class="form-control @error('taxClearance.year') is-invalid @enderror" type="text"
                                            id="taxClearance.year" placeholder="(YYYY/YY)कर चुक्ता गरेको आर्थिक वर्ष"
                                            wire:model="taxClearance.year" />
                                        @error('taxClearance.year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="organizationDetail.local_body_registration_no" class="form-label">
                                    व्यवसाय दर्ता नं. <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_registration_no"
                                    class="form-control @error('organizationDetail.local_body_registration_no') is-invalid @enderror"
                                    type="number" id="organizationDetail.local_body_registration_no"
                                    placeholder="पालिका दर्ता नं." wire:model="organizationDetail.local_body_registration_no" />
                                @error('organizationDetail.local_body_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="organizationDetail.local_body_registration_date" class="form-label">
                                    दर्ता मिति (बि. स.) <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_registration_date"
                                    id="local_body_registration_date"
                                    class="form-control @error('organizationDetail.local_body_registration_date') is-invalid @enderror nepali-date"
                                    type="text" placeholder="दर्ता मिति (YYYY-MM-DD)"
                                    wire:model="organizationDetail.local_body_registration_date" />
                                @error('organizationDetail.local_body_registration_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="organizationDetail.local_body_file" class="form-label">
                                    अन्य फाइल (photo,pdf) <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_file"
                                    class="form-control @error('organizationDetail.local_body_file') is-invalid @enderror"
                                    type="file" id="organizationDetail.local_body_file"
                                    wire:model="organizationDetail.local_body_file" />
                                @error('organizationDetail.local_body_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <ul class="list-inline wizard mt-3">
                            <li class="next d-flex justify-content-end">
                                <button type="button" wire:click.prevent="backStep(1)" class="btn btn-info me-2">
                                    <i class="bx bx-arrow-circle-left"></i> पछाडि
                                </button>
                                <button type="button" wire:click.prevent="nextStep(3)" class="btn btn-success">
                                    <i class="bx bx-arrow-circle-right"></i> अर्को
                                </button>
                            </li>
                        </ul>
                    </div>
                @break

                @case(3)
                    <!-- Alert -->
                    <div class="card p-2 alert alert-warning" role="alert">
                        कृपया वैध इमेल, सम्पर्क नम्बर र पासवर्ड प्रविष्ट गर्नुहोस्।
                    </div>

                    <!-- User Form Grid -->
                    <div class="container px-0">
                        <div class="row g-2">

                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="organizationUser.name" class="form-label">
                                    प्रयोगकर्ताको नाम <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" id="organizationUser.name">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input name="organizationUser.name" id="organizationUser.name" type="text"
                                        class="form-control @error('organizationUser.name') is-invalid @enderror"
                                        placeholder="प्रयोगकर्ताको नाम" wire:model="organizationUser.name">
                                </div>
                                @error('organizationUser.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="organizationUser.phone" class="form-label">
                                    सम्पर्क नं. <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" id="organizationUser.phone-icon">
                                        <i class="bx bx-phone"></i>
                                    </span>
                                    <input name="organizationUser.phone" id="organizationUser.phone" type="text"
                                        class="form-control @error('organizationUser.phone') is-invalid @enderror"
                                        placeholder="सम्पर्क नं" wire:model="organizationUser.phone">
                                </div>
                                @error('organizationUser.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <label for="organizationUser.email" class="form-label">
                                    इमेल <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" id="organizationUser.email-icon">
                                        <i class="bx bx-envelope"></i>
                                    </span>
                                    <input name="organizationUser.email" id="organizationUser.email" type="email"
                                        class="form-control @error('organizationUser.email') is-invalid @enderror"
                                        placeholder="इमेल" wire:model="organizationUser.email">
                                </div>
                                @error('organizationUser.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label for="organizationUser.password" class="form-label">
                                    पासवर्ड <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input name="organizationUser.password" id="organizationUser.password" type="password"
                                        class="form-control @error('organizationUser.password') is-invalid @enderror"
                                        placeholder="पासवर्ड" wire:model="organizationUser.password">
                                </div>
                                @error('organizationUser.password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label for="organizationUser.password_confirmation" class="form-label">
                                    पासवर्ड सुनिश्चित <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input name="organizationUser.password_confirmation"
                                        id="organizationUser.password_confirmation" type="password"
                                        class="form-control @error('organizationUser.password_confirmation') is-invalid @enderror"
                                        placeholder="पासवर्ड सुनिश्चित" wire:model="organizationUser.password_confirmation">
                                </div>
                                @error('organizationUser.password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <ul class="list-inline wizard mt-3">
                        <li class="next d-flex justify-content-end">
                            <button type="button" wire:click.prevent="backStep(2)" class="btn btn-info me-2">
                                <i class="bx bx-arrow-circle-left"></i> पछाडि
                            </button>
                            <button type="button" wire:click.prevent="nextStep(4)" class="btn btn-success">
                                <i class="bx bx-arrow-circle-right"></i> अर्को
                            </button>
                        </li>
                    </ul>
                @break

                @case(4)
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-fill mb-3">
                                <li class="nav-item">
                                    <a href="#timeline" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        संस्था/परामर्शदाताको विवरण
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#user" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        प्रयोगकर्ता
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        आवश्यक कागजातहरु
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <div class="tab-pane fade show active" id="timeline">
                                    <table class="table table-sm table-striped table-hover">
                                        <tr>
                                            <td>संस्था/परामर्शदाताको नाम</td>
                                            <td>{{ $organizationDetail['org_name_ne'] }}
                                                ({{ $organizationDetail['org_name_en'] }})</td>
                                        </tr>
                                        <tr>
                                            <td>सम्पर्क नम्बर</td>
                                            <td>{{ $organizationDetail['org_contact'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>इमेल</td>
                                            <td>{{ $organizationDetail['org_email'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>पाना नं.</td>
                                            <td>{{ $organizationDetail['org_pan_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>कम्पानी दर्ता नं.</td>
                                            <td>{{ $organizationDetail['org_registration_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>ठेगाना</td>
                                            <td>
                                                {{ $address['organizationLocalBody']->local_body ?? '' }}
                                                {{ $organizationDetail['ward'] }}
                                                - {{ $organizationDetail['tole'] }},
                                                {{ $address['organizationDistrict']->district ?? '' }},
                                                {{ $address['organizationProvince']->province ?? '' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="user">
                                    <table class="table table-sm table-striped table-hover">
                                        <tr>
                                            <td>प्रयोगकर्ताको नाम</td>
                                            <td>{{ $organizationUser['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>इमेल</td>
                                            <td>{{ $organizationUser['email'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>सम्पर्क नं</td>
                                            <td>{{ $organizationUser['phone'] }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="settings">
                                    <div class="row g-3">
                                        @if ($organizationDetail['logo'])
                                            <div class="col-md-4 text-center">
                                                <div class="fw-semibold mb-2">कम्पनी लोगो</div>
                                                <img src="{{ $organizationDetail['logo']->temporaryUrl() }}" alt=""
                                                    height="150">
                                            </div>
                                        @endif

                                        @if ($organizationDetail['org_registration_document'])
                                            <div class="col-md-4 text-center">
                                                <div class="fw-semibold mb-2">कम्पनी प्रमाणपत्र</div>
                                                <img src="{{ $organizationDetail['org_registration_document']->temporaryUrl() }}"
                                                    alt="" height="250">
                                            </div>
                                        @endif

                                        @if ($organizationDetail['org_pan_document'])
                                            <div class="col-md-4 text-center">
                                                <div class="fw-semibold mb-2">पाना</div>
                                                <img src="{{ $organizationDetail['org_pan_document']->temporaryUrl() }}"
                                                    alt="" height="250">
                                            </div>
                                        @endif

                                        @if ($taxClearance['document'])
                                            <div class="col-md-4 text-center">
                                                <div class="fw-semibold mb-2">कर चुक्ता ({{ $taxClearance['year'] }})</div>
                                                <img src="{{ $taxClearance['document']->temporaryUrl() }}" alt=""
                                                    height="250">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" wire:click.prevent="backStep(3)" class="btn btn-info me-2">
                            <i class="bx bx-arrow-circle-left"></i> पछाडि
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> पेश गर्नुहोस्
                        </button>
                    </div>
                @break

                @default
                    <fieldset>
                        <div class="mb-3 border-bottom pb-2">
                            <h3 class="text-primary fw-bold">{{ __('ebps::ebps.oragnization_detail') }}</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="organizationDetail.org_name_ne" class="form-label">संस्था/परामर्शदाताको नाम <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input name="organizationDetail.org_name_ne"
                                        class="form-control @error('organizationDetail.org_name_ne') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_name_ne" placeholder="नेपालीमा"
                                        wire:model="organizationDetail.org_name_ne">
                                    @error('organizationDetail.org_name_ne')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <input name="organizationDetail.org_name_en"
                                        class="form-control @error('organizationDetail.org_name_en') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_name_en" placeholder="In English"
                                        wire:model="organizationDetail.org_name_en">
                                    @error('organizationDetail.org_name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.org_registration_no" class="form-label">कम्पनी दर्ता
                                    नं:</label>
                                <input name="org_registration_no"
                                    class="form-control @error('organizationDetail.org_registration_no') is-invalid @enderror"
                                    type="text" id="organizationDetail.org_registration_no" placeholder="कम्पनी दर्ता न:"
                                    wire:model="organizationDetail.org_registration_no" />
                                @error('organizationDetail.org_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.org_contact" class="form-label">सम्पर्क नम्बर <span
                                        class="text-danger">*</span></label>
                                <input name="organizationDetail.org_contact"
                                    class="form-control @error('organizationDetail.org_contact') is-invalid @enderror"
                                    type="text" id="organizationDetail.org_contact" placeholder="सम्पर्क नम्बर"
                                    wire:model="organizationDetail.org_contact">
                                @error('organizationDetail.org_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.org_pan_no" class="form-label">स्थायी लेखा नं.</label>
                                <input name="organizationDetail.org_pan_no"
                                    class="form-control @error('organizationDetail.org_pan_no') is-invalid @enderror"
                                    type="text" id="organizationDetail.org_pan_no" placeholder="पाना नं."
                                    wire:model="organizationDetail.org_pan_no" />
                                @error('organizationDetail.org_pan_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.org_email" class="form-label">इमेल <span
                                        class="text-danger">*</span></label>
                                <input name="organizationDetail.org_email"
                                    class="form-control @error('organizationDetail.org_email') is-invalid @enderror"
                                    type="text" id="organizationDetail.org_email" placeholder="इमेल"
                                    wire:model="organizationDetail.org_email">
                                @error('organizationDetail.org_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="mb-3 border-bottom pb-2">
                            <h3 class="text-primary fw-bold">{{ __('ebps::ebps.ठगन') }}</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.province_id" class="form-label">प्रदेश</label>
                                <select class="form-select @error('organizationDetail.province_id') is-invalid @enderror"
                                    id="organizationDetail.province_id" wire:model="organizationDetail.province_id"
                                    wire:change="loadDistricts()">
                                    <option selected hidden value="">प्रदेश छान्नुहोस्</option>
                                    @foreach ($provinces as $id => $province)
                                        <option value="{{ $id }}">{{ $province }}</option>
                                    @endforeach
                                </select>
                                @error('organizationDetail.province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.district_id" class="form-label">जिल्ला</label>
                                <select class="form-select @error('organizationDetail.district_id') is-invalid @enderror"
                                    id="organizationDetail.district_id" wire:model="organizationDetail.district_id"
                                    wire:change="loadLocalBodies()">
                                    <option value="">जिल्ला छान्नुहोस्</option>
                                    @foreach ($districts as $id => $district)
                                        <option value="{{ $id }}">{{ $district }}</option>
                                    @endforeach
                                </select>
                                @error('organizationDetail.district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.local_body_id" class="form-label">पालिका</label>
                                <select class="form-select @error('organizationDetail.local_body_id') is-invalid @enderror"
                                    id="organizationDetail.local_body_id" wire:model="organizationDetail.local_body_id"
                                    wire:change="loadWards()">
                                    <option value="">पालिका छान्नुहोस्</option>
                                    @foreach ($localBodies as $id => $localBody)
                                        <option value="{{ $id }}">{{ $localBody }}</option>
                                    @endforeach
                                </select>
                                @error('organizationDetail.local_body_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizationDetail.ward" class="form-label">वार्ड न:</label>
                                <select class="form-select @error('organizationDetail.ward') is-invalid @enderror"
                                    id="organizationDetail.ward" wire:model="organizationDetail.ward">
                                    <option value="">वडा छान्नुहोस्</option>
                                    @foreach ($wards as $id => $ward)
                                        <option value="{{ $id }}">{{ $ward }}</option>
                                    @endforeach
                                </select>
                                @error('organizationDetail.ward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="organizationDetail.tole" class="form-label">गाउँ/टोल</label>
                                <input name="organizationDetail.tole"
                                    class="form-control @error('organizationDetail.tole') is-invalid @enderror"
                                    type="text" id="organizationDetail.tole" placeholder="गाउँ/टोल"
                                    wire:model="organizationDetail.tole" />
                                @error('organizationDetail.tole')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <ul class="list-inline wizard mt-3">
                        <li class="next d-flex justify-content-around">
                            <button type="button" wire:click.prevent="nextStep(2)"
                                class="btn btn-primary px-4 py-2 fw-semibold">
                                अर्को <i class="bx bx-arrow-circle-right"></i>
                            </button>
                        </li>
                    </ul>

            @endswitch
        </form>
    </div>
    <style>
        .nav-link {
            background-color: #ffffff !important;
        }

        .nav-link.active {
            background-color: #01399a !important;
            /* Info color */
            color: #fff !important;
            /* White text */
        }

        fieldset {
            border-color: #ccc !important;
            border-width: 1px;
            padding: 10px;
            margin: 20px 0;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 3px !important;
            font-size: 15px;
            color: #333;
        }
    </style>
</div>


{{-- @push('scripts')
    <script>
        function initNepaliDatePickers() {
            setTimeout(() => {
                const orgRegDate = $('#org_registration_date');
                const orgPanRegDate = $('#org_pan_registration_date');
                const localBodyRegDate = $('#local_body_registration_date');

                if (orgRegDate.length && !orgRegDate.data('datepicker-initialized')) {
                    orgRegDate.nepaliDatePicker({
                        dateFormat: '%y-%m-%d',
                        closeOnDateSelect: true,
                    }).on('dateSelect', function() {
                        let selectedDate = $(this).val();
                        @this.set('organizationDetail.org_registration_date', selectedDate);
                    });
                    orgRegDate.data('datepicker-initialized', true);
                }

                if (orgPanRegDate.length && !orgPanRegDate.data('datepicker-initialized')) {

                    orgPanRegDate.nepaliDatePicker({
                        dateFormat: '%y-%m-%d',
                        closeOnDateSelect: true,
                    }).on('dateSelect', function() {
                        let selectedDate = $(this).val();
                        @this.set('organizationDetail.org_pan_registration_date', selectedDate);
                    });
                    orgPanRegDate.data('datepicker-initialized', true);
                }

                if (localBodyRegDate.length && !localBodyRegDate.data('datepicker-initialized')) {

                    localBodyRegDate.nepaliDatePicker({
                        dateFormat: '%y-%m-%d',
                        closeOnDateSelect: true,
                    }).on('dateSelect', function() {
                        let selectedDate = $(this).val();
                        @this.set('organizationDetail.local_body_registration_date', selectedDate);
                    });
                    localBodyRegDate.data('datepicker-initialized', true);
                }
            }, 300);
        }
        document.addEventListener("step-changed", function(event) {

            initNepaliDatePickers();
        });

        document.addEventListener("livewire:load", function() {
            Livewire.hook('message.processed', (message, component) => {
                initNepaliDatePickers();
            });
        });
    </script>
@endpush --}}
