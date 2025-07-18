<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='labourRate.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('labourRate.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='labour_id'>Labour Id</label>
                <input wire:model='labourRate.labour_id' name='labour_id' type='text' class='form-control' placeholder='Enter Labour Id'>
                <div>
                    @error('labourRate.labour_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate'>Rate</label>
                <input wire:model='labourRate.rate' name='rate' type='text' class='form-control' placeholder='Enter Rate'>
                <div>
                    @error('labourRate.rate')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.labour_rates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
