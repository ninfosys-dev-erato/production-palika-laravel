<div class="modal-content border-0 shadow">
    <div class="modal-header bg-light">
        <h5 class="modal-title fw-semibold" id="documentEditModalLabel">
            <i class="bx bx-edit me-2"></i>{{ __('ebps::ebps.upload_document') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">

        <div class="mb-4">
            <label for="edit-title"
                class="form-label fw-medium text-gray-700">{{ __('ebps::ebps.document_title') }}</label>
            <div class="input-group input-group-merge shadow-sm rounded">
                <span class="input-group-text bg-light border-0">
                    <i class="bx bx-text text-primary"></i>
                </span>
                <input type="text" name="title" id="edit-title" class="form-control border-0 py-2"
                    placeholder="Enter a descriptive title" wire:model="title">
            </div>
        </div>


        <div class="mb-3">
            <div class="input-group">
                <input type="file" name="file" class="form-control bg-light border-0" id="edit-file"
                    accept="image/*,application/pdf" wire:model="files" multiple>
                <label class="input-group-text bg-primary text-white">
                    <i class="bx bx-upload"></i>
                </label>
            </div>
        </div>

    </div>
    <div class="modal-footer bg-light d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x me-1"></i>{{ __('ebps::ebps.close') }}
        </button>

        <div class="d-flex align-items-center">
          
            <span wire:loading wire:target="saveDocument" class="text-muted me-2">
                <i class="bx bx-loader bx-spin me-1"></i> {{ __('ebps::ebps.uploading') }}
            </span>

           
            <button type="submit" class="btn btn-primary" wire:click="saveDocument" wire:loading.attr="disabled">
                <i class="bx bx-save me-1" wire:loading.remove wire:target="saveDocument"></i>
                {{ __('ebps::ebps.upload') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('document-uploaded', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            const modalId = detail?.modalId;
            if (!modalId) return;

            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.hide();

                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                }, 300);

                const fileInput = modalElement.querySelector('input[type="file"][wire\\:model="files"]');
                if (fileInput) {
                    fileInput.value = null;
                }
            }
        });
    </script>
@endpush
