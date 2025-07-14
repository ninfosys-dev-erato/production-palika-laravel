<x-layout.app header="Settings {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('adminsettings::adminsettings.admin_setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('adminsettings::adminsettings.settings') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ ucfirst(strtolower($action->value)) }}
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('adminsettings::adminsettings.setting') }} {{ ucfirst(strtolower($action->value)) }}
                    <div>
                        @perm('setting access')
                            <a href="{{ route('admin.admin_setting.setting.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i> {{ __('adminsettings::adminsettings.settings_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($setting))
                        <livewire:admin_settings.setting_form :$action :$setting />
                    @else
                        <livewire:admin_settings.setting_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
