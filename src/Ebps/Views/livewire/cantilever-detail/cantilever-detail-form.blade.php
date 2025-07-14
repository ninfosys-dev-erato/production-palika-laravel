<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='map_apply_id'>Map Apply Id</label>
                <input wire:model='cantileverDetail.map_apply_id' name='map_apply_id' type='text' class='form-control' placeholder='Enter Map Apply Id'>
                <div>
                    @error('cantileverDetail.map_apply_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='direction'>Direction</label>
                <input wire:model='cantileverDetail.direction' name='direction' type='text' class='form-control' placeholder='Enter Direction'>
                <div>
                    @error('cantileverDetail.direction')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='distance'>Distance</label>
                <input wire:model='cantileverDetail.distance' name='distance' type='text' class='form-control' placeholder='Enter Distance'>
                <div>
                    @error('cantileverDetail.distance')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='minimum'>Minimum</label>
                <input wire:model='cantileverDetail.minimum' name='minimum' type='text' class='form-control' placeholder='Enter Minimum'>
                <div>
                    @error('cantileverDetail.minimum')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.cantilever_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
