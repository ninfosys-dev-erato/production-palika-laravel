<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='province_id'>Province Id</label>
                <input wire:model='district.province_id' name='province_id' type='text' class='form-control' placeholder='Enter Province Id'>
                <div>
                    @error('district.province_id')
                        <div class='text-danger'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='district.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('district.title')
                        <div class='text-danger'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='title_en'>Title En</label>
                <input wire:model='district.title_en' name='title_en' type='text' class='form-control' placeholder='Enter Title En'>
                <div>
                    @error('district.title_en')
                        <div class='text-danger'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.districts.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
