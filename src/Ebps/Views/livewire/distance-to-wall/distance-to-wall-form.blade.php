<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='map_apply_id'>Map Apply Id</label>
                <input wire:model='distanceToWall.map_apply_id' name='map_apply_id' type='text' class='form-control' placeholder='Enter Map Apply Id'>
                <div>
                    @error('distanceToWall.map_apply_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='direction'>Direction</label>
                <input wire:model='distanceToWall.direction' name='direction' type='text' class='form-control' placeholder='Enter Direction'>
                <div>
                    @error('distanceToWall.direction')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='has_road'>Has Road</label>
                <input wire:model='distanceToWall.has_road' name='has_road' type='text' class='form-control' placeholder='Enter Has Road'>
                <div>
                    @error('distanceToWall.has_road')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='does_have_wall_door'>Does Have Wall Door</label>
                <input wire:model='distanceToWall.does_have_wall_door' name='does_have_wall_door' type='text' class='form-control' placeholder='Enter Does Have Wall Door'>
                <div>
                    @error('distanceToWall.does_have_wall_door')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='dist_left'>Dist Left</label>
                <input wire:model='distanceToWall.dist_left' name='dist_left' type='text' class='form-control' placeholder='Enter Dist Left'>
                <div>
                    @error('distanceToWall.dist_left')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='min_dist_left'>Min Dist Left</label>
                <input wire:model='distanceToWall.min_dist_left' name='min_dist_left' type='text' class='form-control' placeholder='Enter Min Dist Left'>
                <div>
                    @error('distanceToWall.min_dist_left')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.distance_to_walls.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
