<div>
    <button type="button" class="btn btn-danger" wire:click="$dispatch('showRejectModal')" data-bs-toggle="tooltip"
        data-bs-placement="top" title="{{ __('businessregistration::businessregistration.reject') }}" data-bs-target="#rejectModal">
        <i class="bx bx-message-x"></i> {{ __('businessregistration::businessregistration.reject') }}
    </button>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('businessregistration::businessregistration.rejection_reason') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea dusk="businessregistration-rejectionReason-field" wire:model="rejectionReason" class="form-control" rows="4"></textarea>
                        @error('rejectionReason')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.cancel') }}</button>
                    <button type="button" class="btn btn-danger" wire:click="reject">{{ __('businessregistration::businessregistration.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('showRejectModal', () => {
            $('#rejectModal').modal('show');
        });
    </script>
@endpush