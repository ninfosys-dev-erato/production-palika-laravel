<x-layout.app header="Setting List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('settings::settings.manage_setting')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('settings::settings.list')}}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $settingGroup->group_name }} {{__('settings::settings.settings')}}</h3>
                    <p>{{ $settingGroup->description }}</p>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($settingGroup->settings as $index => $setting)
                            <div class="list-group-item">
                                <livewire:settings.setting_item_form :setting_key="$setting->key" :key="$index" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.app>
