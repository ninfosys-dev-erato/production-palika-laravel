<x-layout.app header="{{ __('ejalas::ejalas.priotity_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.priotity') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.priotity_list') }}</h5>
                    </div>
                    <div>
                        @perm('priotities create')
                            <!-- <a href="{{ route('admin.ejalas.priotities.create') }}" class="btn btn-info"><i
                                                                                class="bx bx-plus"></i> {{ __('ejalas::ejalas.add_priotity') }}</a> -->

                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal">
                                <i class="bx bx-plus"></i> {{ __('ejalas::ejalas.add_priority') }}
                            </button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:ejalas.priotity_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="indexModal" tabindex="-1" aria-labelledby="priorityLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="priorityLabel">
                        {{ __('ejalas::ejalas.priority') }}
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:ejalas.priotity_form :action="App\Enums\Action::CREATE" />
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
