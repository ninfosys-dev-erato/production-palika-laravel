<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                <label for='group_name'>Group Name</label>
                <input wire:model='settingGroup.group_name' name='group_name' type='text' class='form-control' placeholder='Enter Group Name'>
                <div>
                    @error('settingGroup.group_name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
            </div>
            <div class="col-md-6">
                <div class='form-group'>
                    <label for='group_name_ne'>{{__('settings::settings.group_name_nepali')}}</label>
                    <input wire:model='settingGroup.group_name_ne' name='group_name_ne' type='text' class='form-control' placeholder='Enter Group Name Nepali'>
                    <div>
                        @error('settingGroup.group_name_ne')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class='form-group'>
                    <label for='slug'>{{__('settings::settings.group_slug')}}</label>
                    <input wire:model='settingGroup.slug' name='slug' type='text' class='form-control' placeholder='Enter Group Slug'>
                    <div>
                        @error('settingGroup.slug')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">{{__('settings::settings.is_public')}}</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" wire:model="settingGroup.is_public" name="is_public" {{$settingGroup->is_public?"checked":false}} class="form-check-input">
                        <label class="form-check-label"></label>
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
            <div class='form-group'>
                <label for='description'>{{__('settings::settings.description')}}</label>
                <input wire:model='settingGroup.description' name='description' type='text' class='form-control' placeholder='Enter Description'>
                <div>
                    @error('settingGroup.description')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('settings::settings.save')}}</button>
        <a href="{{route('admin.setting_groups.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('settings::settings.back')}}</a>
    </div>
</form>
