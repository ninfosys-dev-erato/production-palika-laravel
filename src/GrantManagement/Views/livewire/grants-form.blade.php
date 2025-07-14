<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='fiscal_year_id' class='form-label'>{{__('grantmanagement::grantmanagement.fiscal_year_id')}}</label>
        <input wire:model='grant.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_fiscal_year_id')}}">
        <div>
            @error('grant.fiscal_year_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_type_id' class='form-label'>{{__('grantmanagement::grantmanagement.grant_type_id')}}</label>
        <input wire:model='grant.grant_type_id' name='grant_type_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_type_id')}}">
        <div>
            @error('grant.grant_type_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_office_id' class='form-label'>{{__('grantmanagement::grantmanagement.grant_office_id')}}</label>
        <input wire:model='grant.grant_office_id' name='grant_office_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_office_id')}}">
        <div>
            @error('grant.grant_office_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_program_name' class='form-label'>{{__('grantmanagement::grantmanagement.grant_program_name')}}</label>
        <input wire:model='grant.grant_program_name' name='grant_program_name' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_program_name')}}">
        <div>
            @error('grant.grant_program_name')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='branch_id' class='form-label'>{{__('grantmanagement::grantmanagement.branch_id')}}</label>
        <input wire:model='grant.branch_id' name='branch_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_branch_id')}}">
        <div>
            @error('grant.branch_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_amount' class='form-label'>{{__('grantmanagement::grantmanagement.grant_amount')}}</label>
        <input wire:model='grant.grant_amount' name='grant_amount' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_amount')}}">
        <div>
            @error('grant.grant_amount')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_for' class='form-label'>{{__('grantmanagement::grantmanagement.grant_for')}}</label>
        <input wire:model='grant.grant_for' name='grant_for' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_for')}}">
        <div>
            @error('grant.grant_for')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='main_activity' class='form-label'>{{__('grantmanagement::grantmanagement.main_activity')}}</label>
        <input wire:model='grant.main_activity' name='main_activity' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_main_activity')}}">
        <div>
            @error('grant.main_activity')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='remarks' class='form-label'>{{__('grantmanagement::grantmanagement.remarks')}}</label>
        <input wire:model='grant.remarks' name='remarks' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_remarks')}}">
        <div>
            @error('grant.remarks')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='user_id' class='form-label'>{{__('grantmanagement::grantmanagement.user_id')}}</label>
        <input wire:model='grant.user_id' name='user_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_user_id')}}">
        <div>
            @error('grant.user_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.grants.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>
