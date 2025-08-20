<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0 fw-semibold">
            <i class="bx bx-list-check me-2"></i>{{ __('beruju::beruju.actions_taken') }}
        </h6>
    </div>
    <div class="card-body p-3">
        @if($berujuEntry->resolutionCycles && $berujuEntry->resolutionCycles->where('status', 'active')->count() > 0)
            @php
                // Get the latest active resolution cycle from the loaded collection
                $latestCycle = $berujuEntry->resolutionCycles
                    ->where('status', 'active')
                    ->sortByDesc('id')
                    ->first();
                
                $totalActions = 0;
                $pendingActions = 0;
                $completedActions = 0;
                $rejectedActions = 0;
                
                if ($latestCycle && $latestCycle->actions) {
                    $totalActions = $latestCycle->actions->count();
                    $pendingActions = $latestCycle->actions->where('status', 'Pending')->count();
                    $completedActions = $latestCycle->actions->where('status', 'Completed')->count();
                    $rejectedActions = $latestCycle->actions->where('status', 'Rejected')->count();
                }
            @endphp
            
            <!-- Action Statistics -->
            <div class="row g-2 mb-3">
                <div class="col-3">
                    <div class="text-center p-2 border-end">
                        <div class="h5 mb-0 fw-semibold text-muted">{{ replaceNumbersWithLocale($totalActions,true) }}</div>
                        <small class="text-muted">{{ __('beruju::beruju.total') }}</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="text-center p-2 border-end">
                        <div class="h5 mb-0 fw-semibold text-muted">{{ replaceNumbersWithLocale($pendingActions,true) }}</div>
                        <small class="text-muted">{{ __('beruju::beruju.pending') }}</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="text-center p-2 border-end">
                        <div class="h5 mb-0 fw-semibold text-muted">{{ replaceNumbersWithLocale($completedActions,true) }}</div>
                        <small class="text-muted">{{ __('beruju::beruju.completed') }}</small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="text-center p-2">
                        <div class="h5 mb-0 fw-semibold text-muted">{{ replaceNumbersWithLocale($rejectedActions,true) }}</div>
                        <small class="text-muted">{{ __('beruju::beruju.rejected') }}</small>
                    </div>
                </div>
            </div>
            
            <!-- Recent Actions -->
            @if($totalActions > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-medium">{{ __('beruju::beruju.recent_actions') }}</span>
                    </div>
                    <div class="space-y-2">
                        @if($latestCycle && $latestCycle->actions && $latestCycle->actions->count() > 0)
                            @foreach($latestCycle->actions->sortBy('created_at')->take(-3) as $action)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                    <div class="flex-grow-1">
                                        <div class="fw-medium small">{{ $action->actionType ? $action->actionType->name_nep : $action->actionType->name_eng ?? 'N/A' }}</div>
                                        <div class="text-muted small">{{ $action->created_at ? (app()->getLocale() === "ne" ? replaceNumbersWithLocale(ne_date($action->created_at),true) : $action->created_at->format('M d, Y')) : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark border">
                                            {{ $action->status }}
                                        </span>
                                        @can('beruju edit')
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                wire:click="editAction({{ $action->id }})" 
                                                title="{{ __('beruju::beruju.edit_action') }}">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
            
            <!-- Take Action Button -->
            <div class="d-grid">
                <button type="button" class="btn btn-primary btn-sm" wire:click="$dispatch('open-action-modal')">
                    <i class="bx bx-plus me-2"></i>{{ __('beruju::beruju.take_action') }}
                </button>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-3">
                <div class="mb-3">
                    <i class="bx bx-list-check text-muted" style="font-size: 2rem;"></i>
                </div>
                @if($berujuEntry->resolutionCycles && $berujuEntry->resolutionCycles->count() > 0)
                    <p class="text-muted mb-2 small">{{ __('beruju::beruju.no_active_resolution_cycle') }}</p>
                    <p class="text-muted mb-3 small">{{ __('beruju::beruju.assign_resolution_cycle_first') }}</p>
                @else
                    <p class="text-muted mb-3 small">{{ __('beruju::beruju.no_actions_taken_yet') }}</p>
                @endif
                <button type="button" class="btn btn-primary btn-sm" data-bs-target="#resolutionCycleModal" data-bs-toggle="modal">
                    <i class="bx bx-plus me-2"></i>{{ __('beruju::beruju.assign_beruju') }}
                </button>
            </div>
        @endif
    </div>
</div>