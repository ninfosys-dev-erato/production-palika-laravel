<div>
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary fw-bold mb-0">{{ __('ebps::ebps.house_owner_form') }}</h5>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body">
                <livewire:phone_search />
                <div class="row">
                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">{{ __('ebps::ebps.house_owner_details') }}</div>
                    </div>

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
                                <input wire:model='houseOwnerDetail.mobile_no' id="mobile_no" name='mobile_no'
                                    type='number' class='form-control' placeholder='फोन नं.'>
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
                                <select wire:model.defer='houseOwnerDetail.citizenship_issued_at'
                                    id="citizenship_issued_at" name='citizenship_issued_at' class='form-control'>
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
                                    name='citizenship_no' type='text' class='form-control'
                                    placeholder='नागरिकता नम्बर'>
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
                                    id="citizenship_issued_date" name='citizenship_issued_date' type='text'
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
                                    wire:change="getHouseOwnerDistricts"
                                    class="form-control {{ $errors->has('houseOwnerDetail.province_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('houseOwnerDetail.province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    >
                                    <option value="" selected hidden>{{ __('ebps::ebps.select_province') }}
                                    </option>
                                    <!-- Placeholder -->
                                    @foreach ($houseOwnerProvinces as $id => $title)
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
                                    wire:change="getHouseOwnerLocalBodies"
                                    class="form-control {{ $errors->has('houseOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('houseOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">

                                    <option value="" selected hidden>{{ __('ebps::ebps.select_district') }}
                                    </option>
                                    @foreach ($houseOwnerDistricts as $id => $title)
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
                                <label for="local_body_id"
                                    class="form-label">{{ __('ebps::ebps.local_body') }}</label>
                                <span class="text-danger">*</span>
                                <select wire:model="houseOwnerDetail.local_body_id" name="local_body_id"
                                    class="form-control {{ $errors->has('houseOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('houseOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:change="getHouseOwnerWards">
                                    <option value="" selected hidden>{{ __('ebps::ebps.select_local_body') }}
                                    </option>
                                    @foreach ($houseOwnerLocalBodies as $id => $title)
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
                                    style="{{ $errors->has('houseOwnerDetail.ward_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                                    <option value="" selected hidden>{{ __('ebps::ebps.select_ward') }}</option>
                                    @foreach ($houseOwnerWards as $id => $title)
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

                        <div class='col-md-12 mb-3'>
                            <div class='form-group'>
                                <label class="form-label"
                                    for='signature'>{{ __('ebps::ebps.house_owner_photo') }}</label>
                                <span class="text-danger">*</span>
                                <input wire:model="houseOwnerPhoto" name="houseOwnerPhoto" type="file"
                                    class="form-control {{ $errors->has('houseOwnerPhoto') ? 'is-invalid' : '' }}"
                                    style="{{ $errors->has('houseOwnerPhoto') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    accept="image/*">
                                <div>
                                    @error('houseOwnerPhoto')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                    @if (
                                        ($houseOwnerPhoto && $houseOwnerPhoto instanceof \Livewire\TemporaryUploadedFile) ||
                                            $houseOwnerPhoto instanceof \Illuminate\Http\File ||
                                            $houseOwnerPhoto instanceof \Illuminate\Http\UploadedFile)
                                        <img src="{{ $houseOwnerPhoto->temporaryUrl() }}"
                                            alt="Uploaded Image 1 Preview" class="img-thumbnail mt-2"
                                            style="height: 300px;">
                                    @elseif (!empty(trim($houseOwnerPhoto)))
                                        <img src="{{ customFileAsset(config('src.Ebps.ebps.path'), $houseOwnerPhoto, 'local', 'tempUrl') }}"
                                            alt="Existing Image 2" class="img-thumbnail mt-2" style="height: 300px;">
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="divider divider-primary text-start text-primary font-14">
                            <div class="divider-text">{{ __('ebps::ebps.reason_of_owner_change') }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="reason" class="form-label">
                                    {{ __('ebps::ebps.reason') }}
                                </label>
                                <span class="text-danger">*</span>
                                <textarea id="reason_of_owner_change" name="houseOwnerDetail.reason_of_owner_change" class="form-control"
                                    rows="4" wire:model.defer="houseOwnerDetail.reason_of_owner_change"></textarea>

                                @error('houseOwnerDetail.reason_of_owner_change')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                                accept="image/*">
                                            @error("uploadedFiles.$index")
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror

                                            @if (isset($reindexedFiles[$index]) &&
                                                    ($reindexedFiles[$index] instanceof \Livewire\TemporaryUploadedFile ||
                                                        $reindexedFiles[$index] instanceof \Illuminate\Http\File ||
                                                        $reindexedFiles[$index] instanceof \Illuminate\Http\UploadedFile))
                                                <img src="{{ $reindexedFiles[$index]->temporaryUrl() }}"
                                                    alt="Uploaded Image Preview" class="img-thumbnail mt-2"
                                                    style="height: 300px;">
                                            @elseif (!empty($filePath))
                                                <img src="{{ customFileAsset(config('src.Ebps.ebps.path'), $filePath, 'local') }}"
                                                    alt="Existing Document Preview" class="img-thumbnail mt-2"
                                                    style="height: 300px;">
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
                    <div class="card-footer">
                        <button class="btn btn-primary">{{ __('ebps::ebps.save') }}</button>
                    </div>
                </div>
        </form>

        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title text-primary fw-bold mb-0">{{ __('ebps::ebps.old_house_owner_detail') }}</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">क्र.सं</th>
                                <th class="py-3">घर धनीको नाम</th>
                                <th class="py-3">फोन नं.</th>
                                <th class="py-3">नागरिकता नम्बर</th>
                                <th class="py-3">बुवाको नाम</th>
                                <th class="py-3">हजुरबुबाको नाम</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $owner = $mapApply->houseOwner;
                                $serial = 1;
                            @endphp

                            @if ($owner)
                                @while ($owner)
                                    <tr>
                                        <td class="py-3">{{ $serial++ }}</td>
                                        <td class="py-3">{{ $owner->owner_name }}</td>
                                        <td class="py-3">{{ $owner->mobile_no }}</td>
                                        <td class="py-3">{{ $owner->citizenship_no }}</td>
                                        <td class="py-3">{{ $owner->father_name }}</td>
                                        <td class="py-3">{{ $owner->grandfather_name }}</td>
                                    </tr>
                                    @php
                                        $owner = $owner->parent;
                                    @endphp
                                @endwhile
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bx bx-info-circle me-2 fs-4"></i>
                                        तालिकामा कुनै डाटा उपलब्ध छैन !!!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
