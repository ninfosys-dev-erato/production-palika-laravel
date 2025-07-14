<x-layout.app header="{{ __('yojana::yojana.committee_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.committee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">{{ __('yojana::yojana.committee_list') }}</h5>
                        @perm('committee_create')
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal">
                                <i class="bx bx-plus"></i> {{ __('yojana::yojana.add_committee') }}
                            </button>
                        @endperm
                    </div>

                    <div class="modal fade " id="indexModal" tabindex="-1" aria-labelledby="committeeAddLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="committeeAddLabel">
                                        {{ __('yojana::yojana.add_committee') }}
                                    </h5>
                                    <button type="button" class="btn-close" onclick="resetForm()"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <livewire:yojana.committee_form :action="App\Enums\Action::CREATE" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <livewire:yojana.committee_table theme="bootstrap-4" />
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
