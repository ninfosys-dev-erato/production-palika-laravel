<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='material_rate_id'>Material Rate Id</label>
                <input wire:model='materialCollection.material_rate_id' name='material_rate_id' type='text' class='form-control' placeholder='Enter Material Rate Id'>
                <div>
                    @error('materialCollection.material_rate_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='unit_id'>Unit Id</label>
                <input wire:model='materialCollection.unit_id' name='unit_id' type='text' class='form-control' placeholder='Enter Unit Id'>
                <div>
                    @error('materialCollection.unit_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='activity_no'>Activity No</label>
                <input wire:model='materialCollection.activity_no' name='activity_no' type='text' class='form-control' placeholder='Enter Activity No'>
                <div>
                    @error('materialCollection.activity_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='remarks'>Remarks</label>
                <input wire:model='materialCollection.remarks' name='remarks' type='text' class='form-control' placeholder='Enter Remarks'>
                <div>
                    @error('materialCollection.remarks')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='materialCollection.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('materialCollection.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.material_collections.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
