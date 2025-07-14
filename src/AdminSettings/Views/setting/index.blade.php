<x-layout.app header="Setting List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('adminsettings::adminsettings.admin_setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('adminsettings::adminsettings.setting') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('adminsettings::adminsettings.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Settings
                    @perm('setting_create')
                        <div>
                            <a href="{{ route('admin.admin_setting.setting.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('adminsettings::adminsettings.add_setting') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:admin_settings.setting_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
