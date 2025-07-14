<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='farmer_id' class='form-label'>{{__('grantmanagement::grantmanagement.farmer_id')}}</label>
        <input wire:model='farmerGroup.farmer_id' name='farmer_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_farmer_id')}}">
        <div>
            @error('farmerGroup.farmer_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='group_id' class='form-label'>{{__('grantmanagement::grantmanagement.group_id')}}</label>
        <input wire:model='farmerGroup.group_id' name='group_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_group_id')}}">
        <div>
            @error('farmerGroup.group_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.farmer_groups.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>
