<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='ward_no'>Ward No</label>
                    <select wire:model='fuelSetting.ward_no' name='ward_no' class='form-control' wire:change='wardUser'>
                        <option value="" hidden>{{ __('Select a ward') }}</option>
                        @foreach ($wards as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='fuelSetting.ward_no' name='ward_no' type='text' class='form-control'
                    placeholder='Enter Ward No'> --}}
                    <div>
                        @error('fuelSetting.ward_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='acceptor_id'>Acceptor</label>
                    <select wire:model='fuelSetting.acceptor_id' name='acceptor_id' class='form-control'>
                        <option value="" hidden>{{ __('Select an acceptor') }}</option>
                        @foreach ($users as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='fuelSetting.acceptor_id' name='acceptor_id' type='text' class='form-control'
                        placeholder='Enter Acceptor Id'> --}}
                    <div>
                        @error('fuelSetting.acceptor_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='reviewer_id'>Reviewer</label>
                    <select wire:model='fuelSetting.reviewer_id' name='reviewer_id' class='form-control'>
                        <option value="" hidden>{{ __('Select a reviewer') }}</option>
                        @foreach ($users as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='fuelSetting.reviewer_id' name='reviewer_id' type='text' class='form-control'
                        placeholder='Enter Reviewer Id'> --}}
                    <div>
                        @error('fuelSetting.reviewer_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='expiry_days'>Expiry Days</label>
                    <input wire:model='fuelSetting.expiry_days' name='expiry_days' type='text' class='form-control'
                        placeholder='Enter Expiry Days'>
                    <div>
                        @error('fuelSetting.expiry_days')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
            <a href="{{ route('admin.fuel_settings.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">Back</a>
        </div>
</form>
