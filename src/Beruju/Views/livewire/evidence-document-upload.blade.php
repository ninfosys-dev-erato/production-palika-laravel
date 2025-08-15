<div class="card rounded-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">{{ __('beruju::beruju.evidence_document_upload') }}</h5>
        <button type="button" class="btn btn-primary" wire:click="addDocument">
            {{ __('beruju::beruju.add_document') }}
        </button>
    </div>
    <div class="card-body">
        @foreach ($evidenceDocuments as $index => $document)
            <div class="row align-items-end border rounded p-3 mb-3 position-relative">
                <div class="row">
                    <div class='col-md-4 mb-3'>
                        <div class='form-group'>
                            <label class="form-label">{{ __('beruju::beruju.document_name') }}</label>
                            <input type="text" class="form-control"
                                wire:model="evidenceData.{{ $index }}.name"
                                placeholder="{{ __('beruju::beruju.document_name') }}">
                        </div>
                    </div>

                    <div class='col-md-4 mb-3'>
                        <div class='form-group'>
                            <label class="form-label">{{ __('beruju::beruju.upload_file') }}</label>
                            <input wire:model="uploadedFiles.{{ $index }}" type="file"
                                class="form-control {{ $errors->has('uploadedFiles.' . $index) ? 'is-invalid' : '' }}"
                                accept="image/*,.pdf">
                            @error("uploadedFiles.$index")
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                            <div wire:loading wire:target="uploadedFiles.{{ $index }}">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ __('beruju::beruju.uploading') }}
                            </div>

                            {{-- File Preview --}}
                            @if (isset($uploadedFileUrls[$index]) && $uploadedFileUrls[$index])
                                <div class="mt-2">
                                    <p class="mb-1">
                                        <strong>{{ __('beruju::beruju.file_preview') }}:</strong>
                                    </p>
                                    <a href="{{ $uploadedFileUrls[$index] }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-file"></i> {{ __('beruju::beruju.view_uploaded_file') }}
                                    </a>

                                </div>
                            @endif
                        </div>
                    </div>

                    <div class='col-md-3 mb-3'>
                        <div class='form-group'>
                            <label class="form-label">{{ __('beruju::beruju.description') }}</label>
                            <textarea class="form-control" rows="3" wire:model="evidenceData.{{ $index }}.description"
                                placeholder="{{ __('beruju::beruju.description') }}"></textarea>
                        </div>
                    </div>

                    <div class="col-md-1 mb-3 text-end">
                        <button type="button" class="btn btn-sm mt-1 btn-success"
                            wire:click="saveDocuments({{ $index }})">
                            <i class="bx bx-save"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger mt-1"
                            wire:click="removeDocuments({{ $index }})">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
