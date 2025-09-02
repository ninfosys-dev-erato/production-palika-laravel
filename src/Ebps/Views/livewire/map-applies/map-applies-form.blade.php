<div>
    <div class="card-body">
        <div class="row">

            @if ($action === App\Enums\Action::UPDATE)
                <div class='col-md-4 mb-3'>
                    <label class="form-label" for="name">{{ __('ebps::ebps.submission_number') }}</label>
                    <input type="text" readonly class="form-control" value="{{ $mapApply->submission_id }}">
                </div>
            @endif

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='applied_date'>{{ __('ebps::ebps.applied_date') }}</label>
                    <input wire:model='mapApply.applied_date' id="applied_date" name='applied_date' type='text'
                        class='form-control nepali-date' placeholder="{{ __('ebps::ebps.enter_applied_date') }} ">
                    <div>
                        @error('mapApply.applied_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <div class="form-group">
                        <label class="form-label" for="organization">{{ __('ebps::ebps.select_organization') }}</label>
                        <select wire:model="mapApplyDetail.organization_id" class="form-control" id="organization">
                            <option value="">{{ __('ebps::ebps.select_organization') }}</option>
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->org_name_ne }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('mapApplyDetail.organization_id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="row">
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
                                    <option value=''>जिल्ला छान्नुहोस्</option>
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
                                    wire:key="houseOwnerDetail_{{ $houseOwnerDetail->province_id }}"
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
                                    wire:key="houseOwnerDetail_{{ $houseOwnerDetail->district_id }}"
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
                                    wire:key="houseOwnerDetail_{{ $houseOwnerDetail->local_body_id }}"
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
                                    accept="image/*,.pdf">
                                <div wire:loading wire:target="houseOwnerPhoto">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Uploading...
                                </div>
                                <div>
                                    @error('houseOwnerPhoto')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                    @if (!empty($houseOwnerPhotoUrl))
                                        <a href="{{ $houseOwnerPhotoUrl }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-file"></i>
                                            {{ __('yojana::yojana.view_uploaded_file') }}
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='signature'>{{ __('ebps::ebps.signature') }}</label>
                    <input wire:model="uploadedImage" name="uploadedImage" type="file"
                        class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('uploadedImage2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        accept="image/*,.pdf">
                    <div wire:loading wire:target="uploadedImage">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    <div>
                        @error('uploadedImage')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                        @if (!empty($uploadedImageUrl))
                            <a href="{{ $uploadedImageUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.land_details') }}</div>
            </div>

            <div class="col-md-6 mb-4">
                <label for="former_local_body">{{ __('ebps::ebps.former_local_body') }}</label>
                <input id="former_local_body" wire:model="customerLandDetail.former_local_body"
                    name="customerLandDetail.former_local_body" type="text" class="form-control"
                    placeholder="{{ __('ebps::ebps.enter_former_local_body') }}">
                @error('customerLandDetail.former_local_body')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label for="former_ward_no">{{ __('ebps::ebps.former_ward_no') }}</label>
                <input id="former_ward_no" name="customerLandDetail.former_ward_no" type="text"
                    class="form-control" wire:model="customerLandDetail.former_ward_no"
                    placeholder="{{ __('ebps::ebps.enter_former_ward_no') }}">
                @error('customerLandDetail.former_ward_no')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="local_body_id">{{ __('ebps::ebps.local_body') }}</label>
                    <select id="local_body_id" wire:model="customerLandDetail.local_body_id"
                        name="customerLandDetail.local_body_id" class="form-control" wire:change="loadWards">

                        <option value="">{{ __('ebps::ebps.choose_local_body') }}</option>

                        @foreach ($localBodies as $id => $title)
                            <option value="{{ $id }}">{{ $title }}
                            </option>
                        @endforeach
                    </select>
                    @error('customerLandDetail.local_body_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="ward_id">{{ __('ebps::ebps.ward') }}</label>
                    <select id="ward_id" name="customerLandDetail.ward" class="form-control"
                        wire:model="customerLandDetail.ward">
                        <option value="">{{ __('ebps::ebps.choose_ward') }}</option>
                        @foreach ($wards as $id => $title)
                            <option value="{{ $title }}">{{ $title }}
                            </option>
                        @endforeach
                    </select>
                    @error('customerLandDetail.ward')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='tole'>{{ __('ebps::ebps.tole') }}</label>
                        <input wire:model='customerLandDetail.tole' name='tole' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_tole') }}">
                        <div>
                            @error('customerLandDetail.tole')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='area_sqm'>{{ __('ebps::ebps.area_sqm') }}</label>
                        <input wire:model='customerLandDetail.area_sqm' name='area_sqm' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_area_sqm') }}">
                        <div>
                            @error('customerLandDetail.area_sqm')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                        <input wire:model='customerLandDetail.lot_no' name='lot_no' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                        <div>
                            @error('customerLandDetail.lot_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='seat_no'>{{ __('ebps::ebps.seat_no') }}</label>
                        <input wire:model='customerLandDetail.seat_no' name='seat_no' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_seat_no') }}">
                        <div>
                            @error('customerLandDetail.seat_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='ownership'>{{ __('ebps::ebps.ownership') }}</label>
                        <select wire:model='customerLandDetail.ownership' name='ownership' class='form-control'>
                            <option value="">{{ __('ebps::ebps.select_ownership') }}</option>
                            @foreach ($ownerships as $ownership)
                                <option value="{{ $ownership->value }}">
                                    {{ $ownership->label() }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('customerLandDetail.ownership')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class=" d-flex justify-content-between mb-4">
                <label class="form-label" for="form-label">
                    {{ __('ebps::ebps.four_boundaries') }}
                </label>
                <button type="button" class="btn btn-primary" wire:click='addFourBoundaries'
                    {{ count($fourBoundaries) >= 4 ? 'disabled' : '' }}>
                    + {{ __('ebps::ebps.add_four_boundaries') }}
                </button>
            </div>

            @foreach ($fourBoundaries as $index => $boundary)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='title'>{{ __('ebps::ebps.title') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.title'
                                                name='fourBoundaries.{{ $index }}.title' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_title') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.title')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='direction'>{{ __('ebps::ebps.direction') }}</label>
                                            <select wire:model='fourBoundaries.{{ $index }}.direction'
                                                name='fourBoundaries.{{ $index }}.direction'
                                                class='form-control'>
                                                <option value="">
                                                    {{ __('ebps::ebps.select_direction') }}</option>
                                                @foreach ($this->getAvailableDirections($index) as $direction)
                                                    <option value="{{ $direction->value }}">
                                                        {{ $direction->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            @error('fourBoundaries.{{ $index }}.direction')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='distance'>{{ __('ebps::ebps.distance') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.distance'
                                                name='fourBoundaries.{{ $index }}.distance' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_distance') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.distance')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.lot_no'
                                                name='fourBoundaries.{{ $index }}.lot_no' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.lot_no')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end align-items-center mb-3">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeFourBoundaries({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.construction_details') }}</div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='construction_type_id'>{{ __('ebps::ebps.construction_type') }}</label>
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
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='usage'>{{ __('ebps::ebps.usage') }}</label>
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

            @if ($action === App\Enums\Action::CREATE)
                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text">{{ __('ebps::ebps.required_documents') }}</div>
                </div>

                @php
                    $reindexedFiles = array_values($uploadedFiles);

                @endphp

                @foreach ($mapDocuments as $index => $document)
                    @php
                        $filePath = $reindexedFiles[$index] ?? null;
                    @endphp

                    <div class="row">
                        <div class='col-md-6 mb-3'>
                            <div class='form-group'>
                                <label class="form-label">{{ __('ebps::ebps.document_name') }}</label>
                                <input type="text" class="form-control" value="{{ $document->title }}" readonly>
                            </div>
                        </div>

                        <div class='col-md-6 mb-3'>
                            <div class='form-group'>
                                <label class="form-label">{{ __('ebps::ebps.upload_file') }}</label>
                                <input wire:model="uploadedFiles.{{ $index }}" type="file"
                                    class="form-control {{ $errors->has('uploadedFiles.' . $index) ? 'is-invalid' : '' }}"
                                    accept="image/*,application/pdf">
                                <div wire:loading wire:target="uploadedFiles.{{ $index }}">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Uploading...
                                </div>
                                <div>
                                    @error("uploadedFiles.$index")
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror

                                    @if (isset($uploadedFilesUrls[$index]) && !empty($uploadedFilesUrls[$index]))
                                        <a href="{{ $uploadedFilesUrls[$index] }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-file"></i>
                                            {{ __('yojana::yojana.view_uploaded_file') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text">{{ __('ebps::ebps.more_documents') }}</div>
            </div>

            <div class="col-md-12">
                <div class="d-flex justify-content-start mt-3 pb-2">
                    <p class="btn btn-info" wire:click="addDocument"><i
                            class="bx bx-plus"></i>{{ __('ebps::ebps.add_documents') }}</p>
                </div>

                @if ($documents)
                    <div class="list-group">
                        @foreach ($documents as $key => $document)
                            <div class="list-group-item list-group-item-action py-3 px-4 rounded shadow-sm"
                                wire:key="doc-{{ $key }}">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.document_name') }}</label>
                                            <input
                                                dusk="businessregistration-documents.{{ $key }}.title-field"
                                                type="text" class="form-control"
                                                wire:model="documents.{{ $key }}.title"
                                                placeholder="{{ __('ebps::ebps.enter_document_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.upload_document') }}</label>
                                            <input type="file" class="form-control-file"
                                                wire:model="documents.{{ $key }}.document"
                                                accept="image/*,application/pdf">

                                            <div wire:loading wire:target="documents.{{ $key }}.document">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Uploading...
                                            </div>

                                            @if (isset($documents[$key]['url']) && !empty($documents[$key]['url']))
                                                <p>
                                                    <a href="{{ $documents[$key]['url'] }}" target="_blank">
                                                        <i class="bx bx-file"></i> {{ $documents[$key]['title'] }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" wire:target="documents.{{ $key }}.document">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.document_status') }}</label>
                                            <select
                                                dusk="businessregistration-documents.{{ $key }}.status-field"
                                                wire:model.defer="documents.{{ $key }}.status"
                                                id="documents.{{ $key }}.status" class="form-control">
                                                @foreach ($options as $k => $v)
                                                    <option value="{{ $k }}">{{ $v }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="btn-group-vertical">
                                            <button class="btn btn-danger"
                                                wire:click="removeDocument({{ $key }})">
                                                <i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>


        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" wire:click="save">{{ __('ebps::ebps.save') }}</button>
        <a href="{{ route('admin.ebps.map_applies.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
    </div>
</div>
