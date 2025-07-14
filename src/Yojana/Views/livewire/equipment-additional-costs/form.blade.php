<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='equipment_id'>Equipment Id</label>
                <input wire:model='equipmentAdditionalCost.equipment_id' name='equipment_id' type='text' class='form-control' placeholder='Enter Equipment Id'>
                <div>
                    @error('equipmentAdditionalCost.equipment_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='equipmentAdditionalCost.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('equipmentAdditionalCost.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='unit_id'>Unit Id</label>
                <input wire:model='equipmentAdditionalCost.unit_id' name='unit_id' type='text' class='form-control' placeholder='Enter Unit Id'>
                <div>
                    @error('equipmentAdditionalCost.unit_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate'>Rate</label>
                <input wire:model='equipmentAdditionalCost.rate' name='rate' type='text' class='form-control' placeholder='Enter Rate'>
                <div>
                    @error('equipmentAdditionalCost.rate')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.equipment_additional_costs.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
