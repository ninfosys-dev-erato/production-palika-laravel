<x-layout.app header="{{ __('beruju::beruju.sub_categories') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-start">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('beruju::beruju.beruju_management') }}</a>
            <li class="breadcrumb-item"><a href="#">{{ __('beruju::beruju.sub_categories') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('beruju::beruju.list') }}</li>
        </ol>
    </nav>
    
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card rounded-0">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('beruju::beruju.sub_categories') }}</h5>
                    </div>
                    <div>
                        @perm('beruju create')
                            <button data-bs-target="#indexModal" data-bs-toggle="modal" onclick="resetForm()"
                                class="btn btn-info rounded-0"><i class="bx bx-plus"></i>
                                {{ __('beruju::beruju.add_new_sub_category') }}</button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:beruju.sub_category_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="ModalLabel">
                        {{ __('beruju::beruju.create_sub_category') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:beruju.sub_category_form :action="App\Enums\Action::CREATE" />
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
    document.getElementById('indexModal').addEventListener('hidden.bs.modal', () => {
        Livewire.dispatch('reset-form');
    });
</script>
