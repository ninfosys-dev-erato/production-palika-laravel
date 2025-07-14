<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>{{__('ebps::ebps.title')}}</label>
                <input wire:model='buildingRoofType.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('buildingRoofType.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.ebps.building_roof_types.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
