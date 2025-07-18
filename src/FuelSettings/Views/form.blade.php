<x-layout.app header="{{__('Fuel Setting Form')}}">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('Fuel Setting')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($fuelSetting))
                    {{__('Edit')}}
                    @else
                    {{__('Create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($fuelSetting))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($fuelSetting) ? __('Create FuelSetting') : __('Update FuelSetting') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.fuel_settings.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('Fuel Setting List') }}
                                </a>
                            </div>
                        </div>
        @if(isset($fuelSetting))
            <livewire:fuel_settings.fuel_setting_form  :$action :$fuelSetting />
        @else
            <livewire:fuel_settings.fuel_setting_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
