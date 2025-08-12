<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='employee_id'>Employee</label>
                    <select wire:model="vehicle.employee_id" name="employee_id" class="form-control">
                        <option value="" hidden>Select Employee</option>
                        @foreach ($employees as $employee)
                            <option value={{ $employee->id }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('vehicle.employee_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='vehicle_category_id'>Vehicle Category</label>
                    <select wire:model='vehicle.vehicle_category_id' name="vehicle_category_id" class="form-control">
                        <option value="" hidden>Select Vehicle Category</option>
                        @foreach ($vehicleCategory as $category)
                            <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('vehicle.vehicle_category_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='vehicle_number'>Vehicle Number</label>
                    <input wire:model='vehicle.vehicle_number' name='vehicle_number' type='text' class='form-control'
                        placeholder='Enter Vehicle Number'>
                    <div>
                        @error('vehicle.vehicle_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='chassis_number'>Chassis Number</label>
                    <input wire:model='vehicle.chassis_number' name='chassis_number' type='text' class='form-control'
                        placeholder='Enter Chassis Number'>
                    <div>
                        @error('vehicle.chassis_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='engine_number'>Engine Number</label>
                    <input wire:model='vehicle.engine_number' name='engine_number' type='text' class='form-control'
                        placeholder='Enter Engine Number'>
                    <div>
                        @error('vehicle.engine_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='fuel_type'>Fuel Type</label>
                    <select wire:model='vehicle.fuel_type' name="fuel_type" class="form-control">
                        <option value="">{{ __('Select Fuel Type') }}</option>
                        <option value="diesel">{{ __('Diesel') }}</option>
                        <option value="petrol">{{ __('Petrol') }}</option>
                        <option value="electric">{{ __('Electric') }}</option>

                    </select>
                    <div>
                        @error('vehicle.fuel_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='driver_name'>Driver Name</label>
                    <input wire:model='vehicle.driver_name' name='driver_name' type='text' class='form-control'
                        placeholder='Enter Driver Name'>
                    <div>
                        @error('vehicle.driver_name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='license_number'>License Number</label>
                    <input wire:model='vehicle.license_number' name='license_number' type='text' class='form-control'
                        placeholder='Enter License Number'>
                    <div>
                        @error('vehicle.license_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>






            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='license_photo'>License Photo</label>
                    <input wire:model='license_photo' name='license_photo' type='file' class='form-control'
                        accept=".jpg,.jpeg,.png">
                    <div>
                        @error('license_photo')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='signature'>Signature</label>
                    <input wire:model='signature' name='signature' type='file' class='form-control'
                        placeholder='Enter Signature' accept=".jpg,.jpeg,.png">

                    <div>
                        @error('signature')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='driver_contact_no'>Driver Contact No</label>
                    <input wire:model='vehicle.driver_contact_no' name='driver_contact_no' type='text'
                        class='form-control' placeholder='Enter Driver Contact No'>
                    <div>
                        @error('vehicle.driver_contact_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='vehicle_detail'>Vehicle Detail</label>
                    <input wire:model='vehicle.vehicle_detail' name='vehicle_detail' type='text'
                        class='form-control' placeholder='Enter Vehicle Detail'>
                    <div>
                        @error('vehicle.vehicle_detail')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{ route('admin.vehicles.index') }}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>




    @if ($license_photo)
        <img src="{{ $license_photo->temporaryUrl() }}" alt="Uploaded Image Preview" class="img-thumbnail mt-2"
            style="height: 300px;">
    @endif

    @if ($signature)
        <img src="{{ $signature->temporaryUrl() }}" alt="Uploaded Image Preview" class="img-thumbnail mt-2"
            style="height: 300px;">
    @endif
    {{-- 
    @if ($vehicle . license_photo){
        <img src="{{ customFileAsset(config('src.EmergencyContacts.emergencyContact.icon_path'), $row->icon, 'local', 'tempUrl') }}"
            alt="" style="height: 300px;">
        } --}}

</form>
