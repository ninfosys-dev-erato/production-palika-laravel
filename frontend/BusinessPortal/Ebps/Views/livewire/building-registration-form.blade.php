<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='applied_date'>{{ __('ebps::ebps.applied_date') }}</label>
                    <input wire:model='mapApply.applied_date' id="applied_date" name='applied_date' type='text'
                        class='nepali-date form-control' placeholder="{{ __('ebps::ebps.enter_applied_date') }}">
                    <div>
                        @error('mapApply.applied_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            @if ($action === App\Enums\Action::UPDATE)
                <div class='col-md-4 mb-3'>
                    <label for="name">{{ __('ebps::ebps.submission_number') }}</label>
                    <input type="text" readonly class="form-control" value="{{ $mapApply->submission_id }}">
                </div>
            @endif

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('प्रस्तावित भवनको विवरण') }}</div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='area_of_building_plinth'>{{ __('ebps::ebps.area_of_building_plinth') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.area_of_building_plinth' name='area_of_building_plinth' type='text'
                        class='form-control' placeholder="{{ __('ebps::ebps.enter_area_of_building_plinth') }}">
                    <div>
                        @error('mapApply.area_of_building_plinth')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='no_of_rooms'>{{ __('ebps::ebps.number_of_rooms') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.no_of_rooms' name='no_of_rooms' type='text' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_area_number_of_rooms') }}">
                    <div>
                        @error('mapApply.no_of_rooms')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='storey_no'>{{ __('ebps::ebps.floor_number') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.storey_no' name='storey_no' type='text' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_floor_number') }}">
                    <div>
                        @error('mapApply.storey_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='year_of_house_built'>{{ __('ebps::ebps.year_the_house_was_built') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.year_of_house_built' name='year_of_house_built' type='text'
                        class='form-control' placeholder="{{ __('ebps::ebps.enter_year_the_house_was_built') }}">
                    <div>
                        @error('mapApply.year_of_house_built')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
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
                <div class="divider-text ">{{ __('ebps::ebps.land_details') }}</div>
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
                        <input wire:model='customerLandDetail.area_sqm' name='area_sqm' type='number'
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
                        <input wire:model='customerLandDetail.lot_no' name='lot_no' type='number'
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
                        <input wire:model='customerLandDetail.seat_no' name='seat_no' type='number'
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
                <label class="form-label" for="form-label">{{ __('ebps::ebps.four_boundaries') }}</label>
                <button type="button" class="btn btn-info" wire:click='addFourBoundaries'>
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
                                                @foreach (\Src\Ebps\Enums\DirectionEnum::cases() as $direction)
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
                                                name='fourBoundaries.{{ $index }}.distance' type='number'
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
                <div class="divider-text ">{{ __('ebps::ebps.land_owner_details') }}</div>
            </div>

            @if ($action === App\Enums\Action::CREATE)
                <livewire:phone_search />
            @endif

            <div class="row">

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='owner_name'>{{ __('ebps::ebps.land_owner') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model.defer='landOwnerDetail.owner_name' id="owner_name" name='owner_name'
                            type='text' class='form-control' placeholder='घर धनीको नाम'>
                        <div>
                            @error('landOwnerDetail.owner_name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='mobile_no'>{{ __('ebps::ebps.phone_number') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model='landOwnerDetail.mobile_no' id="mobile_no" name='mobile_no' type='number'
                            class='form-control' placeholder='फोन नं.'>
                        <div>
                            @error('landOwnerDetail.mobile_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='father_name'>{{ __('ebps::ebps.father_name') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model='landOwnerDetail.father_name' id="father_name" name='father_name'
                            type='text' class='form-control' placeholder='बुबाको नाम'>
                        <div>
                            @error('landOwnerDetail.father_name')
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
                        <input wire:model.defer='landOwnerDetail.grandfather_name' id="grandfather_name"
                            name='grandfather_name' type='text' class='form-control'
                            placeholder='हजुरबुबाको नाम'>
                        <div>
                            @error('landOwnerDetail.grandfather_name')
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
                        <select wire:model.defer='landOwnerDetail.citizenship_issued_at' id="citizenship_issued_at"
                            name='citizenship_issued_at' class='form-control'>
                            <option value=''>जिल्ला छान्नुहोस्</option>
                            @foreach ($issuedDistricts as $district)
                                <option value="{{ $district->id }}">{{ $district->title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('landOwnerDetail.citizenship_issued_at')
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
                        <input wire:model.defer='landOwnerDetail.citizenship_no' id="citizenship_no"
                            name='citizenship_no' type='text' class='form-control' placeholder='नागरिकता नम्बर'>
                        <div>
                            @error('landOwnerDetail.citizenship_no')
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
                        <input wire:model.defer='landOwnerDetail.citizenship_issued_date' id="citizenship_issued_date"
                            name='land_owner_citizenship_issued_date' type='text'
                            class='form-control nepali-date'>
                        <div>
                            @error('landOwnerDetail.citizenship_issued_date')
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
                        <select wire:model="landOwnerDetail.province_id" name="province_id"
                            wire:change="getLandOwnerDistricts"
                            class="form-control {{ $errors->has('landOwnerDetail.province_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('landOwnerDetail.province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            >
                            <option value="" selected hidden>{{ __('ebps::ebps.select_province') }}</option>
                            <!-- Placeholder -->
                            @foreach ($landOwnerProvinces as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('landOwnerDetail.province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="district_id" class="form-label">{{ __('ebps::ebps.district') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="landOwnerDetail.district_id" name="district_id"
                            wire:key="landOwnerDetail_{{ $landOwnerDetail['province_id'] ?? '0' }}"
                            wire:change="getLandOwnerLocalBodies"
                            class="form-control {{ $errors->has('landOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('landOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">

                            <option value="" selected hidden>{{ __('ebps::ebps.select_district') }}</option>
                            @foreach ($landOwnerDistricts as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach


                        </select>
                        <div>
                            @error('landOwnerDetail.district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="local_body_id" class="form-label">{{ __('ebps::ebps.local_body') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="landOwnerDetail.local_body_id" name="local_body_id"
                            wire:key="landOwnerDetail_{{ $landOwnerDetail['district_id'] ?? '0' }}"
                            class="form-control {{ $errors->has('landOwnerDetail.local_body_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('landOwnerDetail.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:change="getLandOwnerWards">
                            <option value="" selected hidden>{{ __('ebps::ebps.select_local_body') }}</option>
                            @foreach ($landOwnerLocalBodies as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('landOwnerDetail.local_body_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="ward_no" class="form-label">{{ __('ebps::ebps.ward') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model="landOwnerDetail.ward_no" name="ward_no"
                            wire:key="landOwnerDetail_{{ $landOwnerDetail['local_body_id'] ?? '0' }}"
                            class="form-control {{ $errors->has('landOwnerDetail.ward_no') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('landOwnerDetail.ward_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            <option value="" selected hidden>{{ __('ebps::ebps.select_ward') }}</option>
                            @foreach ($landOwnerWards as $id => $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('landOwnerDetail.ward_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-12 mb-3'>
                    <div class='form-group'>
                        <label class="form-label" for='signature'>{{ __('ebps::ebps.land_owner_photo') }}</label>
                        <span class="text-danger">*</span>
                        <input wire:model="landOwnerPhoto" name="landOwnerPhoto" type="file"
                            class="form-control {{ $errors->has('landOwnerPhoto') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('landOwnerPhoto2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            accept="image/*">
                        <div>
                            @error('landOwnerPhoto')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                            @if (
                                ($landOwnerPhoto && $landOwnerPhoto instanceof \Livewire\TemporaryUploadedFile) ||
                                    $landOwnerPhoto instanceof \Illuminate\Http\File ||
                                    $landOwnerPhoto instanceof \Illuminate\Http\UploadedFile)
                                <img src="{{ $landOwnerPhoto->temporaryUrl() }}" alt="Uploaded Image 1 Preview"
                                    class="img-thumbnail mt-2" style="height: 300px;">
                            @elseif (!empty(trim($landOwnerPhoto)))
                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $landOwnerPhoto) }}"
                                    alt="Existing Image 2" class="img-thumbnail mt-2" style="height: 300px;">
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.house_owner_details') }}</div>
            </div>

            @if ($action === App\Enums\Action::CREATE)
                <div class="col-12 text-center mb-4">
                    <div class="form-check d-inline-block">
                        <input class="form-check-input" type="checkbox" id="isSame"
                            wire:click="isSameAsLandOwner">
                        <label class="form-check-label" for="isSame">
                            {{ __('ebps::ebps.is_land_owner_and_house_owner_same') }}
                        </label>
                    </div>
                </div>
            @endif


            @if (!$isSame)

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
                                id="houese_owner_citizenship_issued_date" name='citizenship_issued_date'
                                type='text' class='form-control nepali-date'>
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
                            <label for="local_body_id" class="form-label">{{ __('ebps::ebps.local_body') }}</label>
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
                                    <img src="{{ $houseOwnerPhoto->temporaryUrl() }}" alt="Uploaded Image 1 Preview"
                                        class="img-thumbnail mt-2" style="height: 300px;">
                                @elseif (!empty(trim($houseOwnerPhoto)))
                                    <img src="{{ customAsset(config('src.Ebps.ebps.path'), $houseOwnerPhoto) }}"
                                        alt="Existing Image 2" class="img-thumbnail mt-2" style="height: 300px;">
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            @endif

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.applicant_details') }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="applicant_type" class="form-label">{{ __('ebps::ebps.applicant_type') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model="mapApply.applicant_type" name="applicant_type"
                        wire:change='updateApplicantForm'
                        class="form-control {{ $errors->has('mapApply.applicant_type') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapApply.applicant_type') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="" selected hidden>{{ __('ebps::ebps.select_applicant_type') }}</option>
                        @foreach ($applicantTypes as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    </select>
                    <div>
                        @error('mapApply.applicant_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='full_name'>{{ __('ebps::ebps.full_name') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model.defer='mapApply.full_name' id="full_name" name='full_name' type='text'
                        class='form-control' placeholder='निवेदकको नाम'
                        @if (!$showNameAndNumber) readonly @endif>
                    <div>
                        @error('mapApply.full_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='mobile_no'>{{ __('ebps::ebps.phone_number') }}</label>
                    <span class="text-danger">*</span>
                    <input wire:model='mapApply.mobile_no' id="mobile_no" name='mobile_no' type='number'
                        class='form-control' placeholder='फोन नं.' @if (!$showNameAndNumber) readonly @endif>
                    <div>
                        @error('mapApply.mobile_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.applicant_address') }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="province_id" class="form-label">{{ __('ebps::ebps.province') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model.live="mapApply.province_id" name="province_id"
                        wire:change="getApplicantDistricts"
                        class="form-control {{ $errors->has('mapApply.province_id') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapApply.province_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        >
                        <option value="" selected hidden>{{ __('ebps::ebps.select_province') }}</option>
                        <!-- Placeholder -->
                        @foreach ($applicantProvinces as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.province_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="district_id" class="form-label">{{ __('ebps::ebps.district') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model="mapApply.district_id" name="district_id"
                        wire:change="getApplicantLocalBodies"
                        class="form-control {{ $errors->has('mapApply.local_body_id') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapApply.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">

                        <option value="" selected hidden>{{ __('ebps::ebps.select_district') }}</option>
                        @foreach ($applicantDistricts as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach


                    </select>
                    <div>
                        @error('mapApply.district_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="local_body_id" class="form-label">{{ __('ebps::ebps.local_body') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model="mapApply.local_body_id" name="local_body_id"
                        class="form-control {{ $errors->has('mapApply.local_body_id') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapApply.local_body_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        wire:change="getApplicantWards">
                        <option value="" selected hidden>{{ __('ebps::ebps.select_local_body') }}</option>
                        @foreach ($applicantLocalBodies as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.local_body_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="ward_no" class="form-label">{{ __('ebps::ebps.ward') }}</label>
                    <span class="text-danger">*</span>
                    <select wire:model="mapApply.ward_no" name="ward_no"
                        class="form-control {{ $errors->has('mapApply.ward_no') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapApply.ward_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="" selected hidden>{{ __('ebps::ebps.select_ward') }}</option>
                        @foreach ($applicantWards as $id => $title)
                            <option value="{{ $title }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.ward_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

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
                                accept="image/*">
                            <div>
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
                                    {{-- Show existing file if no new file is uploaded --}}
                                    <img src="{{ customAsset(config('src.Ebps.ebps.path'), $filePath) }}"
                                        alt="Existing Document Preview" class="img-thumbnail mt-2"
                                        style="height: 300px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($documents)

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text">{{ __('ebps::ebps.more_documents') }}</div>
                </div>


                <div class="col-md-12">
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
                                                placeholder="Enter document name">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.upload_document') }}</label>
                                            <input type="file" class="form-control-file"
                                                wire:model.defer="documents.{{ $key }}.file">

                                            <div wire:loading wire:target="documents.{{ $key }}.file">
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
                                    <div class="col-md-3" wire:target="documents.{{ $key }}.file">
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
                </div>
            @endif
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('ebps::ebps.save') }}</button>
            <a href="{{ route('admin.ebps.old_applications.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
        </div>
</form>
