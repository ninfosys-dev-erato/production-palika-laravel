/**
 * Direct Upload Helper for Backblaze B2 / S3
 * 
 * This helper provides functions for direct browser uploads to cloud storage
 * with automatic tenant prefix handling for multitenancy.
 */

class DirectUploadHelper {
    constructor(apiBaseUrl = '/api') {
        this.apiBaseUrl = apiBaseUrl;
    }

    /**
     * Get signed URL for direct upload
     * 
     * @param {Object} fileInfo - File information
     * @param {string} fileInfo.filename - Original filename
     * @param {string} fileInfo.content_type - File MIME type
     * @param {number} fileInfo.file_size - File size in bytes
     * @param {string} fileInfo.folder - Upload folder (optional)
     * @param {boolean} fileInfo.is_public - Whether file should be public (optional)
     * @returns {Promise<Object>} Upload configuration object
     */
    async getSignedUrl(fileInfo) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/upload/signed-url`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Authorization': `Bearer ${this.getAuthToken()}`
                },
                body: JSON.stringify(fileInfo)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Failed to get signed URL:', error);
            throw error;
        }
    }

    /**
     * Upload file directly to cloud storage
     * 
     * @param {File} file - File object to upload
     * @param {Object} uploadConfig - Configuration from getSignedUrl()
     * @param {Function} progressCallback - Progress callback function (optional)
     * @returns {Promise<Object>} Upload result
     */
    async uploadFile(file, uploadConfig, progressCallback = null) {
        try {
            const formData = new FormData();
            
            // Add all form fields from the signed URL response
            Object.entries(uploadConfig.fields).forEach(([key, value]) => {
                formData.append(key, value);
            });
            
            // Add the file last
            formData.append('file', file);

            const xhr = new XMLHttpRequest();
            
            return new Promise((resolve, reject) => {
                xhr.upload.addEventListener('progress', (event) => {
                    if (event.lengthComputable && progressCallback) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        progressCallback(percentComplete);
                    }
                });

                xhr.addEventListener('load', () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resolve({
                            success: true,
                            key: uploadConfig.key,
                            prefixed_key: uploadConfig.prefixed_key,
                            disk: uploadConfig.disk,
                            tenant_prefix: uploadConfig.tenant_prefix
                        });
                    } else {
                        reject(new Error(`Upload failed with status ${xhr.status}`));
                    }
                });

                xhr.addEventListener('error', () => {
                    reject(new Error('Upload failed'));
                });

                xhr.open('POST', uploadConfig.upload_url);
                xhr.send(formData);
            });
        } catch (error) {
            console.error('Upload failed:', error);
            throw error;
        }
    }

    /**
     * Confirm upload completion and get file URL
     * 
     * @param {string} key - File key
     * @param {string} disk - Storage disk
     * @param {string} prefixedKey - Prefixed key for direct uploads (optional)
     * @returns {Promise<Object>} File information with URL
     */
    async confirmUpload(key, disk, prefixedKey = null) {
        try {
            const body = { key, disk };
            if (prefixedKey) {
                body.prefixed_key = prefixedKey;
            }

            const response = await fetch(`${this.apiBaseUrl}/upload/confirm`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Authorization': `Bearer ${this.getAuthToken()}`
                },
                body: JSON.stringify(body)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Failed to confirm upload:', error);
            throw error;
        }
    }

    /**
     * Delete file from storage
     * 
     * @param {string} key - File key
     * @param {string} disk - Storage disk
     * @returns {Promise<Object>} Deletion result
     */
    async deleteFile(key, disk) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/upload/file`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Authorization': `Bearer ${this.getAuthToken()}`
                },
                body: JSON.stringify({ key, disk })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Failed to delete file:', error);
            throw error;
        }
    }

    /**
     * Get temporary URL for private files
     * 
     * @param {string} key - File key
     * @param {string} disk - Storage disk
     * @param {number} expiryMinutes - Expiry time in minutes (optional)
     * @returns {Promise<Object>} Temporary URL
     */
    async getTemporaryUrl(key, disk, expiryMinutes = 60) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/upload/temporary-url`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Authorization': `Bearer ${this.getAuthToken()}`
                },
                body: JSON.stringify({ key, disk, expiry_minutes: expiryMinutes })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Failed to get temporary URL:', error);
            throw error;
        }
    }

    /**
     * Complete upload process: get signed URL, upload file, confirm upload
     * 
     * @param {File} file - File to upload
     * @param {Object} options - Upload options
     * @param {string} options.folder - Upload folder (optional)
     * @param {boolean} options.is_public - Whether file should be public (optional)
     * @param {Function} progressCallback - Progress callback function (optional)
     * @returns {Promise<Object>} Complete upload result with file URL
     */
    async completeUpload(file, options = {}, progressCallback = null) {
        try {
            // Step 1: Get signed URL
            const fileInfo = {
                filename: file.name,
                content_type: file.type,
                file_size: file.size,
                folder: options.folder || 'uploads',
                is_public: options.is_public || false
            };

            const uploadConfig = await this.getSignedUrl(fileInfo);

            // Step 2: Upload file directly to cloud storage
            const uploadResult = await this.uploadFile(file, uploadConfig, progressCallback);

            // Step 3: Confirm upload and get file URL
            const confirmResult = await this.confirmUpload(
                uploadResult.key, 
                uploadResult.disk, 
                uploadResult.prefixed_key
            );

            return {
                ...confirmResult,
                tenant_prefix: uploadResult.tenant_prefix
            };
        } catch (error) {
            console.error('Complete upload failed:', error);
            throw error;
        }
    }

    /**
     * Get authentication token from meta tag or localStorage
     * 
     * @returns {string} Auth token
     */
    getAuthToken() {
        // Try to get token from meta tag first
        const metaToken = document.querySelector('meta[name="api-token"]')?.getAttribute('content');
        if (metaToken) return metaToken;

        // Fallback to localStorage
        return localStorage.getItem('auth_token') || '';
    }
}

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DirectUploadHelper;
}

// Make available globally
window.DirectUploadHelper = DirectUploadHelper;

// Example usage:
/*
const uploader = new DirectUploadHelper();

// Upload a file with progress tracking
const fileInput = document.getElementById('file-input');
fileInput.addEventListener('change', async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    try {
        const result = await uploader.completeUpload(
            file,
            { 
                folder: 'documents', 
                is_public: false 
            },
            (progress) => {
                console.log(`Upload progress: ${progress.toFixed(2)}%`);
            }
        );

        console.log('Upload successful:', result);
        console.log('File URL:', result.url);
        console.log('Tenant prefix:', result.tenant_prefix);
    } catch (error) {
        console.error('Upload failed:', error);
    }
});
*/