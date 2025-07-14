<form wire:submit.prevent="save">
    <div class="row">
        <div class='col-md-6'>
            <x-form.select-input
                label="{{__('adminsettings::adminsettings.group') }}"
                id="group_id"
                name="setting.group_id"
                :options="$groups"
            />
        </div>
        <div class='col-md-6'>
            <x-form.text-input
                label="{{__('adminsettings::adminsettings.label')}}"
                id="label"
                name="setting.label"
            />
        </div>
    
    </div>

    <div class="row">
        <div class='col-md-6'>
                <x-form.select-input
                    label="{{__('adminsettings::adminsettings.select_from')}}"
                    id="select_from"
                    name="setting.select_from"
                    :options="\Src\AdminSettings\Enums\ModuleEnum::getForWeb()"
                    wire:model.defer="setting.select_from"
                />
        </div>
        <div class='col-md-6'>
                <x-form.text-input
                    label="{{__('adminsettings::adminsettings.value')}}"
                    id="value"
                    name="setting.value"
                    wire:model="setting.value"
                />
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('adminsettings::adminsettings.save')}}</button>
        <a href="{{ route('admin.admin_setting.setting.index') }}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
