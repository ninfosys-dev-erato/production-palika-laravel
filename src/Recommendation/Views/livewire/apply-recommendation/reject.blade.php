<div>
    <button type="button" class="btn btn-danger" wire:click="$dispatch('showRejectModal')" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Reject">
        <i class="bx bx-message-x"></i> {{__('recommendation::recommendation.reject')}}
    </button>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('recommendation::recommendation.rejection_reason') }}</h5>
                    <button type="button"
                        class="btn btn-light d-flex justify-content-center align-items-center shadow-sm close"
                        style="width: 40px; height: 40px; border: none; background-color: transparent;"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: red; font-size: 20px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea dusk="recommendation-rejectionReason-field" wire:model="rejectionReason" class="form-control" rows="4"></textarea>
                    @error('rejectionReason')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('recommendation::recommendation.cancel') }}</button>
                    <button type="button" class="btn btn-danger" wire:click="reject">{{ __('recommendation::recommendation.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    Livewire.on('showRejectModal', () => {
        var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    });
</script>