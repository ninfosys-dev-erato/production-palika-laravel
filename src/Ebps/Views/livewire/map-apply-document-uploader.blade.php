<div>
    <div class="col-md-4 mb-3 text-center">
        <div class="card shadow-sm h-100 cursor-pointer" wire:click="openModal">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <i class="bx bx-plus-circle fs-1 text-primary"></i>
                <div class="mt-2 fw-semibold">+ Add document</div>
            </div>
        </div>
    </div>

    @if ($open)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.4)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Document</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-start">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" wire:model.defer="title">
                            @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" wire:model="document" accept="*/*">
                            @error('document')<div class="text-danger small">{{ $message }}</div>@enderror
                            <div class="form-text">Max size 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                            <span wire:loading.remove>Upload</span>
                            <span wire:loading>Uploading...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


