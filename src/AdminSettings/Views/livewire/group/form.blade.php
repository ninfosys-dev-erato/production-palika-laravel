<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-6'>
            <x-form.text-input
                label="{{ __('adminsettings::adminsettings.group_name') }}"
                id="group_name"
                name="group.group_name"
            />

        </div>
        <div class='col-md-6'>
            <x-form.text-input
                label="{{ __('adminsettings::adminsettings.description') }}"
                id="description"
                name="group.description"
            />
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('adminsettings::adminsettings.save')}}</button>
        <a href="{{route('admin.admin_setting.group.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
