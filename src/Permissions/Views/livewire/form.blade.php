<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='name'>{{__('Name')}}</label>
                <input wire:model='permission.name' name='name' type='text' class='form-control' placeholder="{{__('Enter Name')}}">
                <div>
                    @error('permission.name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='guard_name'>{{__('Guard Name')}}</label>
                <input wire:model='permission.guard_name' name='guard_name' type='text' class='form-control' placeholder="{{__('Enter Guard Name')}}">
                <div>
                    @error('permission.guard_name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('Save')}}</button>
        <a href="{{route('admin.permissions.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('Back')}}</a>
    </div>
</form>
