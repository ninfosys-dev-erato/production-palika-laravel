<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='token_id' class='form-label'>{{__('tokentracking::tokentracking.token_id')}}</label>
        <input wire:model='registerTokenLog.token_id' name='token_id' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_token_id')}}">
        <div>
            @error('registerTokenLog.token_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_branch' class='form-label'>{{__('tokentracking::tokentracking.old_branch')}}</label>
        <input wire:model='registerTokenLog.old_branch' name='old_branch' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_branch')}}">
        <div>
            @error('registerTokenLog.old_branch')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='current_branch' class='form-label'>{{__('tokentracking::tokentracking.current_branch')}}</label>
        <input wire:model='registerTokenLog.current_branch' name='current_branch' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_current_branch')}}">
        <div>
            @error('registerTokenLog.current_branch')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_stage' class='form-label'>{{__('tokentracking::tokentracking.old_stage')}}</label>
        <input wire:model='registerTokenLog.old_stage' name='old_stage' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_stage')}}">
        <div>
            @error('registerTokenLog.old_stage')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='current_stage' class='form-label'>{{__('tokentracking::tokentracking.current_stage')}}</label>
        <input wire:model='registerTokenLog.current_stage' name='current_stage' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_current_stage')}}">
        <div>
            @error('registerTokenLog.current_stage')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_status' class='form-label'>{{__('tokentracking::tokentracking.old_status')}}</label>
        <input wire:model='registerTokenLog.old_status' name='old_status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_status')}}">
        <div>
            @error('registerTokenLog.old_status')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='current_status' class='form-label'>{{__('tokentracking::tokentracking.current_status')}}</label>
        <input wire:model='registerTokenLog.current_status' name='current_status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_current_status')}}">
        <div>
            @error('registerTokenLog.current_status')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_values' class='form-label'>{{__('tokentracking::tokentracking.old_values')}}</label>
        <input wire:model='registerTokenLog.old_values' name='old_values' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_values')}}">
        <div>
            @error('registerTokenLog.old_values')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='current_values' class='form-label'>{{__('tokentracking::tokentracking.current_values')}}</label>
        <input wire:model='registerTokenLog.current_values' name='current_values' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_current_values')}}">
        <div>
            @error('registerTokenLog.current_values')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='description' class='form-label'>{{__('tokentracking::tokentracking.description')}}</label>
        <input wire:model='registerTokenLog.description' name='description' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_description')}}">
        <div>
            @error('registerTokenLog.description')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('tokentracking::tokentracking.save')}}</button>
        <a href="{{route('admin.register_token_logs.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('tokentracking::tokentracking.back')}}</a>
    </div>
</form>
