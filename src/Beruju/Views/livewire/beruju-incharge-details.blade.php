<div class="card mb-4 rounded-0">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0 fw-semibold">
            <i class="bx bx-user-check me-2"></i>{{ __('beruju::beruju.incharge') }}
        </h6>
        @if($showInchargeDetails && $latestCycle)
            <button type="button" class="btn btn-primary btn-sm rounded-0" data-bs-target="#resolutionCycleModal" data-bs-toggle="modal">
                <i class="bx bx-plus me-1"></i>{{ __('beruju::beruju.assign_another') }}
            </button>
        @endif
    </div>
    <div class="card-body p-3">
        @if($showInchargeDetails)
            @if($latestCycle)
                <!-- Incharge Information -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">{{ __('beruju::beruju.incharge') }}</span>
                            <span class="fw-medium">
                                @if($latestCycle->incharge)
                                    {{ $latestCycle->incharge->name }}
                                @else
                                    {{ __('beruju::beruju.not_specified') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">{{ __('beruju::beruju.assigned_by') }}</span>
                            <span class="fw-medium">
                                @if($latestCycle->assignedBy)
                                    {{ $latestCycle->assignedBy->name }}
                                @else
                                    {{ __('beruju::beruju.not_specified') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">{{ __('beruju::beruju.assigned_at') }}</span>
                            <span class="fw-medium">
                                @if($latestCycle->assigned_at)
                                    {{ replaceNumbersWithLocale(ne_date($latestCycle->assigned_at),true) }}
                                @else
                                    {{ __('beruju::beruju.not_specified') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">{{ __('beruju::beruju.status') }}</span>
                            <div class="d-flex align-items-center">
                                @if($latestCycle->status)
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background-color: {{ $latestCycle->status === 'active' ? '#24a148' : '#8a3ffc' }}; margin-right: 6px;"></span>
                                    <span class="fw-medium">{{ ucfirst($latestCycle->status) }}</span>
                                @else
                                    <span class="fw-medium">{{ __('beruju::beruju.not_specified') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                @if($latestCycle->remarks || $latestCycle->completed_at)
                    <div class="border-top pt-3">
                        @if($latestCycle->remarks)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted small">{{ __('beruju::beruju.remarks') }}</span>
                                </div>
                                <p class="mb-0 small">{{ $latestCycle->remarks }}</p>
                            </div>
                        @endif
                        @if($latestCycle->completed_at)
                            <div class="mb-0">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted small">{{ __('beruju::beruju.completed_at') }}</span>
                                </div>
                                <p class="mb-0 small">{{ $latestCycle->completed_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-3">
                <div class="mb-3">
                    <i class="bx bx-user-plus text-muted" style="font-size: 2rem;"></i>
                </div>
                <p class="text-muted mb-3 small">{{ __('beruju::beruju.not_assigned_yet') }}</p>
                <button type="button" class="btn btn-primary btn-sm rounded-0" data-bs-target="#resolutionCycleModal" data-bs-toggle="modal">
                    <i class="bx bx-plus me-2"></i>{{ __('beruju::beruju.assign_beruju') }}
                </button>
            </div>
        @endif
    </div>
</div>