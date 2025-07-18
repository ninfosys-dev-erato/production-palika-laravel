<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            @if ($action === App\Enums\Action::UPDATE)
                <div class='col-md-4 mb-3'>
                    <label for="name">{{ __('ebps::ebps.submission_number') }}</label>
                    <input type="text" readonly class="form-control" value="{{ $mapApply->submission_id }}">
                </div>
            @endif

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='map_process_type'>{{ __('ebps::ebps.map_process_type') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model='mapApply.map_process_type' name='map_process_type' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_map_process_type') }}</option>
                        @foreach ($mapProcessTypes as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.map_process_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='fiscal_year_id'>{{ __('ebps::ebps.fiscal_year') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model='mapApply.fiscal_year_id' name='fiscal_year_id' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_fiscal_year') }}</option>
                        @foreach ($fiscalYears as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.fiscal_year_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='applied_date'>{{ __('ebps::ebps.applied_date') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.applied_date' name='applied_date' type='text'
                        class='form-control nepali-date' placeholder="{{ __('ebps::ebps.enter_applied_date') }}">
                    <div>
                        @error('mapApply.applied_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='registration_no'>{{ __('ebps::ebps.registration_number') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.registration_no' id="registration_no" name='registration_no'
                        type='number' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_registration_number') }}">
                    <div>
                        @error('mapApply.registration_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='registration_date'>{{ __('ebps::ebps.registration_date') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.registration_date' id="registration_date" name='registration_date'
                        type='text' class='form-control nepali-date'
                        placeholder="{{ __('ebps::ebps.enter_registration_date') }}">
                    <div>
                        @error('mapApply.registration_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.house_owner_details') }}</div>
            </div>

            @if ($action === App\Enums\Action::CREATE)
                <livewire:phone_search />
            @endif

            <div class="row">

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='owner_name'>{{ __('ebps::ebps.house_owner') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model.defer='houseOwnerDetail.owner_name' id="owner_name" name='owner_name'
                            type='text' class='form-control' placeholder='घर धनीको नाम'>
                        <div>
                            @error('houseOwnerDetail.owner_name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='mobile_no'>{{ __('ebps::ebps.phone_number') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model='houseOwnerDetail.mobile_no' id="mobile_no" name='mobile_no' type='number'
                            class='form-control' placeholder='फोन नं.'>
                        <div>
                            @error('houseOwnerDetail.mobile_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='father_name'>{{ __('ebps::ebps.father_name') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model='houseOwnerDetail.father_name' id="father_name" name='father_name'
                            type='text' class='form-control' placeholder='बुबाको नाम'>
                        <div>
                            @error('houseOwnerDetail.father_name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label"
                            for='grandfather_name'>{{ __('ebps::ebps.grandfather_name') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model.defer='houseOwnerDetail.grandfather_name' id="grandfather_name"
                            name='grandfather_name' type='text' class='form-control'
                            placeholder='हजुरबुबाको नाम'>
                        <div>
                            @error('houseOwnerDetail.grandfather_name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('ebps::ebps.document_details') }}</div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label"
                            for='citizenship_issued_at'>{{ __('ebps::ebps.citizenship_issued_district') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model.defer='houseOwnerDetail.citizenship_issued_at' id="citizenship_issued_at"
                            name='citizenship_issued_at' class='form-control'>
                            <option value=''>--- जिल्ला छान्नुहोस् ---</option>
                            @foreach ($issuedDistricts as $district)
                                <option value="{{ $district->id }}">{{ $district->title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('houseOwnerDetail.citizenship_issued_at')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label"
                            for='citizenship_no'>{{ __('ebps::ebps.citizenship_number') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model.defer='houseOwnerDetail.citizenship_no' id="citizenship_no"
                            name='citizenship_no' type='text' class='form-control' placeholder='नागरिकता नम्बर'>
                        <div>
                            @error('houseOwnerDetail.citizenship_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label"
                            for='citizenship_issued_date'>{{ __('ebps::ebps.citizenship_issue_date') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model.defer='houseOwnerDetail.citizenship_issued_date'
                            id="house_owner_citizenship_issued_date" name='citizenship_issued_date' type='text'
                            class='form-control nepali-date'>
                        <div>
                            @error('houseOwnerDetail.citizenship_issued_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('ebps::ebps.address') }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="province_id" class="form-label">{{ __('ebps::ebps.province') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model.live="houseOwnerDetail.province_id" name="province_id"
                            wire:change="getDistricts"
                            class="form-control {{ $errors->has('houseOwnerDetail.province_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('houseOwnerDetail.province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            >
                            <option value="" selected hidden>{{ __('ebps::ebps.select_province') }}</option>
                            <!-- Placeholder -->
                            @foreach ($provinces as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('houseOwnerDetail.province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="district_id" class="form-label">{{ __('ebps::ebps.district') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="houseOwnerDetail.district_id" name="district_id"
                            wire:key="houseOwnerDetail_{{ $houseOwnerDetail->province_id }}"
                            wire:change="getLocalBodies"
                            class="form-control {{ $errors->has('houseOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('houseOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">

                            <option value="" selected hidden>{{ __('ebps::ebps.select_district') }}</option>
                            @foreach ($districts as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach


                        </select>
                        <div>
                            @error('houseOwnerDetail.district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="local_body_id" class="form-label">{{ __('ebps::ebps.local_body') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="houseOwnerDetail.local_body_id" name="local_body_id"
                            class="form-control {{ $errors->has('houseOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('houseOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:key="houseOwnerDetail_{{ $houseOwnerDetail->district_id }}"
                            wire:change="getWards">
                            <option value="" selected hidden>{{ __('ebps::ebps.select_local_body') }}</option>
                            @foreach ($localBodies as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('houseOwnerDetail.local_body_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="ward_no" class="form-label">{{ __('ebps::ebps.ward') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="houseOwnerDetail.ward_no" name="ward_no"
                            class="form-control {{ $errors->has('houseOwnerDetail.ward_no') ? 'is-invalid' : '' }}"
                            wire:key="houseOwnerDetail_{{ $houseOwnerDetail->local_body_id }}"
                            style="{{ $errors->has('houseOwnerDetail.ward_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            <option value="" selected hidden>{{ __('ebps::ebps.select_ward') }}</option>
                            @foreach ($wards as $id => $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('houseOwnerDetail.ward_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>


            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='signature'>{{ __('ebps::ebps.house_owner_photo') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model="houseOwnerPhoto" name="houseOwnerPhoto" type="file"
                        class="form-control {{ $errors->has('houseOwnerPhoto') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('houseOwnerPhoto') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        accept="image/*,.pdf">
                    <div>
                        @error('houseOwnerPhoto')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                        @if (
                            ($houseOwnerPhoto && $houseOwnerPhoto instanceof \Livewire\TemporaryUploadedFile) ||
                                $houseOwnerPhoto instanceof \Illuminate\Http\File ||
                                $houseOwnerPhoto instanceof \Illuminate\Http\UploadedFile)
                            <a href="{{ $houseOwnerPhoto->temporaryUrl() }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @elseif (!empty(trim($houseOwnerPhoto)))
                            <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $houseOwnerPhoto, 'local', 'tempUrl') }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='signature'>{{ __('ebps::ebps.signature') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model="uploadedImage" name="uploadedImage" type="file"
                        class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('uploadedImage2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        accept="image/*,.pdf">
                    <div>
                        @error('uploadedImage')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                        @if (
                            ($uploadedImage && $uploadedImage instanceof \Livewire\TemporaryUploadedFile) ||
                                $uploadedImage instanceof \Illuminate\Http\File ||
                                $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                            <a href="{{ $uploadedImage->temporaryUrl() }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @elseif (!empty(trim($uploadedImage)))
                            <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $uploadedImage, 'local', 'tempUrl') }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.construction_details') }}</div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='construction_type_id'>{{ __('ebps::ebps.construction_type') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model='mapApply.construction_type_id' name='construction_type_id'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'>
                        <option value="" hidden>{{ __('ebps::ebps.select_construction_type') }}</option>
                        @foreach ($constructionTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.construction_type_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='usage'>{{ __('ebps::ebps.usage') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model='mapApply.usage' name='usage' class='form-control'>
                        <option value="" hidden>{{ __('ebps::ebps.select_usage') }}</option>
                        @foreach ($usageOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.usage')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='building_structure'>{{ __('ebps::ebps.building_structure') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model='mapApply.building_structure' name='building_structure' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_building_structure') }}</option>
                        @foreach ($buildingStructures as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.building_structure')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text">{{ __('ebps::ebps.required_documents') }}</div>
            </div>

            <div class="text-end mb-3">
                <button type="button" wire:click="addDocument" class="btn btn-sm btn-primary">
                    <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_document') }}
                </button>
            </div>

            @php
                $reindexedFiles = array_values($uploadedFiles);
            @endphp

            @foreach ($mapDocuments as $index => $document)
                @php
                    $filePath = $reindexedFiles[$index] ?? null;

                @endphp

                <div class="row align-items-end border rounded p-3 mb-3 position-relative">
                    <div class="row">


                        <div class='col-md-5 mb-3'>
                            <div class='form-group'>
                                <label class="form-label">{{ __('ebps::ebps.document_name') }}</label>
                                <input type="text" class="form-control"
                                    wire:model="mapDocuments.{{ $index }}.title"
                                    placeholder="{{ __('ebps::ebps.document_name') }}">

                            </div>
                        </div>

                        <div class='col-md-5 mb-3'>
                            <div class='form-group'>
                                <label class="form-label">{{ __('ebps::ebps.upload_file') }}</label>
                                <input wire:model="uploadedFiles.{{ $index }}" type="file"
                                    class="form-control {{ $errors->has('uploadedFiles.' . $index) ? 'is-invalid' : '' }}"
                                    accept="image/*,.pdf">
                                @error("uploadedFiles.$index")
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror

                                @if (isset($reindexedFiles[$index]) &&
                                        ($reindexedFiles[$index] instanceof \Livewire\TemporaryUploadedFile ||
                                            $reindexedFiles[$index] instanceof \Illuminate\Http\File ||
                                            $reindexedFiles[$index] instanceof \Illuminate\Http\UploadedFile))
                                    <a href="{{ $reindexedFiles[$index]->temporaryUrl() }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-file"></i>
                                        {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
                                @elseif (!empty($filePath))
                                    <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $filePath, 'local', 'tempUrl') }}"
                                        target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-file"></i>
                                        {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2 mb-3 text-end">
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="removeDocuments({{ $index }})">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ __('ebps::ebps.save') }}</button>
        <a href="{{ route('admin.ebps.old_applications.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
    </div>
</form>
