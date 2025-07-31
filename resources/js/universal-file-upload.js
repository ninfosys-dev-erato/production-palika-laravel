/**
 * Universal File Upload Helper
 * 
 * Provides direct upload functionality to Backblaze/S3 for all modules
 * Based on the customer-kyc-upload.js implementation
 */

class UniversalFileUpload {
    constructor(options = {}) {
        this.apiBaseUrl = options.apiBaseUrl || '/api';
        this.uploadHelper = new DirectUploadHelper(this.apiBaseUrl);
        this.uploadedFiles = new Map();
        this.defaultFolder = options.defaultFolder || 'uploads';
        this.isPublic = options.isPublic || false;
        
        this.initializeEventListeners();
    }

    /**
     * Initialize event listeners for file inputs and forms
     */
    initializeEventListeners() {
        // Listen for file inputs with data-direct-upload attribute
        document.addEventListener('change', (event) => {
            if (event.target.type === 'file' && event.target.hasAttribute('data-direct-upload')) {
                this.handleFileSelection(event.target);
            }
        });

        // Listen for form submissions to include uploaded file data
        document.addEventListener('submit', (event) => {
            if (event.target.hasAttribute('data-use-direct-upload')) {
                this.handleFormSubmission(event);
            }
        });
    }

    /**
     * Handle file selection and initiate direct upload
     * 
     * @param {HTMLInputElement} fileInput - The file input element
     */
    async handleFileSelection(fileInput) {
        const file = fileInput.files[0];
        if (!file) return;

        console.log('Starting universal file upload:', file.name, file.size, file.type);

        const folder = fileInput.dataset.uploadFolder || this.defaultFolder;
        const isPublic = fileInput.dataset.isPublic === 'true' || this.isPublic;
        const progressContainer = this.getProgressContainer(fileInput);
        
        try {
            // Show progress indicator
            this.showProgress(progressContainer, 0);

            // Upload file directly to cloud storage
            const result = await this.uploadHelper.completeUpload(
                file,
                { 
                    folder: folder, 
                    is_public: isPublic
                },
                (progress) => {
                    this.showProgress(progressContainer, progress);
                }
            );

            console.log('Universal upload successful:', result);

            // Store uploaded file info
            this.uploadedFiles.set(fileInput.name, {
                key: result.key,
                url: result.url,
                disk: result.disk,
                tenant_prefix: result.tenant_prefix
            });

            // Update hidden input with file key
            this.updateHiddenInput(fileInput, result.key);

            // Show success message
            this.showSuccess(progressContainer, 'File uploaded successfully!');

            // Update preview if it's an image
            if (file.type.startsWith('image/')) {
                this.updateImagePreview(fileInput, result.url);
            }

            // Trigger custom event for module-specific handling
            this.triggerUploadComplete(fileInput, result);

        } catch (error) {
            console.error('Universal upload failed:', error);
            this.showError(progressContainer, 'Upload failed: ' + error.message);
        }
    }

    /**
     * Handle form submission to include uploaded file data
     * 
     * @param {Event} event - Form submission event
     */
    handleFormSubmission(event) {
        const form = event.target;
        
        // Add uploaded files data to form
        this.uploadedFiles.forEach((fileData, inputName) => {
            // Create hidden inputs for file metadata
            const hiddenInputs = [
                { name: `${inputName}_key`, value: fileData.key },
                { name: `${inputName}_url`, value: fileData.url },
                { name: `${inputName}_disk`, value: fileData.disk },
                { name: `${inputName}_tenant_prefix`, value: fileData.tenant_prefix }
            ];

            hiddenInputs.forEach(input => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                form.appendChild(hiddenInput);
            });
        });
    }

    /**
     * Get or create progress container for file input
     */
    getProgressContainer(fileInput) {
        let container = fileInput.parentNode.querySelector('.upload-progress');
        if (!container) {
            container = document.createElement('div');
            container.className = 'upload-progress mt-2';
            fileInput.parentNode.appendChild(container);
        }
        return container;
    }

    /**
     * Show upload progress
     */
    showProgress(container, progress) {
        container.innerHTML = `
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: ${progress}%" 
                     aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">
                    ${Math.round(progress)}%
                </div>
            </div>
        `;
        container.classList.remove('d-none');
    }

    /**
     * Show success message
     */
    showSuccess(container, message) {
        container.innerHTML = `
            <div class="alert alert-success alert-sm">
                <i class="bi bi-check-circle"></i> ${message}
            </div>
        `;
    }

    /**
     * Show error message
     */
    showError(container, message) {
        container.innerHTML = `
            <div class="alert alert-danger alert-sm">
                <i class="bi bi-exclamation-triangle"></i> ${message}
            </div>
        `;
    }

    /**
     * Update hidden input with uploaded file key
     */
    updateHiddenInput(fileInput, fileKey) {
        let hiddenInput = document.querySelector(`input[name="${fileInput.name}_key"]`);
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `${fileInput.name}_key`;
            fileInput.parentNode.appendChild(hiddenInput);
        }
        hiddenInput.value = fileKey;
    }

    /**
     * Update image preview
     */
    updateImagePreview(fileInput, imageUrl) {
        const previewSelector = fileInput.dataset.previewTarget;
        if (previewSelector) {
            const preview = document.querySelector(previewSelector);
            if (preview) {
                preview.src = imageUrl;
                preview.classList.remove('d-none');
            }
        }
    }

    /**
     * Trigger custom event for upload completion
     */
    triggerUploadComplete(fileInput, result) {
        const event = new CustomEvent('fileUploadComplete', {
            detail: {
                input: fileInput,
                result: result,
                inputName: fileInput.name
            }
        });
        fileInput.dispatchEvent(event);
    }

    /**
     * Manually trigger upload for a specific file input
     */
    async uploadFile(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            await this.handleFileSelection(fileInput);
        }
    }

    /**
     * Get uploaded file data for a specific input
     */
    getUploadedFile(inputName) {
        return this.uploadedFiles.get(inputName);
    }

    /**
     * Clear uploaded files data
     */
    clearUploads() {
        this.uploadedFiles.clear();
    }
}

// Auto-initialize for forms with data-use-direct-upload attribute
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('[data-use-direct-upload]');
    if (forms.length > 0) {
        // Create a global instance
        window.universalFileUpload = new UniversalFileUpload();
        console.log('Universal file upload initialized for', forms.length, 'forms');
    }
});

// Make available globally
window.UniversalFileUpload = UniversalFileUpload;

// Export for manual usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = UniversalFileUpload;
}