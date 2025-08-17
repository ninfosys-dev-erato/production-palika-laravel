<div>
    @if($this->canApproveAllSteps())
        <div class="d-flex justify-content-end mb-4">
            <button wire:click="showConfirmation" class="btn btn-success btn-lg">
                <i class="bx bx-check-circle me-2"></i>
                {{ __('ebps::ebps.approve_first_three_consultancy_steps') }}
            </button>
        </div>
    @endif

    <!-- Confirmation Modal -->
    @if($showConfirmationModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            {{ __('ebps::ebps.confirm_approve_first_three_consultancy_steps') }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="hideConfirmation"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bx bx-info-circle me-2"></i>
                            {{ __('ebps::ebps.are_you_sure_approve_first_three_consultancy_steps') }}
                        </div>
                        <p class="mb-0">
                            {{ __('ebps::ebps.this_action_will_approve_the_first_three_consultancy_building_registration_steps_at_once') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="hideConfirmation">
                            <i class="bx bx-x me-1"></i>
                            {{ __('ebps::ebps.cancel') }}
                        </button>
                        <button type="button" class="btn btn-success" wire:click="approveAllSteps">
                            <i class="bx bx-check me-1"></i>
                            {{ __('ebps::ebps.approve_all') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div> 