/**
 * Customer KYC Direct Upload Component
 * 
 * This component enhances the Customer KYC form with direct upload capabilities
 * to Backblaze B2, providing better user experience and reduced server load.
 */

class CustomerKycUpload {
    constructor(options = {}) {
        this.apiBaseUrl = options.apiBaseUrl || '/api';
        this.uploadHelper = new DirectUploadHelper(this.apiBaseUrl);
        this.uploadedFiles = new Map();
        this.initializeEventListeners();
    }

    /**
     * Initialize event listeners for file upload inputs
     */
    initializeEventListeners() {
        // Listen for file input changes
        document.addEventListener('change', (event) => {
            if (event.target.matches('input[type="file"][data-kyc-upload]')) {
                this.handleFileSelection(event.target);
            }
        });

        // Listen for form submissions to handle uploaded files
        document.addEventListener('submit', (event) => {
            if (event.target.matches('form[data-kyc-form]')) {
                this.handleFormSubmission(event);
            }
        });

        // Listen for Livewire form submissions
        document.addEventListener('livewire:submit', (event) => {
            if (event.target.matches('form[data-kyc-form]')) {
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

        console.log('Starting file upload:', file.name, file.size, file.type);

        const uploadType = fileInput.dataset.uploadType || 'document';
        const progressContainer = this.getProgressContainer(fileInput);
        
        try {
            // Show progress indicator
            this.showProgress(progressContainer, 0);

            // Upload file directly to Backblaze B2
            const result = await this.uploadHelper.completeUpload(
                file,
                { 
                    folder: `customer-kyc/${uploadType}`, 
                    is_public: false 
                },
                (progress) => {
                    this.showProgress(progressContainer, progress);
                }
            );

            console.log('Upload successful:', result);

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

        } catch (error) {
            console.error('Upload failed:', error);
            this.showError(progressContainer, 'Upload failed: ' + error.message);
        }
    }

    /**
     * Handle form submission to include uploaded file data
     * 
     * @param {Event} event - Form submission event
     */
    handleFormSubmission(event) {
        // Add uploaded file data to form
        this.uploadedFiles.forEach((fileData, inputName) => {
            // Add file key
            const keyInput = document.createElement('input');
            keyInput.type = 'hidden';
            keyInput.name = `${inputName}_key`;
            keyInput.value = fileData.key;
            event.target.appendChild(keyInput);

            // Add upload data
            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = `${inputName}_upload_data`;
            dataInput.value = JSON.stringify(fileData);
            event.target.appendChild(dataInput);
        });
    }

    /**
     * Get or create progress container for file input
     * 
     * @param {HTMLInputElement} fileInput - The file input element
     * @returns {HTMLElement} Progress container element
     */
    getProgressContainer(fileInput) {
        let container = fileInput.parentNode.querySelector('.upload-progress');
        if (!container) {
            container = document.createElement('div');
            container.className = 'upload-progress mt-2';
            container.innerHTML = `
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="upload-status text-muted"></small>
            `;
            fileInput.parentNode.appendChild(container);
        }
        return container;
    }

    /**
     * Show upload progress
     * 
     * @param {HTMLElement} container - Progress container
     * @param {number} progress - Progress percentage (0-100)
     */
    showProgress(container, progress) {
        const progressBar = container.querySelector('.progress-bar');
        const status = container.querySelector('.upload-status');
        
        progressBar.style.width = `${progress}%`;
        progressBar.textContent = `${Math.round(progress)}%`;
        status.textContent = 'Uploading...';
    }

    /**
     * Show upload success
     * 
     * @param {HTMLElement} container - Progress container
     * @param {string} message - Success message
     */
    showSuccess(container, message) {
        const progressBar = container.querySelector('.progress-bar');
        const status = container.querySelector('.upload-status');
        
        progressBar.className = 'progress-bar bg-success';
        progressBar.textContent = '✓';
        status.textContent = message;
        status.className = 'upload-status text-success';
    }

    /**
     * Show upload error
     * 
     * @param {HTMLElement} container - Progress container
     * @param {string} message - Error message
     */
    showError(container, message) {
        const progressBar = container.querySelector('.progress-bar');
        const status = container.querySelector('.upload-status');
        
        progressBar.className = 'progress-bar bg-danger';
        progressBar.textContent = '✗';
        status.textContent = message;
        status.className = 'upload-status text-danger';
    }

    /**
     * Update hidden input with file key
     * 
     * @param {HTMLInputElement} fileInput - The file input element
     * @param {string} fileKey - The uploaded file key
     */
    updateHiddenInput(fileInput, fileKey) {
        let hiddenInput = fileInput.parentNode.querySelector(`input[name="${fileInput.name}_key"]`);
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
     * 
     * @param {HTMLInputElement} fileInput - The file input element
     * @param {string} imageUrl - The image URL
     */
    updateImagePreview(fileInput, imageUrl) {
        let preview = fileInput.parentNode.querySelector('.image-preview');
        if (!preview) {
            preview = document.createElement('div');
            preview.className = 'image-preview mt-2';
            fileInput.parentNode.appendChild(preview);
        }
        
        preview.innerHTML = `
            <img src="${imageUrl}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
        `;
    }

    /**
     * Get uploaded file data for a specific input
     * 
     * @param {string} inputName - The input name
     * @returns {Object|null} Uploaded file data
     */
    getUploadedFile(inputName) {
        return this.uploadedFiles.get(inputName) || null;
    }

    /**
     * Clear uploaded file data
     * 
     * @param {string} inputName - The input name to clear
     */
    clearUploadedFile(inputName) {
        this.uploadedFiles.delete(inputName);
    }

    /**
     * Clear all uploaded file data
     */
    clearAllUploadedFiles() {
        this.uploadedFiles.clear();
    }
}

// Initialize Customer KYC upload when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initializeCustomerKycUpload();
});

// Initialize when Livewire updates the DOM
document.addEventListener('livewire:load', () => {
    initializeCustomerKycUpload();
});

document.addEventListener('livewire:update', () => {
    initializeCustomerKycUpload();
});

function initializeCustomerKycUpload() {
    // Check if we're on a Customer KYC form page
    if (document.querySelector('form[data-kyc-form]')) {
        if (!window.customerKycUpload) {
            window.customerKycUpload = new CustomerKycUpload({
                apiBaseUrl: '/api'
            });
        }
    }
}

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CustomerKycUpload;
}

// Make available globally
window.CustomerKycUpload = CustomerKycUpload;

// Example usage:
/*
// Add data attributes to your file inputs:
<input type="file" 
       name="document_image1" 
       data-kyc-upload 
       data-upload-type="document"
       accept="image/*,.pdf">

// Add data attribute to your form:
<form data-kyc-form method="POST" action="/customer/kyc">
    <!-- form fields -->
</form>

// The component will automatically handle:
// 1. Direct upload to Backblaze B2 when files are selected
// 2. Progress tracking and user feedback
// 3. File key storage for form submission
// 4. Image previews for uploaded images
*/ 