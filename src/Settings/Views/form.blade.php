<x-layout.app header="Setting  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('settings::settings.setting')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($setting))
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
                            @if (!isset($setting))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($setting) ? __('settings::settings.create_setting') : __('settings::settings.update_setting') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.settings.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('settings::settings.setting_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($setting))
            <livewire:settings.setting_form  :$action :$setting />
        @else
            <livewire:settings.setting_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
