    <div>
        <div class="card">
            <div class="card-body" wire:init="refresh">
                <div class="d-flex justify-content-start mt-3 pb-2">
                    <button class="btn btn-info" wire:click="addDocument"><i class="bx bx-plus"></i> Add Document</button>
                </div>
                <div class="list-group">
                    @foreach ($documents as $key => $document)
                        <div class="list-group-item list-group-item-action py-3 px-4 rounded shadow-sm"
                            wire:key="doc-{{ $key }}">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="font-weight-bold">{{ __('businessregistration::businessregistration.document_name') }}</label>
                                        <input
                                            dusk="businessregistration-documents.{{ $key }}.document_name-field"
                                            type="text" class="form-control"
                                            wire:model="documents.{{ $key }}.document_name"
                                            placeholder="Enter document name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="font-weight-bold">{{ __('businessregistration::businessregistration.upload_document') }}</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="file" class="form-control-file" accept="*/*"
                                                wire:model.defer="documents.{{ $key }}.document">
                                            
                                            @if (isset($document['url']) && $document['url'])
                                                <a href="{{ $document['url'] }}" target="_blank" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="View Document">
                                                    {{__('businessregistration::businessregistration.view')}}
                                                </a>
                                            @endif
                                        </div>

                                        <div wire:loading wire:target="documents.{{ $key }}.document">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Uploading...
                                        </div>


                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="font-weight-bold">{{ __('businessregistration::businessregistration.document_status') }}</label>
                                        <select
                                            dusk="businessregistration-documents.{{ $key }}.document_status-field"
                                            wire:model.defer="documents.{{ $key }}.document_status"
                                            id="documents.{{ $key }}.document_status" class="form-control">
                                            @foreach ($options as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="btn-group-vertical">
                                        <button class="btn btn-primary" wire:click="save({{ $key }})" 
                                                {{ !isset($document['url']) || !$document['url'] ? 'disabled' : '' }}>
                                            <i class="bx bx-save"></i>
                                        </button>
                                        <button class="btn btn-danger"
                                            wire:click="removeDocument({{ $key }})"> 
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary">
                    <i class="bx bx-upload me-2"></i>
                    {{ __('businessregistration::businessregistration.uploaded_documents') }}
                </h5>
            </div>
            <div class="card-body">
                @php
                    $uploaded = collect($documents)->filter(fn($doc) => !empty($doc['url']));
                @endphp

                @if ($uploaded->count())
                    <div class="row">
                        @foreach ($uploaded as $doc)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="{{ $this->getFileIcon($doc['file_type'] ?? 'unknown') }} text-primary fs-4 me-2"></i>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 text-truncate" title="{{ $doc['document_name'] ?? 'Document' }}">
                                                            {{ $doc['document_name'] ?? 'Document' }}
                                                        </h6>
                                                        <small class="text-muted text-uppercase">
                                                            {{ $doc['file_type'] ?? 'unknown' }} file
                                                        </small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Image Thumbnail for Images -->
                                                @if (($doc['file_type'] ?? '') === 'image' && isset($doc['preview_url']))
                                                    <div class="text-center mb-2">
                                                        <img src="{{ $doc['preview_url'] }}" 
                                                             alt="Document Preview" 
                                                             class="img-fluid rounded" 
                                                             style="max-height: 120px; object-fit: cover;">
                                                    </div>
                                                @endif
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">
                                                        {{ $options[
                                                            $doc['document_status'] instanceof \Src\BusinessRegistration\Enums\BusinessDocumentStatusEnum
                                                                ? $doc['document_status']->value
                                                                : $doc['document_status']
                                                        ] ?? ($doc['document_status'] instanceof \BackedEnum ? $doc['document_status']->value : $doc['document_status']) }}
                                                    </span>
                                                    
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ $doc['url'] }}" target="_blank" 
                                                           class="btn btn-outline-primary btn-sm" 
                                                           title="View Document">
                                                            {{__('businessregistration::businessregistration.view')}}
                                                        </a>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-file bx-lg mb-3"></i>
                        <p class="mb-0">{{ __('businessregistration::businessregistration.no_uploaded_documents') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
