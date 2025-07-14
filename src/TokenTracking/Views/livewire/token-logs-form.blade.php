<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='token_id'>{{__('tokentracking::tokentracking.token_id')}}</label>
        <input wire:model='tokenLog.token_id' name='token_id' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_token_id')}}">
        <div>
            @error('tokenLog.token_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_status'>{{__('tokentracking::tokentracking.old_status')}}</label>
        <input wire:model='tokenLog.old_status' name='old_status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_status')}}">
        <div>
            @error('tokenLog.old_status')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='new_status'>{{__('tokentracking::tokentracking.new_status')}}</label>
        <input wire:model='tokenLog.new_status' name='new_status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_new_status')}}">
        <div>
            @error('tokenLog.new_status')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='status'>{{__('tokentracking::tokentracking.status')}}</label>
        <input wire:model='tokenLog.status' name='status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_status')}}">
        <div>
            @error('tokenLog.status')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='stage_status'>{{__('tokentracking::tokentracking.stage_status')}}</label>
        <input wire:model='tokenLog.stage_status' name='stage_status' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_stage_status')}}">
        <div>
            @error('tokenLog.stage_status')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='old_branch'>{{__('tokentracking::tokentracking.old_branch')}}</label>
        <input wire:model='tokenLog.old_branch' name='old_branch' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_old_branch')}}">
        <div>
            @error('tokenLog.old_branch')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='new_branch'>{{__('tokentracking::tokentracking.new_branch')}}</label>
        <input wire:model='tokenLog.new_branch' name='new_branch' type='text' class='form-control' placeholder="{{__('tokentracking::tokentracking.enter_new_branch')}}">
        <div>
            @error('tokenLog.new_branch')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('tokentracking::tokentracking.save')}}</button>
        <a href="{{route('admin.token_logs.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('tokentracking::tokentracking.back')}}</a>
    </div>
</form>
