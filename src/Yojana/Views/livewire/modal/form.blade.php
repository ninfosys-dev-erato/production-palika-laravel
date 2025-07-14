<div wire:ignore class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">
                    {{ __('yojana::yojana.manage_budget_source') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($component)
                    @livewire($component, ['action' => $action]) <!-- Pass the action prop -->
                @endif
            </div>
        </div>
    </div>
</div>


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
