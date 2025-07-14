<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='material_id'>Material Id</label>
                <input wire:model='materialRate.material_id' name='material_id' type='text' class='form-control' placeholder='Enter Material Id'>
                <div>
                    @error('materialRate.material_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='materialRate.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('materialRate.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_vat_included'>Is Vat Included</label>
                <input wire:model='materialRate.is_vat_included' name='is_vat_included' type='text' class='form-control' placeholder='Enter Is Vat Included'>
                <div>
                    @error('materialRate.is_vat_included')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_vat_needed'>Is Vat Needed</label>
                <input wire:model='materialRate.is_vat_needed' name='is_vat_needed' type='text' class='form-control' placeholder='Enter Is Vat Needed'>
                <div>
                    @error('materialRate.is_vat_needed')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='referance_no'>Referance No</label>
                <input wire:model='materialRate.referance_no' name='referance_no' type='text' class='form-control' placeholder='Enter Referance No'>
                <div>
                    @error('materialRate.referance_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='royalty'>Royalty</label>
                <input wire:model='materialRate.royalty' name='royalty' type='text' class='form-control' placeholder='Enter Royalty'>
                <div>
                    @error('materialRate.royalty')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.material_rates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
