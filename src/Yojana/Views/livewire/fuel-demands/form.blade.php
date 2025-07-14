<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='fuel_id'>Fuel Id</label>
                <input wire:model='fuelDemand.fuel_id' name='fuel_id' type='text' class='form-control' placeholder='Enter Fuel Id'>
                <div>
                    @error('fuelDemand.fuel_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='equipment_id'>Equipment Id</label>
                <input wire:model='fuelDemand.equipment_id' name='equipment_id' type='text' class='form-control' placeholder='Enter Equipment Id'>
                <div>
                    @error('fuelDemand.equipment_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input wire:model='fuelDemand.quantity' name='quantity' type='text' class='form-control' placeholder='Enter Quantity'>
                <div>
                    @error('fuelDemand.quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.fuel_demands.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
