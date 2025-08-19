<x-layout.app header="{{ __('beruju::beruju.beruju_entry_details') }}">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ __('beruju::beruju.beruju_entry_details') }}</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> {{ __('beruju::beruju.back_to_list') }}
            </a>
            @can('beruju edit')
            <a href="{{ route('admin.beruju.registration.edit', $berujuEntry->id) }}" class="btn btn-primary">
                <i class="bx bx-edit me-1"></i> {{ __('beruju::beruju.edit_entry') }}
            </a>
            @endcan
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - Main Details -->
        <div class="col-lg-8">
            <!-- Comprehensive Beruju Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="bx bx-info-circle me-2"></i>{{ __('beruju::beruju.beruju_details') }}
                    </h6>
                </div>
                <div class="card-body p-3">
                    <!-- Basic Information -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.reference_number') }}</span>
                                <span class="fw-medium">{{ replaceNumbersWithLocale($berujuEntry->reference_number, true) ?: __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.entry_date') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->entry_date ?: __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.fiscal_year_id') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->fiscalYear->year ?: __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.audit_type') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->audit_type ? $berujuEntry->audit_type->label() : __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.beruju_category') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->beruju_category ? $berujuEntry->beruju_category->label() : __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.sub_category_id') }}</span>
                                <span class="fw-medium">
                                    @if($berujuEntry->subCategory)
                                        @if(app()->getLocale() === 'ne')
                                            {{ $berujuEntry->subCategory->name_nep }}
                                        @else
                                            {{ $berujuEntry->subCategory->name_eng }}
                                        @endif
                                    @else
                                        {{ __('beruju::beruju.not_specified') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.current_status') }}</span>
                                <div class="d-flex align-items-center">
                                    @if($berujuEntry->status)
                                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $berujuEntry->status->color() }}; margin-right: 8px;"></span>
                                        <span class="fw-medium">{{ $berujuEntry->status->label() }}</span>
                                    @else
                                        <span class="fw-medium">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.submission_status') }}</span>
                                <div class="d-flex align-items-center">
                                    @if($berujuEntry->submission_status)
                                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $berujuEntry->submission_status->color() }}; margin-right: 8px;"></span>
                                        <span class="fw-medium">{{ $berujuEntry->submission_status->label() }}</span>
                                    @else
                                        <span class="fw-medium">{{ __('beruju::beruju.not_specified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.branch_id') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->branch?->title ?: __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">{{ __('beruju::beruju.project_id') }}</span>
                                <span class="fw-medium">{{ $berujuEntry->project_id ?: __('beruju::beruju.not_specified') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Details -->
                    <div class="border-top pt-3 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.amount') }}</span>
                                    <span class="fw-medium">
                                        @if($berujuEntry->amount)
                                            {{ $berujuEntry->currency_type ? \Src\Beruju\Enums\BerujuCurrencyTypeEnum::symbol($berujuEntry->currency_type) : __('beruju::beruju.npr_symbol') }} 
                                            {{ replaceNumbersWithLocale(number_format((float)$berujuEntry->amount, 2), true) }}
                                        @else
                                            {{ __('beruju::beruju.not_specified') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.currency_type') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->currency_type ? $berujuEntry->currency_type->label() : __('beruju::beruju.not_specified') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.action_deadline') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->action_deadline ?: __('beruju::beruju.not_specified') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.created_at') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->created_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Details -->
                    <div class="border-top pt-3 mb-3">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">{{ __('beruju::beruju.description') }}</span>
                            </div>
                            <p class="mb-0 small">{{ $berujuEntry->description ?: __('beruju::beruju.no_description_provided') }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">{{ __('beruju::beruju.legal_provision') }}</span>
                            </div>
                            <p class="mb-0 small">{{ $berujuEntry->legal_provision ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">{{ __('beruju::beruju.notes') }}</span>
                            </div>
                            <p class="mb-0 small">{{ $berujuEntry->notes ?: __('beruju::beruju.no_notes_provided') }}</p>
                        </div>
                    </div>

                    <!-- Audit Trail -->
                    <div class="border-top pt-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.created_by') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->creator?->name ?: __('beruju::beruju.system') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.last_updated_by') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->updater?->name ?: __('beruju::beruju.not_updated_yet') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">{{ __('beruju::beruju.last_updated') }}</span>
                                    <span class="fw-medium">{{ $berujuEntry->updated_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Status & Actions -->
        <div class="col-lg-4">
            <!-- Assigned To Section -->
            <livewire:beruju.beruju_incharge_details :berujuEntry="$berujuEntry" />

            <!-- Actions Taken Section -->
            <livewire:beruju.action_card :berujuEntry="$berujuEntry" />

            <!-- Quick Actions Card -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="bx bx-cog me-2"></i>{{ __('beruju::beruju.quick_actions') }}
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        @can('beruju edit')
                        <a href="{{ route('admin.beruju.registration.edit', $berujuEntry->id) }}" class="btn btn-outline-primary">
                            <i class="bx bx-edit me-2"></i>{{ __('beruju::beruju.edit_entry') }}
                        </a>
                        @endcan
                        <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-list me-2"></i>{{ __('beruju::beruju.view_all_entries') }}
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="window.print()">
                            <i class="bx bx-printer me-2"></i>{{ __('beruju::beruju.print_details') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style media="print">
    .btn, .card-header {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
    .container-fluid {
        max-width: 100% !important;
    }
</style>

<!-- Resolution Cycle Modal -->
<div wire:ignore class="modal fade" id="resolutionCycleModal" tabindex="-1" aria-labelledby="resolutionCycleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resolutionCycleModalLabel">{{ __('beruju::beruju.assign_beruju_for_resolution') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetResolutionForm()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <livewire:beruju.resolution_cycle_form :berujuEntry=$berujuEntry :action="App\Enums\Action::CREATE" />
            </div>
        </div>
    </div>
</div>

<!-- Action Modal -->
<div wire:ignore class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">{{ __('beruju::beruju.take_action') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetActionForm()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <livewire:beruju.action_form :berujuEntry="$berujuEntry" :action="App\Enums\Action::CREATE" />
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('resolutionCycleModal'));
            if (modal) {
                modal.hide();
            }
            
            // Clean up modal backdrop and body classes
            setTimeout(() => {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('body').css('overflow', '');
            }, 150);
        });
    });
    
    document.getElementById('resolutionCycleModal').addEventListener('hidden.bs.modal', () => {
        // Clean up any remaining modal artifacts
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        $('body').css('overflow', '');
        
        // Reset the form
        Livewire.dispatch('reset-form');
    });
    
    // Action Modal Event Listeners
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            const actionModal = bootstrap.Modal.getInstance(document.getElementById('actionModal'));
            if (actionModal) {
                actionModal.hide();
            }
            
            // Clean up modal backdrop and body classes
            setTimeout(() => {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('body').css('overflow', '');
            }, 150);
        });
        
        // Listen for open-action-modal event
        Livewire.on('open-action-modal', () => {
            const actionModal = new bootstrap.Modal(document.getElementById('actionModal'));
            actionModal.show();
        });
        
        // Listen for edit-action event to update modal title
        Livewire.on('edit-action', () => {
            // Update modal title to indicate editing
            document.getElementById('actionModalLabel').textContent = '{{ __("beruju::beruju.edit_action") }}';
        });
    });
    
    document.getElementById('actionModal').addEventListener('hidden.bs.modal', () => {
        // Clean up any remaining modal artifacts
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        $('body').css('overflow', '');
        
        // Reset the action form
        Livewire.dispatch('reset-form');
        
        // Reset modal title back to create mode
        resetModalTitle();
    });
    
    function resetActionForm() {
        // Reset the action form
        Livewire.dispatch('reset-form');
    }
    
    function resetModalTitle() {
        // Reset modal title back to create mode
        document.getElementById('actionModalLabel').textContent = '{{ __("beruju::beruju.take_action") }}';
    }
</script>
</x-layout.app>
