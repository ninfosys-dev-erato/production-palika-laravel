<x-layout.app header="{{ __('beruju::beruju.document_type_details') }}">
    <div class="row">
        <div class="col-12">
            <div class="card rounded-0">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('beruju::beruju.document_type_details') }}</h4>
                        <div>
                            <a href="{{ route('admin.beruju.document-types.index') }}" class="btn btn-outline-secondary rounded-0">
                                <i class="fas fa-arrow-left"></i> {{ __('beruju::beruju.back') }}
                            </a>
                            <a href="{{ route('admin.beruju.document-types.edit', $documentType->id) }}" class="btn btn-primary rounded-0">
                                <i class="fas fa-edit"></i> {{ __('beruju::beruju.edit') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.name_eng') }}</label>
                            <p class="mb-0">{{ $documentType->name_eng ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.name_nep') }}</label>
                            <p class="mb-0">{{ $documentType->name_nep ?: __('beruju::beruju.not_specified') }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.remarks') }}</label>
                            <p class="mb-0">{{ $documentType->remarks ?: __('beruju::beruju.no_remarks') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_by') }}</label>
                            <p class="mb-0">
                                @if($documentType->creator)
                                    <span class="badge bg-info">{{ $documentType->creator->name }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('beruju::beruju.system_defined') }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.created_at') }}</label>
                            <p class="mb-0">{{ $documentType->created_at ? $documentType->created_at->format('Y-m-d H:i:s') : __('beruju::beruju.not_available') }}</p>
                        </div>
                        @if($documentType->updated_at && $documentType->updated_at != $documentType->created_at)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.updated_by') }}</label>
                            <p class="mb-0">
                                @if($documentType->updater)
                                    <span class="badge bg-warning">{{ $documentType->updater->name }}</span>
                                @else
                                    {{ __('beruju::beruju.not_available') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">{{ __('beruju::beruju.updated_at') }}</label>
                            <p class="mb-0">{{ $documentType->updated_at ? $documentType->updated_at->format('Y-m-d H:i:s') : __('beruju::beruju.not_available') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.beruju.document-types.edit', $documentType->id) }}" class="btn btn-outline-primary rounded-0">
                            <i class="fas fa-edit"></i> {{ __('beruju::beruju.edit_document_type') }}
                        </a>
                        <a href="{{ route('admin.beruju.document-types.index') }}" class="btn btn-outline-secondary rounded-0">
                            <i class="fas fa-arrow-left"></i> {{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.app>

