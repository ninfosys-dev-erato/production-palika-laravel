<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='labour.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('labour.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='unit_id'>Unit Id</label>
                <input wire:model='labour.unit_id' name='unit_id' type='text' class='form-control' placeholder='Enter Unit Id'>
                <div>
                    @error('labour.unit_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.labours.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
