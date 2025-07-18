<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_id' class='form-label'>{{__('grantmanagement::grantmanagement.grant_id')}}</label>
        <input wire:model='grantDetail.grant_id' name='grant_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_id')}}">
        <div>
            @error('grantDetail.grant_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grant_for' class='form-label'>{{__('grantmanagement::grantmanagement.grant_for')}}</label>
        <input wire:model='grantDetail.grant_for' name='grant_for' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_grant_for')}}">
        <div>
            @error('grantDetail.grant_for')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='model_type' class='form-label'>{{__('grantmanagement::grantmanagement.model_type')}}</label>
        <input wire:model='grantDetail.model_type' name='model_type' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_model_type')}}">
        <div>
            @error('grantDetail.model_type')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='model_id' class='form-label'>{{__('grantmanagement::grantmanagement.model_id')}}</label>
        <input wire:model='grantDetail.model_id' name='model_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_model_id')}}">
        <div>
            @error('grantDetail.model_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='personal_investment' class='form-label'>{{__('grantmanagement::grantmanagement.personal_investment')}}</label>
        <input wire:model='grantDetail.personal_investment' name='personal_investment' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_personal_investment')}}">
        <div>
            @error('grantDetail.personal_investment')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='is_old' class='form-label'>{{__('grantmanagement::grantmanagement.is_old')}}</label>
        <input wire:model='grantDetail.is_old' name='is_old' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_is_old')}}">
        <div>
            @error('grantDetail.is_old')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='prev_fiscal_year_id' class='form-label'>{{__('grantmanagement::grantmanagement.prev_fiscal_year_id')}}</label>
        <input wire:model='grantDetail.prev_fiscal_year_id' name='prev_fiscal_year_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_prev_fiscal_year_id')}}">
        <div>
            @error('grantDetail.prev_fiscal_year_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='investment_amount' class='form-label'>{{__('grantmanagement::grantmanagement.investment_amount')}}</label>
        <input wire:model='grantDetail.investment_amount' name='investment_amount' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_investment_amount')}}">
        <div>
            @error('grantDetail.investment_amount')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='remarks' class='form-label'>{{__('grantmanagement::grantmanagement.remarks')}}</label>
        <input wire:model='grantDetail.remarks' name='remarks' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_remarks')}}">
        <div>
            @error('grantDetail.remarks')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='local_body_id' class='form-label'>{{__('grantmanagement::grantmanagement.local_body_id')}}</label>
        <input wire:model='grantDetail.local_body_id' name='local_body_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_local_body_id')}}">
        <div>
            @error('grantDetail.local_body_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='ward_no' class='form-label'>{{__('grantmanagement::grantmanagement.ward_no')}}</label>
        <input wire:model='grantDetail.ward_no' name='ward_no' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_ward_no')}}">
        <div>
            @error('grantDetail.ward_no')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='village' class='form-label'>{{__('grantmanagement::grantmanagement.village')}}</label>
        <input wire:model='grantDetail.village' name='village' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_village')}}">
        <div>
            @error('grantDetail.village')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='tole' class='form-label'>{{__('grantmanagement::grantmanagement.tole')}}</label>
        <input wire:model='grantDetail.tole' name='tole' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_tole')}}">
        <div>
            @error('grantDetail.tole')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='plot_no' class='form-label'>{{__('grantmanagement::grantmanagement.plot_no')}}</label>
        <input wire:model='grantDetail.plot_no' name='plot_no' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_plot_no')}}">
        <div>
            @error('grantDetail.plot_no')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='contact_person' class='form-label'>{{__('grantmanagement::grantmanagement.contact_person')}}</label>
        <input wire:model='grantDetail.contact_person' name='contact_person' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_contact_person')}}">
        <div>
            @error('grantDetail.contact_person')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='contact' class='form-label'>{{__('grantmanagement::grantmanagement.contact')}}</label>
        <input wire:model='grantDetail.contact' name='contact' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_contact')}}">
        <div>
            @error('grantDetail.contact')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='user_id' class='form-label'>{{__('grantmanagement::grantmanagement.user_id')}}</label>
        <input wire:model='grantDetail.user_id' name='user_id' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_user_id')}}">
        <div>
            @error('grantDetail.user_id')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.grant_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>
