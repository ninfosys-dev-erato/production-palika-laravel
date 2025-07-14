<x-layout.app header="{{'Vehicle '. ucfirst(strtolower($action->value)) .' Form' }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('Vehicle')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($vehicle))
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
                    @if (!isset($vehicle))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($vehicle) ? __('Create Vehicle') : __('Update Vehicle') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('Vehicle List') }}
                        </a>
                    </div>
                </div>
                @if (isset($vehicle))
                    <livewire:fuel_settings.vehicle_form :$action :$vehicle />
                @else
                    <livewire:fuel_settings.vehicle_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
