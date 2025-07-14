<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='map_apply_id'>Map Apply Id</label>
                <input wire:model='storeyDetail.map_apply_id' name='map_apply_id' type='text' class='form-control' placeholder='Enter Map Apply Id'>
                <div>
                    @error('storeyDetail.map_apply_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='storey_id'>Storey Id</label>
                <input wire:model='storeyDetail.storey_id' name='storey_id' type='text' class='form-control' placeholder='Enter Storey Id'>
                <div>
                    @error('storeyDetail.storey_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='purposed_area'>Purposed Area</label>
                <input wire:model='storeyDetail.purposed_area' name='purposed_area' type='text' class='form-control' placeholder='Enter Purposed Area'>
                <div>
                    @error('storeyDetail.purposed_area')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='former_area'>Former Area</label>
                <input wire:model='storeyDetail.former_area' name='former_area' type='text' class='form-control' placeholder='Enter Former Area'>
                <div>
                    @error('storeyDetail.former_area')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='height'>Height</label>
                <input wire:model='storeyDetail.height' name='height' type='text' class='form-control' placeholder='Enter Height'>
                <div>
                    @error('storeyDetail.height')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='remarks'>Remarks</label>
                <input wire:model='storeyDetail.remarks' name='remarks' type='text' class='form-control' placeholder='Enter Remarks'>
                <div>
                    @error('storeyDetail.remarks')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.storey_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
