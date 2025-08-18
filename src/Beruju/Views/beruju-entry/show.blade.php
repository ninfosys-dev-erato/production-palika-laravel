<x-layout.app header="{{ __('beruju::beruju.beruju_entry_details') }}">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
                         <h1 class="h3 mb-0 text-gray-800">{{ __('beruju::beruju.beruju_entry_details') }}</h1>

        </div>
        <div class="d-flex gap-2">
                         <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-outline-secondary border-radius-0">
                                  <i class="bx bx-arrow-back me-1"></i> {{ __('beruju::beruju.back_to_list') }}
             </a>
             @can('beruju edit')
             <a href="{{ route('admin.beruju.registration.edit', $berujuEntry->id) }}" class="btn btn-primary border-radius-0">
                                  <i class="bx bx-edit me-1"></i> {{ __('beruju::beruju.edit_entry') }}
             </a>
             @endcan
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - Main Details -->
        <div class="col-lg-8">
                         <!-- Basic Information Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-info-circle me-2"></i>{{ __('beruju::beruju.basic_information') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                                                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.reference_number') }}</label>
                             <p class="mb-0">{{ replaceNumbersWithLocale($berujuEntry->reference_number, true) ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                                                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.entry_date') }}</label>
                             <p class="mb-0">{{ $berujuEntry->entry_date ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                                                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.fiscal_year_id') }}</label>
                             <p class="mb-0">{{ $berujuEntry->fiscalYear->year ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                                                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.audit_type') }}</label>
                             <p class="mb-0">
                                 @if($berujuEntry->audit_type)
                                     <span class="badge bg-info">{{ $berujuEntry->audit_type->label() }}</span>
                                 @else
                                     {{ __('beruju::beruju.not_specified') }}
                                 @endif
                             </p>
                        </div>
                    </div>
                </div>
            </div>

                         <!-- Category & Classification Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-category me-2"></i>{{ __('beruju::beruju.category_and_classification') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                                                     <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.beruju_category') }}</label>
                         <p class="mb-0">
                             @if($berujuEntry->beruju_category)
                                 <span class="badge bg-primary">{{ $berujuEntry->beruju_category->label() }}</span>
                             @else
                                 {{ __('beruju::beruju.not_specified') }}
                             @endif
                         </p>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.sub_category_id') }}</label>
                         <p class="mb-0">
                             @if($berujuEntry->subCategory)
                                 @if(app()->getLocale() === 'ne')
                                     {{ $berujuEntry->subCategory->name_nep }}
                                 @else
                                     {{ $berujuEntry->subCategory->name_eng }}
                                 @endif
                             @else
                                 {{ __('beruju::beruju.not_specified') }}
                             @endif
                         </p>
                        </div>
                    </div>
                </div>
            </div>

                         <!-- Financial Details Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-money me-2"></i>{{ __('beruju::beruju.financial_details') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                                                     <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.amount') }}</label>
                         <p class="mb-0">
                             @if($berujuEntry->amount)
                                 <span class="h5 text-success">
                                     {{ $berujuEntry->currency_type ? \Src\Beruju\Enums\BerujuCurrencyTypeEnum::symbol($berujuEntry->currency_type) : __('beruju::beruju.npr_symbol') }} 
                                     {{ replaceNumbersWithLocale(number_format((float)$berujuEntry->amount, 2), true) }}
                                 </span>
                             @else
                                 {{ __('beruju::beruju.not_specified') }}
                             @endif
                         </p>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.currency_type') }}</label>
                         <p class="mb-0">
                             @if($berujuEntry->currency_type)
                                 <span class="badge bg-secondary">{{ $berujuEntry->currency_type->label() }}</span>
                             @else
                                 {{ __('beruju::beruju.not_specified') }}
                             @endif
                         </p>
                        </div>
                    </div>
                </div>
            </div>

                         <!-- Description & Details Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-file-text me-2"></i>{{ __('beruju::beruju.description_and_details') }}
                     </h5>
                 </div>
                <div class="card-body">
                                         <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.description') }}</label>
                         <p class="mb-0">{{ $berujuEntry->description ?: __('beruju::beruju.no_description_provided') }}</p>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.legal_provision') }}</label>
                         <p class="mb-0">{{ $berujuEntry->legal_provision ?: __('beruju::beruju.not_specified') }}</p>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.notes') }}</label>
                         <p class="mb-0">{{ $berujuEntry->notes ?: __('beruju::beruju.no_notes_provided') }}</p>
                     </div>
                </div>
            </div>

                         <!-- Timeline & Deadlines Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-time me-2"></i>{{ __('beruju::beruju.timeline_and_deadlines') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                                                     <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.action_deadline') }}</label>
                         <p class="mb-0">
                             @if($berujuEntry->action_deadline)
                                 <span class="badge bg-warning">{{ $berujuEntry->action_deadline }}</span>
                             @else
                                 {{ __('beruju::beruju.not_specified') }}
                             @endif
                         </p>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_at') }}</label>
                         <p class="mb-0">{{ $berujuEntry->created_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Right Column - Status & Actions -->
        <div class="col-lg-4">

            <!-- Assigned To Card -->
                         <livewire:beruju.beruju_incharge_details :berujuEntry="$berujuEntry" />

                         <!-- Status Overview Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-check-circle me-2"></i>{{ __('beruju::beruju.status_overview') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="mb-3">
                                                 <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.current_status') }}</label>
                         <div class="d-flex align-items-center">
                             @if($berujuEntry->status)
                                 <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $berujuEntry->status->color() }}; margin-right: 8px;"></span>
                                 <span class="fw-bold">{{ $berujuEntry->status->label() }}</span>
                             @else
                                 <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                             @endif
                         </div>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.submission_status') }}</label>
                         <div class="d-flex align-items-center">
                             @if($berujuEntry->submission_status)
                                 <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $berujuEntry->submission_status->color() }}; margin-right: 8px;"></span>
                                 <span class="fw-bold">{{ $berujuEntry->submission_status->label() }}</span>
                             @else
                                 <span class="text-muted">{{ __('beruju::beruju.not_specified') }}</span>
                             @endif
                         </div>
                     </div>
                 </div>
             </div>

                         <!-- Location & Assignment Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-map me-2"></i>{{ __('beruju::beruju.location_and_assignment') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="mb-3">
                                                 <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.branch_id') }}</label>
                         <p class="mb-0">{{ $berujuEntry->branch?->title ?: __('beruju::beruju.not_specified') }}</p>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.project_id') }}</label>
                         <p class="mb-0">{{ $berujuEntry->project_id ?: __('beruju::beruju.not_specified') }}</p>
                    </div>
                </div>
            </div>

                         <!-- Audit Trail Card -->
             <div class="card shadow-sm mb-4 border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-history me-2"></i>{{ __('beruju::beruju.audit_trail') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="mb-3">
                                                 <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_by') }}</label>
                         <p class="mb-0">{{ $berujuEntry->creator?->name ?: __('beruju::beruju.system') }}</p>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.last_updated_by') }}</label>
                         <p class="mb-0">{{ $berujuEntry->updater?->name ?: __('beruju::beruju.not_updated_yet') }}</p>
                     </div>
                     <div class="mb-3">
                         <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.last_updated') }}</label>
                         <p class="mb-0">{{ $berujuEntry->updated_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</p>
                    </div>
                </div>
            </div>

                         <!-- Quick Actions Card -->
             <div class="card shadow-sm border-radius-0">
                 <div class="card-header">
                     <h5 class="card-title mb-0">
                                                  <i class="bx bx-cog me-2"></i>{{ __('beruju::beruju.quick_actions') }}
                     </h5>
                 </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                                                 @can('beruju edit')
                                                  <a href="{{ route('admin.beruju.registration.edit', $berujuEntry->id) }}" class="btn btn-outline-primary border-radius-0">
                              <i class="bx bx-edit me-2"></i>{{ __('beruju::beruju.edit_entry') }}
                          </a>
                          @endcan
                          <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-outline-secondary border-radius-0">
                              <i class="bx bx-list me-2"></i>{{ __('beruju::beruju.view_all_entries') }}
                          </a>
                          <button type="button" class="btn btn-outline-info border-radius-0" onclick="window.print()">
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
     .border-radius-0 {
         border-radius: 0 !important;
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
 </script>
 </x-layout.app>
