<x-layout.app header="{{ __('beruju::beruju.document_types') }}">
    <div class="row g-6">
        <div class="col-12">
            <div class="card border-radius-0">
                <div class="card-header border-radius-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('beruju::beruju.document_types') }}</h4>
                    @perm('beruju create')
                    <button data-bs-target="#indexModal" data-bs-toggle="modal" onclick="resetForm()" class="btn btn-primary border-radius-0">
                        <i class="bx bx-plus"></i> {{ __('beruju::beruju.create_document_type') }}
                    </button>
                    @endperm
                </div>
                <div class="card-body border-radius-0">
                    <livewire:beruju.document_type_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">{{ __('beruju::beruju.create_document_type') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:beruju.document_type_form :action="\App\Enums\Action::CREATE" />
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function resetForm() {
        Livewire.dispatch('reset-form');
    }
    document.getElementById('indexModal').addEventListener('hidden.bs.modal', () => {
        Livewire.dispatch('reset-form');
    });

    function editDocumentType(id) {
        Livewire.dispatch('edit-document-type', { documentType: id });
    }

    function deleteDocumentType(id) {
        if (confirm('{{ __("beruju::beruju.are_you_sure_you_want_to_delete_this_document_type") }}')) {
            Livewire.dispatch('delete-document-type', { id: id });
        }
    }

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
    </script>
    @endpush
</x-layout.app>
