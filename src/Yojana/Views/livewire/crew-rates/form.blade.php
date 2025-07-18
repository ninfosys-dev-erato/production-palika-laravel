<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='labour_id'>Labour Id</label>
                <input wire:model='crewRate.labour_id' name='labour_id' type='text' class='form-control' placeholder='Enter Labour Id'>
                <div>
                    @error('crewRate.labour_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='equipment_id'>Equipment Id</label>
                <input wire:model='crewRate.equipment_id' name='equipment_id' type='text' class='form-control' placeholder='Enter Equipment Id'>
                <div>
                    @error('crewRate.equipment_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input wire:model='crewRate.quantity' name='quantity' type='text' class='form-control' placeholder='Enter Quantity'>
                <div>
                    @error('crewRate.quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.crew_rates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
