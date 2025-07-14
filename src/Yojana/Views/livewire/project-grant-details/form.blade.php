<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectGrantDetail.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectGrantDetail.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='grant_source'>Grant Source</label>
                <input wire:model='projectGrantDetail.grant_source' name='grant_source' type='text' class='form-control' placeholder='Enter Grant Source'>
                <div>
                    @error('projectGrantDetail.grant_source')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='asset_name'>Asset Name</label>
                <input wire:model='projectGrantDetail.asset_name' name='asset_name' type='text' class='form-control' placeholder='Enter Asset Name'>
                <div>
                    @error('projectGrantDetail.asset_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input wire:model='projectGrantDetail.quantity' name='quantity' type='text' class='form-control' placeholder='Enter Quantity'>
                <div>
                    @error('projectGrantDetail.quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='asset_unit'>Asset Unit</label>
                <input wire:model='projectGrantDetail.asset_unit' name='asset_unit' type='text' class='form-control' placeholder='Enter Asset Unit'>
                <div>
                    @error('projectGrantDetail.asset_unit')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_grant_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
