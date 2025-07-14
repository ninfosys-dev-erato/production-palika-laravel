<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='province.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('province.title')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='title_en'>Title En</label>
                <input wire:model='province.title_en' name='title_en' type='text' class='form-control' placeholder='Enter Title En'>
                <div>
                    @error('province.title_en')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.provinces.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
