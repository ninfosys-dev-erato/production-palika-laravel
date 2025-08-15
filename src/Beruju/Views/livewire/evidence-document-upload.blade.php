<div class="evidence-document-upload">
    <div class="card mb-3 rounded-0">
        <div class="card-body">
            <!-- Group: Evidence Document Upload -->
            <div class="divider divider-primary text-start text-primary mb-4">
                <div class="divider-text fw-bold fs-6">
                    {{ __('beruju::beruju.evidences') }}
                </div>
            </div>

            <form wire:submit.prevent="saveEvidence">
                <div class="row g-4">
                    <!-- Evidence Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evidence_name" class="form-label">
                                {{ __('beruju::beruju.evidence_name') }} <span class="text-danger">*</span>
                            </label>
                            <input wire:model="evidence.name" type="text" id="evidence_name"
                                class="form-control rounded-0 @error('evidence.name') is-invalid @enderror"
                                placeholder="{{ __('beruju::beruju.enter_evidence_name') }}">
                            @error('evidence.name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evidence_file" class="form-label">
                                {{ __('beruju::beruju.evidence_file') }} <span class="text-danger">*</span>
                            </label>
                            <input wire:model="evidence.file" type="file" id="evidence_file"
                                class="form-control rounded-0 @error('evidence.file') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('evidence.file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)
                            </small>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="evidence_description" class="form-label">
                                {{ __('beruju::beruju.evidence_description') }}
                            </label>
                            <textarea wire:model="evidence.description" id="evidence_description" rows="3"
                                class="form-control rounded-0 @error('evidence.description') is-invalid @enderror"
                                placeholder="{{ __('beruju::beruju.enter_evidence_description') }}"></textarea>
                            @error('evidence.description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-0" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('beruju::beruju.save_evidence') }}</span>
                        <span wire:loading>{{ __('beruju::beruju.saving') }}...</span>
                    </button>
                    <button type="button" class="btn btn-secondary rounded-0" wire:click="resetForm">
                        {{ __('beruju::beruju.reset') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
