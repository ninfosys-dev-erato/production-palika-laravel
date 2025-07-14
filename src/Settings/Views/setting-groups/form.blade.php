<x-layout.app header="SettingGroup  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">SettingGroup</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($settingGroup))
                    {{__('settings::settings.create')}}
                    @else
                    {{__('settings::settings.edit')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($settingGroup))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($settingGroup) ? __('settings::settings.create_settinggroup') : __('settings::settings.update_settinggroup') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.setting_groups.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('settings::settings.settinggroup_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($settingGroup))
            <livewire:settings.setting_group_form  :$action :$settingGroup />
        @else
            <livewire:settings.setting_group_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
