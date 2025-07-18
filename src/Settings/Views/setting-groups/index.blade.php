<x-layout.app header="SettingGroup List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.settinggroup') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('settings::settings.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('setting_groups create')
                        <a href="{{ route('admin.setting_groups.create') }}" class="btn btn-info"><i class="fa fa-plus"></i>
                            {{ __('settings::settings.add_setting_group') }}</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:settings.setting_group_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
