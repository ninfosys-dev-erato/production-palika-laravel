<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='map_apply_id'>Map Apply Id</label>
                <input wire:model='road.map_apply_id' name='map_apply_id' type='text' class='form-control' placeholder='Enter Map Apply Id'>
                <div>
                    @error('road.map_apply_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='direction'>Direction</label>
                <input wire:model='road.direction' name='direction' type='text' class='form-control' placeholder='Enter Direction'>
                <div>
                    @error('road.direction')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='width'>Width</label>
                <input wire:model='road.width' name='width' type='text' class='form-control' placeholder='Enter Width'>
                <div>
                    @error('road.width')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='dist_from_middle'>Dist From Middle</label>
                <input wire:model='road.dist_from_middle' name='dist_from_middle' type='text' class='form-control' placeholder='Enter Dist From Middle'>
                <div>
                    @error('road.dist_from_middle')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='min_dist_from_middle'>Min Dist From Middle</label>
                <input wire:model='road.min_dist_from_middle' name='min_dist_from_middle' type='text' class='form-control' placeholder='Enter Min Dist From Middle'>
                <div>
                    @error('road.min_dist_from_middle')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='dist_from_side'>Dist From Side</label>
                <input wire:model='road.dist_from_side' name='dist_from_side' type='text' class='form-control' placeholder='Enter Dist From Side'>
                <div>
                    @error('road.dist_from_side')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='min_dist_from_side'>Min Dist From Side</label>
                <input wire:model='road.min_dist_from_side' name='min_dist_from_side' type='text' class='form-control' placeholder='Enter Min Dist From Side'>
                <div>
                    @error('road.min_dist_from_side')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='dist_from_right'>Dist From Right</label>
                <input wire:model='road.dist_from_right' name='dist_from_right' type='text' class='form-control' placeholder='Enter Dist From Right'>
                <div>
                    @error('road.dist_from_right')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='min_dist_from_right'>Min Dist From Right</label>
                <input wire:model='road.min_dist_from_right' name='min_dist_from_right' type='text' class='form-control' placeholder='Enter Min Dist From Right'>
                <div>
                    @error('road.min_dist_from_right')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='setback'>Setback</label>
                <input wire:model='road.setback' name='setback' type='text' class='form-control' placeholder='Enter Setback'>
                <div>
                    @error('road.setback')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='min_setback'>Min Setback</label>
                <input wire:model='road.min_setback' name='min_setback' type='text' class='form-control' placeholder='Enter Min Setback'>
                <div>
                    @error('road.min_setback')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.roads.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
