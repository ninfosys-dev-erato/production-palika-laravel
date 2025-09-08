<div>
    <div class="overflow-hidden p-2">
        <ul class="grid grid-cols-2 md:grid-cols-4 gap-1 border-b border-gray-300 text-sm md:text-base">
            <li class="flex-1 text-center">
                <a href="#"
                    class="block py-2 px-4 rounded-t-md transition-colors 
            text-gray-600 cursor-auto font-medium {{ $currentStep === 1 ? 'active text-primary' : '' }}">
                    <i class="bx bx-building me-1"></i>
                    <span class="sm:inline">संस्था/परामर्शदाता विवरण</span>
                </a>
            </li>
            <li class="flex-1 text-center">
                <a href="#"
                    class="block py-2 px-4 rounded-t-md transition-colors 
            text-gray-600 cursor-auto font-medium {{ $currentStep === 2 ? 'active text-primary' : '' }}">
                    <i class="bx bx-file-alt me-1"></i>
                    <span class="sm:inline">कागजातहरू</span>
                </a>
            </li>
            <li class="flex-1 text-center">
                <a href="#"
                    class="block py-2 px-4 rounded-t-md transition-colors 
            text-gray-600 cursor-auto font-medium {{ $currentStep === 3 ? 'active text-primary' : '' }}">
                    <i class="bx bx-lock me-1"></i>
                    <span class="sm:inline">प्रयोगकर्ता विवरण</span>
                </a>
            </li>
            <li class="flex-1 text-center">
                <a href="#"
                    class="block py-2 px-4 rounded-t-md transition-colors 
            text-gray-600 cursor-auto font-medium  {{ $currentStep === 4 ? 'active text-primary' : '' }}">
                    <i class="bx bx-clipboard-list me-1"></i>
                    <span class="sm:inline">पूर्ण विवरण</span>
                </a>
            </li>
        </ul>

        @if ($progressPercentage > 0)
            <div id="bar" class="progress mb-3" style="height: 7px;">
                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"
                    style="width: {{ $progressPercentage }}%"></div>
            </div>
        @endif
        <form wire:submit.prevent="submitFormData">
            @switch($currentStep)
                @case(2)
                    <div class="">
                        <center>
                            <p style="padding: 10px; color:red;">Note: (*) Please upload file must be in photo and less than
                                200kb.</p>
                        </center>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3 mt-2">
                            <div class="border border-gray-300 rounded-lg p-2 relative">
                                <legend
                                    class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-white px-2 text-sm font-semibold text-blue-600 w-fit">
                                    कम्पनी विवरण
                                </legend>
                                <div class="w-full">
                                    <label for="organizationDetail.logo" class="form-label">कम्पनी लोगो (छापा)
                                        <span class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  {{ $organizationDetail['logo'] ? 'is-valid' : '' }}"
                                        id="organizationDetail.logo" wire:model="organizationDetail.logo" />
                                    @error('organizationDetail.logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label for="organizationDetail.company_registration_document" class="form-label">कम्पनी
                                        दर्ता
                                        प्रमाणपत्र <span class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 {{ $organizationDetail['company_registration_document'] ? 'is-valid' : '' }}"
                                        id="organizationDetail.company_registration_document"
                                        wire:model="organizationDetail.company_registration_document" />
                                    @error('organizationDetail.company_registration_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="border border-gray-300 rounded-lg p-2 relative">
                                <legend
                                    class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-white px-2 text-sm font-semibold text-blue-600 w-fit ">
                                    व्यवसाय दर्ता विवरण
                                </legend>
                                <div class=" w-full">
                                    <label for="organizationDetail.org_registration_date" class="form-label">व्यवसाय दर्ता मिति
                                        (बि.
                                        स.)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="organizationDetail.org_registration_date" id="org_registration_date"
                                        class="form-control nepali-form w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.org_registration_date') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_registration_date"
                                        placeholder="दर्ता मिति (YYYY-MM-DD)"
                                        wire:model="organizationDetail.org_registration_date" />
                                    @error('organizationDetail.org_registration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label for="organizationDetail.org_registration_document" class="form-label">व्यवसाय दर्ता
                                        प्रमाणपत्र <span class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  {{ $organizationDetail['org_registration_document'] ? 'is-valid' : '' }}"
                                        id="organizationDetail.org_registration_document"
                                        wire:model="organizationDetail.org_registration_document" />
                                    @error('organizationDetail.org_registration_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="border border-gray-300 rounded-lg p-2 relative mt-3">
                                <legend
                                    class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-white px-2 text-sm font-semibold text-blue-600 w-fit">
                                    स्थायी लेखा विवरण
                                </legend>
                                <div class=" w-full">
                                    <label for="organizationDetail.org_pan_registration_date" class="form-label">स्थायी लेखा
                                        नं.दर्ता मिति (बि. स.)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="organizationDetail.org_pan_registration_date" id="org_pan_registration_date"
                                        class="nepali-date form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.org_pan_registration_date') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_pan_registration_date"
                                        placeholder="दर्ता मिति (YYYY-MM-DD)"
                                        wire:model="organizationDetail.org_pan_registration_date" />
                                    @error('organizationDetail.org_pan_registration_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class=" w-full">
                                    <label for="organizationDetail.org_pan_document" class="form-label">स्थायी लेखा नं.
                                        प्रमाणपत्र
                                        <span class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  {{ $organizationDetail['org_pan_document'] ? 'is-valid' : '' }}"
                                        id="organizationDetail.org_pan_document"
                                        wire:model="organizationDetail.org_pan_document" />
                                    @error('organizationDetail.org_pan_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="border border-gray-300 rounded-lg p-2 relative mt-3">
                                <legend
                                    class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-white px-2 text-sm font-semibold text-blue-600 w-fit">
                                    कर चुक्ता विवरण
                                </legend>
                                <div class=" w-full">
                                    <label for="taxClearance.document" class="form-label">कर चुक्ता प्रमाणपत्र
                                        <span class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  {{ $taxClearance['document'] ? 'is-valid' : '' }}"
                                        id="taxClearance.document" wire:model="taxClearance.document" />
                                    @error('taxClearance.document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class=" w-full">
                                    <label for="taxClearance.year" class="form-label">कर चुक्ता गरेको आर्थिक वर्ष
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="taxClearance.year"
                                        class="form-control w-full focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('taxClearance.year') is-invalid @enderror"
                                        type="text" id="taxClearance.year"
                                        placeholder="(YYYY/YY)कर चुक्ता गरेको आर्थिक वर्ष" wire:model="taxClearance.year" />
                                    @error('taxClearance.year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full">
                                <label for="organizationDetail.local_body_registration_no" class="form-label">व्यवसाय दर्ता
                                    नं.
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_registration_no"
                                    class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.local_body_registration_no') is-invalid @enderror"
                                    type="number" id="organizationDetail.local_body_registration_no"
                                    placeholder="पालिका दर्ता नं."
                                    wire:model="organizationDetail.local_body_registration_no" />
                                @error('organizationDetail.local_body_registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="organizationDetail.local_body_registration_date" class="form-label">दर्ता मिति
                                    (बि. स.)
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_registration_date"
                                    id="local_body_registration_date"
                                    class="nepali-date form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.local_body_registration_date') is-invalid @enderror"
                                    type="text" id="organizationDetail.local_body_registration_date"
                                    placeholder="दर्ता मिति (YYYY-MM-DD)"
                                    wire:model="organizationDetail.local_body_registration_date" />
                                @error('organizationDetail.local_body_registration_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="organizationDetail.local_body_file" class="form-label">अन्य फाइल (photo,pdf)
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="organizationDetail.local_body_file"
                                    class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.local_body_file') is-invalid @enderror"
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
                    <div class=" card p-2 alert alert-info" role="alert">
                        Please fill up valid email,phone number,and password.
                    </div>
                    <div class="">
                        <div class="grid grid-cols-2 gap-x-2 sm:gap-x-3 gap-y-1 sm:gap-y-2">
                            <div class="w-full">
                                <label for="organizationUser.name" class="form-label">प्रयोगकर्ताको नाम <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="organizationUser.name">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input name="organizationUser.name"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationUser.name') is-invalid @enderror"
                                        type="text" id="organizationUser.name" placeholder="प्रयोगकर्ताको नाम"
                                        wire:model="organizationUser.name">
                                </div>
                                @error('organizationUser.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="organizationUser.phone" class="form-label">सम्पर्क नं. <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="organizationUser.email">
                                        <i class="bx bx-phone"></i>
                                    </span>
                                    <input name="organizationUser.phone"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationUser.phone') is-invalid @enderror"
                                        type="text" id="organizationUser.phone" placeholder="सम्पर्क नं"
                                        wire:model="organizationUser.phone">
                                </div>
                                @error('organizationUser.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full col-span-2">
                                <label for="organizationUser.email" class="form-label">इमेल <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="user.email">
                                        <i class="bx bx-envelope"></i>
                                    </span>
                                    <input name="organizationUser.email"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationUser.email') is-invalid @enderror"
                                        type="email" id="organizationUser.email" placeholder="इमेल"
                                        wire:model="organizationUser.email">
                                </div>
                                @error('organizationUser.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="organizationUser.password" class="form-label">पासवर्ड<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input name="organizationUser.password"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationUser.password') is-invalid @enderror"
                                        type="password" id="organizationUser.password" placeholder="पासवर्ड"
                                        wire:model="organizationUser.password">
                                </div>
                                @error('organizationUser.password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="organizationUser.password_confirmation" class="form-label">पासवर्ड सुनिश्चित<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input name="organizationUser.password_confirmation"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationUser.password_confirmation') is-invalid @enderror"
                                        type="password" id="organizationUser.password_confirmation"
                                        placeholder="पासवर्ड सुनिश्चित" wire:model="organizationUser.password_confirmation">
                                </div>
                                @error('organizationUser.password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline wizard mt-3">
                        <li class="next d-flex justify-content-end">
                            <button type="button" wire:click.prevent="backStep(2)" class="btn btn-light me-2">
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
                        <div class="">
                            <div class="">
                                <div class="">
                                    <ul class="nav nav-pills nav-fill navtab-bg flex gap-1">
                                        <li class="nav-item ">
                                            <a href="#timeline" data-bs-toggle="tab" aria-expanded="true"
                                                class="nav-link  active">
                                                संस्था/परामर्शदाताको विवरण
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#user" data-bs-toggle="tab" aria-expanded="false" class="nav-link ">
                                                प्रयोगकर्ता
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link ">
                                                आवश्यक कागजातहरु
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-2">
                                        <div class="tab-pane active" id="timeline">
                                            <table class="table table-sm mb-0 table-striped table-hover">
                                                <tr>
                                                    <td>संस्था/परामर्शदाताको नाम</td>
                                                    <td>{{ $organizationDetail['org_name_ne'] }}
                                                        ({{ $organizationDetail['org_name_en'] }})
                                                    </td>
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

                                        <div class="tab-pane" id="user">
                                            <table class="table table-sm mb-0 table-striped table-hover">
                                                <tr>
                                                    <td>प्रयोगकर्ताको नाम</td>
                                                    <td>
                                                        {{ $organizationUser['name'] }}
                                                    </td>
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

                                        {{-- <div class="tab-pane" id="settings">
                                            <div class="">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-2">
                                                    <div class="w-full ">
                                                        @if ($organizationDetail['logo'])
                                                            <div class="">
                                                                <div class="text-center font-semibold">कम्पनी लोगो</div>
                                                                <div class="">
                                                                    <img src="{{ $organizationDetail['logo']->temporaryUrl() }}"
                                                                        height="150" alt="">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="w-full">
                                                        @if ($organizationDetail['org_registration_document'])
                                                            <div>
                                                                <div class="text-center font-semibold">कम्पनी प्रमाणपत्र</div>
                                                                <div>
                                                                    <img src="{{ $organizationDetail['org_registration_document']->temporaryUrl() }}"
                                                                        height="250" alt="">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="w-full">
                                                        @if ($organizationDetail['org_pan_document'])
                                                            <div>
                                                                <div class="text-center font-semibold">पाना</div>
                                                                <div>
                                                                    <img src="{{ $organizationDetail['org_pan_document']->temporaryUrl() }}"
                                                                        height="250" alt="">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="w-full">
                                                        @if ($taxClearance['document'])
                                                            <div>
                                                                <div class="text-center font-semibold">कर चुक्ता
                                                                    ({{ $taxClearance['year'] }})
                                                                </div>
                                                                <div>
                                                                    <img src="{{ $taxClearance['document']->temporaryUrl() }}"
                                                                        height="250" alt="">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="next d-flex justify-content-end">
                            <button type="button" wire:click.prevent="backStep(3)" class="btn btn-light me-2">
                                <i class="bx bx-arrow-circle-left"></i> पछाडि
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> पेश गर्नुहोस्
                            </button>
                        </div>
                    </div>
                @break;

                @default
                    <fieldset>
                        <legend class="title text-primary fs-4 fw-bolder">संस्था/परामर्शदाता विवरण</legend>
                        <div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label for="organizationDetail.org_name_ne" class="form-label">संस्था/परामर्शदाताको नाम <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input name="organizationDetail.org_name_ne"
                                            class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400  @error('organizationDetail.org_name_ne') is-invalid @enderror"
                                            type="text" id="organizationDetail.org_name_ne" placeholder="नेपालीमा"
                                            wire:model="organizationDetail.org_name_ne">
                                        @error('organizationDetail.org_name_ne')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <input name="organizationDetail.org_name_en"
                                            class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.org_name_en') is-invalid @enderror"
                                            type="text" id="organizationDetail.org_name_en" placeholder="In English"
                                            wire:model="organizationDetail.org_name_en">
                                        @error('organizationDetail.org_name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.org_registration_no" class="form-label">कम्पनी दर्ता
                                        नं:</label>
                                    <input name="org_registration_no"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.org_registration_no') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_registration_no"
                                        placeholder="कम्पनी दर्ता न:" wire:model="organizationDetail.org_registration_no" />
                                    @error('organizationDetail.org_registration_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.org_contact" class="form-label">सम्पर्क नम्बर
                                        <span class="text-danger">*</span>
                                    </label>


                                    <input name="organizationDetail.org_contact"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.org_contact') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_contact" placeholder="सम्पर्क नम्बर"
                                        wire:model="organizationDetail.org_contact">

                                    @error('organizationDetail.org_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.org_pan_no" class="form-label">स्थायी लेखा नं.</label>
                                    <input name="organizationDetail.org_pan_no"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.org_pan_no') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_pan_no" placeholder="पाना नं."
                                        wire:model="organizationDetail.org_pan_no" />
                                    @error('organizationDetail.org_pan_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.org_email" class="form-label">इमेल
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input name="organizationDetail.org_email"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.org_email') is-invalid @enderror"
                                        type="text" id="organizationDetail.org_email" placeholder="इमेल"
                                        wire:model="organizationDetail.org_email">

                                    @error('organizationDetail.org_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="title text-primary fs-4 fw-bolder">ठेगाना</legend>
                        <div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.province_id" class="form-label">प्रदेश</label>
                                    <select
                                        class="form-select text-[#555555] focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.province_id') is-invalid @enderror"
                                        id="organizationDetail.province_id" wire:model="organizationDetail.province_id"
                                        wire:change="loadDistricts()">
                                        <option selected hidden value="" class="text-red-900">प्रदेश छान्नुहोस्</option>
                                        @foreach ($provinces as $id => $province)
                                            <option value="{{ $id }}">{{ $province }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('organizationDetail.province_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.district_id" class="form-label">जिल्ला</label>
                                    <select
                                        class="form-select text-[#555555] focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.district_id') is-invalid @enderror"
                                        id="organizationDetail.district_id" wire:model="organizationDetail.district_id"
                                        wire:change="loadLocalBodies()">
                                        <option value="">जिल्ला छान्नुहोस्</option>
                                        @foreach ($districts as $id => $district)
                                            <option value="{{ $id }}"> {{ $district }} </option>
                                        @endforeach
                                    </select>
                                    @error('organizationDetail.district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.local_body_id" class="form-label">पालिका</label>
                                    <select
                                        class="form-select text-[#555555] focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.local_body_id') is-invalid @enderror"
                                        id="organizationDetail.local_body_id" wire:model="organizationDetail.local_body_id"
                                        wire:change="loadWards()">
                                        <option value="">पालिका छान्नुहोस्</option>
                                        @foreach ($localBodies as $id => $localBody)
                                            <option value="{{ $id }}">
                                                {{ $localBody }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('organizationDetail.local_body_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="organizationDetail.ward" class="form-label">वार्ड न:</label>
                                    <select
                                        class="form-select text-[#555555] focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.ward') is-invalid @enderror"
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
                                <div class="col-md-8 mb-2">
                                    <label for="organizationDetail.tole" class="form-label text-[#555555]">गाउँ/टोल</label>
                                    <input name="organizationDetail.tole"
                                        class="form-control focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 @error('organizationDetail.tole') is-invalid @enderror"
                                        type="text" id="organizationDetail.tole" placeholder="गाउँ/टोल"
                                        wire:model="organizationDetail.tole" />
                                    @error('organizationDetail.tole')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <ul class="list-inline wizard mt-3">
                        <li class="next d-flex justify-content-around">
                            <button type="button" wire:click.prevent="nextStep(2)"
                                class="px-4 py-2 bg-[#59a1ed] rounded-sm text-white font-semibold">
                                अर्को <i class="bx bx-arrow-circle-right"></i>
                            </button>

                        </li>
                    </ul>
            @endswitch
        </form>
    </div>
    <style>
        .nav-link {
            background-color: #f5f5f5 !important;
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

