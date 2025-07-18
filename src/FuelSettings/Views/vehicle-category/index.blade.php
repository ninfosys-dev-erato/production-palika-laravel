<x-layout.app header="{{ __('Vehicle Category List') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Vehicle Category') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('Vehicle Categories') }}
                    </h5>
                    @perm('vehicle_categories create')
                        <div>
                            <button href="{{ route('admin.vehicle_categories.create') }}" data-bs-toggle="modal"
                                data-bs-target="#indexModal" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('Add Vehicle Category') }}</button>

                        </div>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:fuel_settings.vehicle_category_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    {{--    Modal --}}

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="vehicleCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleCategoryModalLabel">
                        {{ __('Manage Vehicle Category') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:fuel_settings.vehicle_category_form :action="App\Enums\Action::CREATE" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#indexModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('indexModal'));
            modal.show();
        });
    });

    function resetForm() {
        Livewire.dispatch('reset-form');
    }
</script>
