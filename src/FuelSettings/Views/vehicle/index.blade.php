<x-layout.app header="{{ __('Vehicle List') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Vehicle') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('Vehicle List') }}
                    </h5>
                    @perm('vehicles create')
                        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                            {{ __('Add Vehicle') }}</a>
                    @endperm
                </div>

                <div class="card-body">
                    <livewire:fuel_settings.vehicle_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
