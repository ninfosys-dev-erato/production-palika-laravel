<x-layout.app header="Vehicle Category  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('Vehicle Category')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($vehicleCategory))
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
                    @if (!isset($vehicleCategory))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($vehicleCategory) ? __('Create VehicleCategory') : __('Update VehicleCategory') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.vehicle_categories.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('VehicleCategory List') }}
                        </a>
                    </div>
                </div>
                @if (isset($vehicleCategory))
                    <livewire:fuel_settings.vehicle_category_form :$action :$vehicleCategory />
                @else
                    <livewire:fuel_settings.vehicle_category_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
