<form wire:submit.prevent="save">
    @if ($action === App\Enums\Action::CREATE)
        <livewire:phone_search />
    @endif

    <div class="row">


        <div class='col-md-4 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='owner_name'>{{ __('ebps::ebps.house_owner') }}</label>
                <span class="text-danger">*</span>
                <input wire:model.defer='houseOwnerDetail.owner_name' id="owner_name" name='owner_name' type='text'
                    class='form-control' placeholder='घर धनीको नाम'>
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
                <input wire:model='houseOwnerDetail.father_name' id="father_name" name='father_name' type='text'
                    class='form-control' placeholder='बुबाको नाम'>
                <div>
                    @error('houseOwnerDetail.father_name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class='col-md-4 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='grandfather_name'>{{ __('ebps::ebps.grandfather_name') }}</label>
                <span class="text-danger">*</span>
                <input wire:model.defer='houseOwnerDetail.grandfather_name' id="grandfather_name"
                    name='grandfather_name' type='text' class='form-control' placeholder='हजुरबुबाको नाम'>
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
                <label class="form-label" for='citizenship_no'>{{ __('ebps::ebps.citizenship_number') }}</label>
                <span class="text-danger">*</span>
                <input wire:model.defer='houseOwnerDetail.citizenship_no' id="citizenship_no" name='citizenship_no'
                    type='text' class='form-control' placeholder='नागरिकता नम्बर'>
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
                <select wire:model.live="houseOwnerDetail.province_id" name="province_id" wire:change="getDistricts"
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
                <select wire:model="houseOwnerDetail.district_id" name="district_id" wire:change="getLocalBodies"
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

    {{-- @endif --}}


    <div class='col-md-12 mb-3'>
        <div class='form-group'>
            <label class="form-label" for='signature'>{{ __('ebps::ebps.signature') }}</label>
            <span class="text-danger">*</span>
            <input wire:model="uploadedImage" name="uploadedImage" type="file"
                class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                style="{{ $errors->has('uploadedImage2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                accept="image/*">
            <div>
                @error('uploadedImage')
                    <small class='text-danger'>{{ $message }}</small>
                @enderror
                @if (
                    ($uploadedImage && $uploadedImage instanceof \Livewire\TemporaryUploadedFile) ||
                        $uploadedImage instanceof \Illuminate\Http\File ||
                        $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                    <img src="{{ $uploadedImage->temporaryUrl() }}" alt="Uploaded Image 1 Preview"
                        class="img-thumbnail mt-2" style="height: 300px;">
                @elseif (!empty(trim($uploadedImage)))
                    <img src="{{ customAsset(config('src.Ebps.ebps.path'), $uploadedImage) }}" alt="Existing Image 2"
                        class="img-thumbnail mt-2" style="height: 300px;">
                @endif
            </div>
        </div>
    </div>
</form>
