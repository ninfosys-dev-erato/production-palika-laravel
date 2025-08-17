<x-layout.app header="{{ __('yojana::yojana.measurement_unit_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.measurement_unit') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.measurement_unit') }}</h5>
                    </div>
                    <div>
                        @perm('plan_basic_settings create')
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal">
                                <i class="bx bx-plus"></i> {{ __('yojana::yojana.add_measurement_unit') }}
                            </button>
                        @endperm
                    </div>
                </div>

                <div class="card-body">
                    <livewire:yojana.measurement_unit_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="MeasurementUnitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MeasurementUnitModalLabel">
                        {{ __('yojana::yojana.manage_measurement_unit') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        @if (isset($measurementUnit))
                            <livewire:yojana.measurement_unit_form :action="App\Enums\Action::UPDATE" :$measurementUnit />
                        @else
                            <livewire:yojana.measurement_unit_form :action="App\Enums\Action::CREATE" />
                        @endif
                    </div>
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
