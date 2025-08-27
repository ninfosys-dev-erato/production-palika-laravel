<div class="rounded-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title text-primary">{{ __('beruju::beruju.evidence_document_upload') }}</h5>
        <button type="button" class="btn btn-info rounded-0" wire:click="addDocument">
            {{ __('beruju::beruju.add_document') }}
        </button>
    </div>
    <div class="card-body">
        <!-- Labels Row - Only Once -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">{{ __('beruju::beruju.document_name') }}</label>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">{{ __('beruju::beruju.upload_file') }}</label>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">{{ __('beruju::beruju.description') }}</label>
            </div>
        
        </div>

        <!-- Input Fields - Looped -->
        @foreach ($evidenceDocuments as $index => $document)
        <div class="row mb-3 align-items-end">
            <div class="col-md-3">
                <input type="text" class="form-control rounded-0"
                    wire:model="evidenceData.{{ $index }}.name"
                    placeholder="{{ __('beruju::beruju.document_name') }}">
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <input wire:model="uploadedFiles.{{ $index }}" type="file" 
                        class="form-control rounded-0 {{ $errors->has('uploadedFiles.' . $index) ? 'is-invalid' : '' }}"
                        accept="image/*,.pdf">
                    @if (isset($uploadedFileUrls[$index]) && $uploadedFileUrls[$index])
                        <a href="{{ $uploadedFileUrls[$index] }}" target="_blank"
                            class="btn btn-outline-primary btn-sm rounded-0">
                            <i class="bx bx-file"></i>
                        </a>
                    @else
                        <div wire:loading wire:target="uploadedFiles.{{ $index }}">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </div>
                    @endif
                </div>
                @error("uploadedFiles.$index")
                    <small class='text-danger'>{{ $message }}</small>
                @enderror
                
            </div>

            <div class="col-md-4">
                <input type="text" class="form-control rounded-0" wire:model="evidenceData.{{ $index }}.description"
                    placeholder="{{ __('beruju::beruju.description') }}">
            </div>

            <div class="col-md-1 d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-sm btn-danger rounded-0 mb-1"
                    wire:click="removeDocuments({{ $index }})">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>
