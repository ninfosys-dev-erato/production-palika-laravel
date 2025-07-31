<form wire:submit.prevent="save" enctype="multipart/form-data">
    <div class="card shadow-sm p-4 mb-4">
        {{-- <div class="card mb-4"> --}}
        <div class="card-header text-primary">
            <h5>{{ __('Personal Details') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <livewire:phone_search />
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
                    <label class="form-label" for="customer.gender">{{ __('Gender') }}</label>
                    <select id="customer.gender" name="customer.gender"
                        class="form-control {{ $errors->has('customer.gender') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('customer.gender') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
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

                @if (!$isForGrievance)
                    <div class="col-md-6">
                        <label class="form-label" for="nepali_date_of_birth">{{ __('Nepali Date of Birth') }}</label>
                        <input type="text" name="customer.nepali_date_of_birth" id="nepali_date_of_birth"
                            class="form-control {{ $errors->has('customer.nepali_date_of_birth') ? 'is-invalid' : '' }} nepali-date"
                            style="{{ $errors->has('customer.nepali_date_of_birth') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:model="customer.nepali_date_of_birth" placeholder="{{ __('Select Date') }}" />

                        @error('customer.nepali_date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

            </div>
        </div>
        {{-- </div> --}}

        @if (!$isForGrievance)

            <div class="card mb-4">
                <div class="card-header text-primary">
                    <h5>{{ __('Family Details') }} <h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <x-form.text-input label="{{ __('Grandfather Name') }}" id="customer.grandfather_name"
                                name="customer.grandfather_name" placeholder="{{ __('Enter GrandFather Name') }}" />
                        </div>

                        <div class="col-md-6">
                            <x-form.text-input label="{{ __('Father Name') }}" id="customer.father_name"
                                name="customer.father_name" placeholder="{{ __('Enter Father Name') }}" />
                        </div>

                        <div class="col-md-6">
                            <x-form.text-input label="{{ __('Mother Name') }}" id="customer.mother_name"
                                name="customer.mother_name" placeholder="{{ __('Enter Mother Name') }}" />
                        </div>

                        <div class="col-md-6">
                            <x-form.text-input label="{{ __('Spouse Name') }}" id="customer.spouse_name"
                                name="customer.spouse_name" placeholder="{{ __('Enter Spouse Name') }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light text-dark">
                    <h5>{{ __('Permanent Address') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="province_id">{{ __('Province') }}</label>
                            <select id="province_id" name="customer.permanent_province_id"
                                class="form-control {{ $errors->has('customer.permanent_province_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('customer.permanent_province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="customer.permanent_province_id" wire:change="permanentLoadDistricts">
                                <option value="">{{ __('Choose Province') }}</option>
                                @foreach ($provinces as $id => $title)
                                    <option value="{{ $id }}"
                                        {{ old('customer.permanent_province_id', $customer->permanent_province_id) == $id ? 'selected' : '' }}>
                                        {{ $title }}</option>
                                @endforeach
                            </select>
                            @error('customer.permanent_province_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="district_id">{{ __('District') }}</label>
                            <select id="district_id" name="customer.permanent_district_id"
                                class="form-control {{ $errors->has('customer.permanent_district_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('customer.permanent_district_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="customer.permanent_district_id" wire:change="permanentLoadLocalBodies">
                                <option value="">{{ __('Choose District') }}</option>
                                @foreach ($permanentDistricts as $id => $title)
                                    <option value="{{ $id }}"
                                        {{ old('customer.permanent_district_id', $customer->permanent_district_id) == $id ? 'selected' : '' }}>
                                        {{ $title }}</option>
                                @endforeach
                            </select>
                            @error('customer.permanent_district_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="local_body_id">{{ __('Local Body') }}</label>
                            <select id="local_body_id" name="customer.permanent_local_body_id"
                                class="form-control {{ $errors->has('customer.permanent_local_body_id') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('customer.permanent_local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="customer.permanent_local_body_id" wire:change="permanentLoadWards">
                                <option value="">{{ __('Choose Local Body') }}</option>
                                @foreach ($permanentLocalBodies as $id => $title)
                                    <option value="{{ $id }}"
                                        {{ old('customer.permanent_local_body_id', $customer->permanent_local_body_id) == $id ? 'selected' : '' }}>
                                        {{ $title }}</option>
                                @endforeach
                            </select>
                            @error('customer.permanent_local_body_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="ward">{{ __('Ward') }}</label>
                            <select id="ward" name="customer.permanent_ward"
                                class="form-control {{ $errors->has('customer.permanent_ward') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('customer.permanent_ward') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="customer.permanent_ward">
                                <option value="">{{ __('Choose Ward') }}</option>
                                @foreach ($permanentWards as $id => $title)
                                    <option value="{{ $title }}"
                                        {{ old('customer.permanent_ward', $customer->permanent_ward) == $id ? 'selected' : '' }}>
                                        {{ $title }}</option>
                                @endforeach
                            </select>
                            @error('customer.permanent_ward')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <x-form.text-input label="{{ __('Tole') }}" id="customer.permanent_tole"
                                name="customer.permanent_tole" placeholder="{{ __('Enter Tole Name') }}" />
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
                                <label class="form-label" for="province_id">{{ __('Province') }}</label>
                                <select id="province_id" name="customer.temporary_province_id"
                                    class="form-control {{ $errors->has('customer.temporary_province_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('customer.temporary_province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="customer.temporary_province_id" wire:change="temporaryLoadDistricts">
                                    <option value="">{{ __('Choose Province') }}</option>
                                    @foreach ($provinces as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('customer.temporary_province_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="district_id">{{ __('District') }}</label>
                                <select id="district_id" name="customer.temporary_district_id"
                                    class="form-control {{ $errors->has('customer.temporary_district_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('customer.temporary_district_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="customer.temporary_district_id"
                                    wire:change="temporaryLoadLocalBodies">
                                    <option value="">{{ __('Choose District') }}</option>
                                    @foreach ($temporaryDistricts as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('customer.temporary_district_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="local_body_id">{{ __('Local Body') }}</label>
                                <select id="local_body_id" name="customer.temporary_local_body_id"
                                    class="form-control {{ $errors->has('customer.temporary_local_body_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('customer.temporary_local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="customer.temporary_local_body_id" wire:change="temporaryLoadWards">
                                    <option value="">{{ __('Choose Local Body') }}</option>
                                    @foreach ($temporaryLocalBodies as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('customer.temporary_local_body_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="ward">{{ __('Ward') }}</label>
                                <select id="ward" name="customer.temporary_ward"
                                    class="form-control {{ $errors->has('customer.temporary_ward') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('customer.temporary_ward') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="customer.temporary_ward">
                                    <option value="">{{ __('Choose Ward') }}</option>
                                    @foreach ($temporaryWards as $id => $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('customer.temporary_ward')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <x-form.text-input label="{{ __('Tole') }}" id="customer.temporary_tole"
                                    name="customer.temporary_tole" placeholder="{{ __('Enter Tole Name') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-light text-dark">
                    <h5>{{ __('Document Details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="customer.document_type">{{ __('Document Type') }}</label>
                            <select id="customer.document_type" name="customer.document_type"
                                class="form-control {{ $errors->has('customer.document_type') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('customer.document_type') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="customer.document_type" wire:change="updateDocumentNumber">
                                <option value="">{{ __('Choose Document Type') }}</option>
                                @foreach ($documentOptions as $id => $title)
                                    <option value="{{ $id }}"
                                        {{ old('customer.document_type', $customer->document_type) == $id ? 'selected' : '' }}>
                                        {{ $title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer.document_type')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="image">{{ __('Document Image 1') }}</label>
                                <input wire:model="uploadedImage1" name="uploadedImage1" type="file"
                                    class="form-control {{ $errors->has('uploadedImage1') ? 'is-invalid' : '' }}"
                                    accept="image/*,.pdf"
                                    style="{{ $errors->has('uploadedImage1') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                @error('uploadedImage1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if ($uploadedImage1)
                                    @php
                                        $previewUrl = safeFilePreview($uploadedImage1);
                                    @endphp
                                    
                                    @if ($previewUrl)
                                        <img src="{{ $previewUrl }}" alt="Uploaded Image Preview"
                                            class="img-thumbnail mt-2" style="height: 300px;">
                                    @else
                                        <div class="mt-2 p-3 bg-light border rounded">
                                            <i class="{{ getFileTypeIcon($uploadedImage1) }}"></i>
                                            <span class="ms-2">{{ $uploadedImage1->getFilename() }}</span>
                                            <br>
                                            <small class="text-muted">{{ __('This file type cannot be previewed') }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if ($showDocumentBackInput)
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label" for="image">{{ __('Document Image 2') }}</label>
                                    <input wire:model="uploadedImage2" name="uploadedImage2" type="file"
                                        accept="image/*,.pdf"
                                        class="form-control {{ $errors->has('uploadedImage2') ? 'is-invalid' : '' }}"
                                        style="{{ $errors->has('uploadedImage2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    @error('uploadedImage2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if ($uploadedImage2)
                                        @php
                                            $previewUrl2 = safeFilePreview($uploadedImage2);
                                        @endphp
                                        
                                        @if ($previewUrl2)
                                            <img src="{{ $previewUrl2 }}"
                                                alt="Uploaded Image Preview" class="img-thumbnail mt-2"
                                                style="height: 300px;">
                                        @else
                                            <div class="mt-2 p-3 bg-light border rounded">
                                                <i class="{{ getFileTypeIcon($uploadedImage2) }}"></i>
                                                <span class="ms-2">{{ $uploadedImage2->getFilename() }}</span>
                                                <br>
                                                <small class="text-muted">{{ __('This file type cannot be previewed') }}</small>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <x-form.select-input label="{{ __('Document Issued District') }}"
                                id="customer.document_issued_at" name="customer.document_issued_at" :options="getDistricts()->pluck('title', 'id')->toArray()"
                                placeholder="{{ __('Choose District') }}" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <x-form.text-input label="{{ __('Document Number') }}" id="document_number"
                                name="customer.document_number" />
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label"
                                for="document_issued_date_nepali">{{ __('Document Issued Date (Nepali)') }}</label>
                            <input type="text" name="customer.document_issued_date_nepali"
                                class="form-control {{ $errors->has('customer.document_issued_date_nepali') ? 'is-invalid' : '' }} nepali-date"
                                style="{{ $errors->has('customer.document_issued_date_nepali') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                id="document_issued_date_nepali" wire:model="customer.document_issued_date_nepali"
                                placeholder="{{ __('Select Date') }}" />

                            @error('customer.document_issued_date_nepali')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <x-form.text-input type="date" label="{{ __('Expiry Date (English)') }}"
                                id="expiry_date_english" name="customer.expiry_date_english" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        @if ($isModalForm === false)
            <a href="{{ route('admin.customer.index') }}" wire:loading.attr="disabled"
                class="btn btn-secondary">{{ __('Back') }}</a>
        @endif
    </div>
    </div>
</form>

@script
    <script>
        $wire.on('customer-created', () => {
            window.location.reload();
        });
    </script>
@endscript
