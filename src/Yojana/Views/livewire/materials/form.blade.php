<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='material_type_id'>Material Type Id</label>
                <input wire:model='material.material_type_id' name='material_type_id' type='text' class='form-control' placeholder='Enter Material Type Id'>
                <div>
                    @error('material.material_type_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='unit_id'>Unit Id</label>
                <input wire:model='material.unit_id' name='unit_id' type='text' class='form-control' placeholder='Enter Unit Id'>
                <div>
                    @error('material.unit_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='material.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('material.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='density'>Density</label>
                <input wire:model='material.density' name='density' type='text' class='form-control' placeholder='Enter Density'>
                <div>
                    @error('material.density')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.materials.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
