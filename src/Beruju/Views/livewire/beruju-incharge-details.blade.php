<div class="card shadow-sm mb-4 border-radius-0">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bx bx-check-circle me-2"></i>{{ __('beruju::beruju.incharge') }}
        </h5>
    </div>
    <div class="card-body">
        @if($showInchargeDetails)
            <!-- Incharge Details -->
            @if($berujuEntry->resolutionCycles && $berujuEntry->resolutionCycles->count() > 0)
                @foreach($berujuEntry->resolutionCycles as $resolutionCycle)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.incharge') }}</label>
                                <p class="mb-1 fw-bold">
                                    @if($resolutionCycle->incharge)
                                        {{ $resolutionCycle->incharge->name }}
                                    @else
                                        <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.assigned_by') }}</label>
                                <p class="mb-1 fw-bold">
                                    @if($resolutionCycle->assignedBy)
                                        {{ $resolutionCycle->assignedBy->name }}
                                    @else
                                        <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.assigned_at') }}</label>
                                <p class="mb-1">
                                    @if($resolutionCycle->assigned_at)
                                        {{ $resolutionCycle->assigned_at->format('Y-m-d H:i') }}
                                    @else
                                        <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.status') }}</label>
                                <div class="d-flex align-items-center">
                                    @if($resolutionCycle->status)
                                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $resolutionCycle->status_color }}; margin-right: 8px;"></span>
                                        <span class="fw-bold">{{ ucfirst($resolutionCycle->status) }}</span>
                                    @else
                                        <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($resolutionCycle->remarks)
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.remarks') }}</label>
                                    <p class="mb-0">{{ $resolutionCycle->remarks }}</p>
                                </div>
                            </div>
                        @endif
                        @if($resolutionCycle->completed_at)
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.completed_at') }}</label>
                                    <p class="mb-0">{{ $resolutionCycle->completed_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        <!-- <div class="mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="toggleToForm">
                                <i class="bx bx-plus me-1"></i>{{ __('beruju::beruju.assign_another') }}
                            </button>
                        </div> -->
                    </div>
                @endforeach
            @endif
        @else
            <!-- Form Button -->
            <div class="text-center py-3">
                <p class="text-muted mb-0">{{ __('beruju::beruju.not_assigned_yet') }}</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-target="#resolutionCycleModal" data-bs-toggle="modal">
                    <i class="bx bx-plus me-2"></i>{{ __('beruju::beruju.assign_beruju') }}
                </button>
            </div>
        @endif
    </div>
</div>