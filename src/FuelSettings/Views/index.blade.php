<x-layout.app header="{{ __('Fuel Setting List') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Fuel Setting') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('Fuel Setting') }}
                    </h5>
                    @perm('fuel_settings create')
                        <a href="{{ route('admin.fuel_settings.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                            {{ __('Add Fuel Setting') }}</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:fuel_settings.fuel_setting_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
