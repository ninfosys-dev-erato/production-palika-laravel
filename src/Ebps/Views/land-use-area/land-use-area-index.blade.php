<x-layout.app header="LandUseArea List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.land_use_area') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('ebps::ebps.land_use_areas') }}
                    </h5>
                    @perm('ebps_land_use_areas create')
                        <!-- <a href="{{ route('admin.ebps.land_use_areas.create') }}" class="btn btn-info"><i
                                                class="bx bx-plus"></i> {{ __('ebps::ebps.land_use_area') }} {{ __('ebps::ebps.add') }}</a> -->
                        <button class="btn btn-info" data-bs-toggle="modal" onclick="resetForm()"
                            data-bs-target="#indexModal">
                            <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_land_use_area') }}
                        </button>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.land_use_area_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="indexModal" tabindex="-1" aria-labelledby="AddLandUseAreaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddLandUseAreaModalLabel">
                        {{ __('ebps::ebps.land_use_area') }}
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:ebps.land_use_area_form :action="App\Enums\Action::CREATE" />
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
