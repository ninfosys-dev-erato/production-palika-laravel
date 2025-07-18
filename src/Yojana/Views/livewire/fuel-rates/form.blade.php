<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='fuel_id'>Fuel Id</label>
                <input wire:model='fuelRate.fuel_id' name='fuel_id' type='text' class='form-control' placeholder='Enter Fuel Id'>
                <div>
                    @error('fuelRate.fuel_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate'>Rate</label>
                <input wire:model='fuelRate.rate' name='rate' type='text' class='form-control' placeholder='Enter Rate'>
                <div>
                    @error('fuelRate.rate')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='has_included_vat'>Has Included Vat</label>
                <input wire:model='fuelRate.has_included_vat' name='has_included_vat' type='text' class='form-control' placeholder='Enter Has Included Vat'>
                <div>
                    @error('fuelRate.has_included_vat')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.fuel_rates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
