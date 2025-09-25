<form wire:submit.prevent="save" enctype="multipart/form-data">
    <div class="card shqdow-sm p-4 ">
        <div class="card mb-4">
            <div class="card-header bg-light text-dark">{{ __('Personal Details') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Customer Name') }}" id="name" name="customer.name"
                            placeholder="{{ __('Enter Name') }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Email') }}" id="customer.email"
                            placeholder="{{ __('Enter Email') }}" name="customer.email" />
                    </div>
                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Mobile Number') }}" id="customer.mobile_no"
                            placeholder="{{ __('Enter Mobile Number') }}" name="customer.mobile_no" />
                    </div>
                    <div class="col-md-6">
                        <label for="customer.gender">{{ __('Gender') }}</label>
                        <select id="customer.gender" name="customer.gender" class="form-control"
                            wire:model="customer.gender">
                            <option value="">{{ __('Choose Gender') }}</option>
                            @foreach ($genderOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        @error('customer.gender')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="image">{{ __('Avatar') }}</label>
                            <input wire:model="avatar" name="avatar" type="file"
                                class="form-control" accept="image/*,.pdf">
                            @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            @if (
                                ($avatar && $avatar instanceof \Livewire\TemporaryUploadedFile) ||
                                    $avatar instanceof \Illuminate\Http\File ||
                                    $avatar instanceof \Illuminate\Http\UploadedFile)
                                @php
                                    $mime = $avatar->getMimeType();
                                    $isImage = str_starts_with($mime, 'image/');
                                    $isPDF = $mime === 'application/pdf';
                                @endphp

                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    
                                        <div class="border rounded p-3 d-flex align-items-center"
                                            style="height: 60px;">
                                            <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                            <a href="{{ $avatar->temporaryUrl() }}" target="_blank"
                                                class="text-primary fw-bold text-decoration-none">
                                                {{ __('अपलोड गरिएको फाइल हेर्नुहोस्') }}
                                            </a>
                                   
                                </div>
                            @elseif (!empty(trim($avatar)))
                                @php
                                    $fileUrl = customFileAsset(
                                        'customer/avatar',
                                        $avatar,
                                        'local',
                                        'tempUrl',
                                    );
                                @endphp

                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file"></i>
                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nepali_date_of_birth">{{ __('Nepali Date of Birth') }}</label>
                        <input type="text" name="kyc.nepali_date_of_birth" id="nepali_date_of_birth"
                            class="nepali-date form-control" wire:model="kyc.nepali_date_of_birth"
                            placeholder="{{ __('Select Date') }}" />

                        @error('kyc.nepali_date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-light text-dark">{{ __('Family Details') }}</div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Grandfather Name') }}" id="kyc.grandfather_name"
                            name="kyc.grandfather_name" placeholder="{{ __('Enter GrandFather Name') }}" />
                    </div>

                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Father Name') }}" id="kyc.father_name" name="kyc.father_name"
                            placeholder="{{ __('Enter Father Name') }}" />
                    </div>

                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Mother Name') }}" id="kyc.mother_name" name="kyc.mother_name"
                            placeholder="{{ __('Enter Mother Name') }}" />
                    </div>

                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('Spouse Name') }}" id="kyc.spouse_name" name="kyc.spouse_name"
                            placeholder="{{ __('Enter Spouse Name') }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-light text-dark">{{ __('Permanent Address') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="permanent_province_id">{{ __('Province') }}</label>
                        <select id="permanent_province_id" name="kyc.permanent_province_id" class="form-control"
                            wire:model="kyc.permanent_province_id" wire:change="permanentLoadDistricts">
                            <option value="">{{ __('Choose Province') }}</option>
                            @foreach ($provinces as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('kyc.permanent_province_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="district_id">{{ __('District') }}</label>
                        <select id="district_id" name="kyc.permanent_district_id" class="form-control"
                            wire:model="kyc.permanent_district_id" wire:change="permanentLoadLocalBodies">
                            <option value="">{{ __('Choose District') }}</option>
                            @foreach ($permanentDistricts as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach

                        </select>
                        @error('kyc.permanent_district_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="local_body_id">{{ __('Local Body') }}</label>
                        <select id="local_body_id" name="kyc.permanent_local_body_id" class="form-control"
                            wire:model="kyc.permanent_local_body_id" wire:change="permanentLoadWards">
                            <option value="">{{ __('Choose Local Body') }}</option>

                            @foreach ($permanentLocalBodies as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach

                        </select>
                        @error('kyc.permanent_local_body_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="ward_id">{{ __('Ward') }}</label>
                        <select id="ward_id" name="kyc.permanent_ward" class="form-control"
                            wire:model="kyc.permanent_ward">
                            <option value="">{{ __('Choose Ward') }}</option>
                            @foreach ($permanentWards as $id => $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('kyc.permanent_ward')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <x-form.text-input label="{{ __('Tole') }}" id="kyc.permanent_tole"
                            name="kyc.permanent_tole" placeholder="{{ __('Enter Tole Name') }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-center">
            <button wire:click="checkIsSameAsPermanent" type="button"
                class="btn btn-outline-secondary">{{ __('Same as Permanent') }}</button>
        </div>

        @if (!$isSameAsPermanent)
            <div class="card mb-4">
                <div class="card-header bg-light text-dark">{{ __('Temporary Address') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="province_id">{{ __('Province') }}</label>
                            <select id="province_id" name="kyc.temporary_province_id" class="form-control"
                                wire:model="kyc.temporary_province_id" wire:change="temporaryLoadDistricts">
                                <option value="">{{ __('Choose Province') }}</option>
                                @foreach ($provinces as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            @error('kyc.temporary_province_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="district_id">{{ __('District') }}</label>
                            <select id="district_id" name="kyc.temporary_district_id" class="form-control"
                                wire:model="kyc.temporary_district_id" wire:change="temporaryLoadLocalBodies">
                                <option value="">{{ __('Choose District') }}</option>
                                @foreach ($temporaryDistricts as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            @error('kyc.temporary_district_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="local_body_id">{{ __('Local Body') }}</label>
                            <select id="local_body_id" name="kyc.temporary_local_body_id" class="form-control"
                                wire:model="kyc.temporary_local_body_id" wire:change="temporaryLoadWards">
                                <option value="">{{ __('Choose Local Body') }}</option>
                                @foreach ($temporaryLocalBodies as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            @error('kyc.temporary_local_body_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="ward_id">{{ __('Ward') }}</label>
                            <select id="ward_id" name="kyc.temporary_ward" class="form-control"
                                wire:model="kyc.temporary_ward">
                                <option value="">{{ __('Choose Ward') }}</option>
                                @foreach ($temporaryWards as $id => $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            @error('kyc.temporary_ward')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <x-form.text-input label="{{ __('Tole') }}" id="kyc.temporary_tole"
                                name="kyc.temporary_tole" placeholder="{{ __('Enter Tole Name') }}" />
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header bg-light text-dark">{{ __('Document Details') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="kyc.document_type">{{ __('Document Type') }}</label>
                        <select id="kyc.document_type" name="kyc.document_type" class="form-control"
                            wire:model="kyc.document_type" wire:change="updateDocumentNumber">
                            <option value="">{{ __('Choose Document Type') }}</option>

                            @foreach ($documentOptions as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        @error('kyc.document_type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="image">{{ __('Document Image 1') }}</label>
                            <input wire:model="uploadedImage1" name="uploadedImage1" type="file"
                                class="form-control" accept="image/*,.pdf">
                            @error('uploadedImage1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            @if (
                                ($uploadedImage1 && $uploadedImage1 instanceof \Livewire\TemporaryUploadedFile) ||
                                    $uploadedImage1 instanceof \Illuminate\Http\File ||
                                    $uploadedImage1 instanceof \Illuminate\Http\UploadedFile)
                                @php
                                    $mime = $uploadedImage1->getMimeType();
                                    $isImage = str_starts_with($mime, 'image/');
                                    $isPDF = $mime === 'application/pdf';
                                @endphp

                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    @if ($isImage)
                                        <img src="{{ $uploadedImage1->temporaryUrl() }}" alt="Image Preview"
                                            class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" />
                                    @elseif ($isPDF)
                                        <div class="border rounded p-3 d-flex align-items-center"
                                            style="height: 60px;">
                                            <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                            <a href="{{ $uploadedImage1->temporaryUrl() }}" target="_blank"
                                                class="text-primary fw-bold text-decoration-none">
                                                {{ __('अपलोड गरिएको फाइल हेर्नुहोस्') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="border p-2 text-center" style="height: 150px;">
                                            <p class="mb-1">Unsupported File</p>
                                        </div>
                                    @endif
                                </div>
                            @elseif (!empty(trim($this->kyc->document_image1)))
                                @php
                                    $fileUrl = customFileAsset(
                                        config('src.CustomerKyc.customerKyc.path'),
                                        $this->kyc->document_image1,
                                        'local',
                                        'tempUrl',
                                    );
                                @endphp

                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file"></i>
                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($showDocumentBackInput)
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="image">{{ __('Document Image 2') }}</label>
                                <input wire:model="uploadedImage2" name="uploadedImage2" type="file"
                                    class="form-control" accept="image/*,.pdf">
                                @error('uploadedImage2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (
                                    ($uploadedImage2 && $uploadedImage2 instanceof \Livewire\TemporaryUploadedFile) ||
                                        $uploadedImage2 instanceof \Illuminate\Http\File ||
                                        $uploadedImage2 instanceof \Illuminate\Http\UploadedFile)
                                    @php
                                        $mime = $uploadedImage2->getMimeType();
                                        $isImage = str_starts_with($mime, 'image/');
                                        $isPDF = $mime === 'application/pdf';
                                    @endphp

                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        @if ($isImage)
                                            <img src="{{ $uploadedImage2->temporaryUrl() }}" alt="Image Preview"
                                                class="img-thumbnail w-100"
                                                style="height: 150px; object-fit: cover;" />
                                        @elseif ($isPDF)
                                            <div class="border rounded p-3 d-flex align-items-center"
                                                style="height: 60px;">
                                                <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                                <a href="{{ $uploadedImage2->temporaryUrl() }}" target="_blank"
                                                    class="text-primary fw-bold text-decoration-none">
                                                    {{ __('अपलोड गरिएको फाइल हेर्नुहोस्') }}
                                                </a>
                                            </div>
                                        @else
                                            <div class="border p-2 text-center" style="height: 150px;">
                                                <p class="mb-1">Unsupported File</p>
                                            </div>
                                        @endif
                                    </div>
                                @elseif (!empty(trim($this->kyc->document_image2)))
                                    @php
                                        $fileUrl = customFileAsset(
                                            config('src.CustomerKyc.customerKyc.path'),
                                            $this->kyc->document_image2,
                                            'local',
                                            'tempUrl',
                                        );
                                    @endphp

                                    <a href="{{ $fileUrl }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-file"></i>
                                        {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <x-form.select-input label="{{ __('Document Issued District') }}" id="kyc.document_issued_at"
                            name="kyc.document_issued_at" :options="getDistricts()->pluck('title', 'id')->toArray()"
                            placeholder="{{ __('Choose District') }}" />
                    </div>

                    <div class="col-md-6 mb-4">
                        <x-form.text-input label="{{ __('Document Number') }}" id="document_number"
                            name="kyc.document_number" />
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="document_issued_date_nepali">{{ __('Document Issued Date (Nepali)') }}</label>
                        <input type="text" name="kyc.document_issued_date_nepali" id="document_issued_date_nepali"
                            class="nepali-date form-control" wire:model="kyc.document_issued_date_nepali"
                            placeholder="{{ __('Select Date') }}" />

                        @error('kyc.document_issued_date_nepali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <x-form.text-input type="date" label="{{ __('Expiry Date (English)') }}"
                            id="expiry_date_english" name="kyc.expiry_date_english" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        </div>
    </div>
</form>
