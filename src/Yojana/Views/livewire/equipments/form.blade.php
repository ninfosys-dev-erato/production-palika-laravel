<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='equipment.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('equipment.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='activity'>Activity</label>
                <input wire:model='equipment.activity' name='activity' type='text' class='form-control' placeholder='Enter Activity'>
                <div>
                    @error('equipment.activity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_used_for_transport'>Is Used For Transport</label>
                <input wire:model='equipment.is_used_for_transport' name='is_used_for_transport' type='text' class='form-control' placeholder='Enter Is Used For Transport'>
                <div>
                    @error('equipment.is_used_for_transport')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='capacity'>Capacity</label>
                <input wire:model='equipment.capacity' name='capacity' type='text' class='form-control' placeholder='Enter Capacity'>
                <div>
                    @error('equipment.capacity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='speed_with_out_load'>Speed With Out Load</label>
                <input wire:model='equipment.speed_with_out_load' name='speed_with_out_load' type='text' class='form-control' placeholder='Enter Speed With Out Load'>
                <div>
                    @error('equipment.speed_with_out_load')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.equipment.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
