<x-layout.app header="{{ __('beruju::beruju.action_type_details') }}">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">{{ __('beruju::beruju.action_type_details') }}</h1>
                <p class="text-muted">{{ __('beruju::beruju.view_comprehensive_information') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.beruju.action-types.index') }}" class="btn btn-outline-secondary rounded-0">
                    <i class="bx bx-arrow-back me-1"></i> {{ __('beruju::beruju.back_to_list') }}
                </a>
                @can('beruju edit')
                <a href="{{ route('admin.beruju.action-types.edit', $actionType->id) }}" class="btn btn-primary rounded-0">
                    <i class="bx bx-edit me-1"></i> {{ __('beruju::beruju.edit_action_type') }}
                </a>
                @endcan
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column - Main Details -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card shadow-sm mb-4 rounded-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>{{ __('beruju::beruju.basic_information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.name_eng') }}</label>
                                <p class="mb-0">{{ $actionType->name_eng ?: __('beruju::beruju.not_specified') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.name_nep') }}</label>
                                <p class="mb-0">{{ $actionType->name_nep ?: __('beruju::beruju.not_specified') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.sub_category') }}</label>
                                <p class="mb-0">
                                    @if($actionType->subCategory)
                                        <span class="badge bg-primary">{{ $actionType->subCategory->name_eng }}</span>
                                    @else
                                        {{ __('beruju::beruju.not_specified') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Details Card -->
                <div class="card shadow-sm mb-4 rounded-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-file-text me-2"></i>{{ __('beruju::beruju.additional_details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.remarks') }}</label>
                            <p class="mb-0">{{ $actionType->remarks ?: __('beruju::beruju.no_remarks_provided') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.form_id') }}</label>
                            <p class="mb-0">{{ $actionType->form_id ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Status & Actions -->
            <div class="col-lg-4">
                <!-- Audit Trail Card -->
                <div class="card shadow-sm mb-4 rounded-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-history me-2"></i>{{ __('beruju::beruju.audit_trail') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_by') }}</label>
                            <p class="mb-0">{{ $actionType->creator?->name ?: __('beruju::beruju.system') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.last_updated_by') }}</label>
                            <p class="mb-0">{{ $actionType->updater?->name ?: __('beruju::beruju.not_updated_yet') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_at') }}</label>
                            <p class="mb-0">{{ $actionType->created_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.last_updated') }}</label>
                            <p class="mb-0">{{ $actionType->updated_at?->format('M d, Y H:i') ?: __('beruju::beruju.not_available') }}</p>
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
                             <a href="{{ route('admin.beruju.action-types.edit', $actionType->id) }}" class="btn btn-outline-primary border-radius-0">
                                 <i class="bx bx-edit me-2"></i>{{ __('beruju::beruju.edit_action_type') }}
                             </a>
                             @endcan
                             <a href="{{ route('admin.beruju.action-types.index') }}" class="btn btn-outline-secondary border-radius-0">
                                 <i class="bx bx-list me-2"></i>{{ __('beruju::beruju.view_all_action_types') }}
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
</x-layout.app>
