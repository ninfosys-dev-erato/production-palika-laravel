<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='office_name' class='form-label'>{{__('grantmanagement::grantmanagement.office_name')}}</label>
        <input wire:model='grantOffice.office_name' name='office_name' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_office_name')}}">
        <div>
            @error('grantOffice.office_name')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='office_name_en' class='form-label'>{{__('grantmanagement::grantmanagement.office_name_en')}}</label>
        <input wire:model='grantOffice.office_name_en' name='office_name_en' type='text' class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_office_name_en')}}">
        <div>
            @error('grantOffice.office_name_en')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.grant_offices.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>
