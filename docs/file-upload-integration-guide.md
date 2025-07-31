# File Upload Integration Guide

## Problem Solved

✅ **Fixed**: All modules now use proper Backblaze storage instead of hardcoded 'local' storage
✅ **Added**: Universal JavaScript direct upload functionality for better performance
✅ **Standardized**: Consistent file upload approach across all modules

## What Was Fixed

### 1. Backend Storage Disk Issues
Changed hardcoded `'local'` disk usage to `getStorageDisk('private')` in:

- **EBPS Modules**:
  - `src/Ebps/Livewire/EbpsUploadFile.php`
  - `src/Ebps/Livewire/BuildingRegistrationForm.php`
  - `src/Ebps/Livewire/MapApplyForm.php`
  - `src/Ebps/Livewire/OldMapApplicationForm.php`
  - `frontend/CustomerPortal/Ebps/Livewire/CustomerMapApplyForm.php`
  - `frontend/CustomerPortal/Ebps/Livewire/BuildingRegistrationForm.php`

- **File Tracking/Darta Chalani**:
  - `src/FileTracking/Livewire/DartaForm.php`
  - `src/FileTracking/Livewire/ChalaniForm.php`
  - `src/FileTracking/Livewire/FileRecordCompose.php`

- **Recommendation Module**:
  - `src/Recommendation/Livewire/ApplyRecommendationUploadBill.php`
  - `src/Recommendation/Livewire/ApplyRecommendationForm.php`
  - `frontend/CustomerPortal/Recommendation/Livewire/CustomerApplyRecommendationForm.php`

### 2. Added Universal JavaScript Direct Upload

Created `resources/js/universal-file-upload.js` that provides:
- Direct browser uploads to Backblaze
- Progress tracking
- Automatic tenant prefix handling
- Error handling and user feedback

## How to Use

### Method 1: Automatic Integration (Recommended)

Add these attributes to your form and file inputs:

```html
<!-- Add to your form element -->
<form data-use-direct-upload>
    
    <!-- Add to file input elements -->
    <input type="file" 
           name="document" 
           data-direct-upload
           data-upload-folder="ebps/documents"
           data-is-public="false"
           data-preview-target="#preview-img">
    
    <!-- Optional: Preview container -->
    <img id="preview-img" class="d-none" style="max-width: 200px;">
    
    <button type="submit">Submit</button>
</form>
```

**Attributes Explained**:
- `data-use-direct-upload`: Enables direct upload for the form
- `data-direct-upload`: Marks file input for direct upload
- `data-upload-folder`: Folder path for uploads (e.g., "ebps/documents")
- `data-is-public`: "true" for public files, "false" for private
- `data-preview-target`: CSS selector for image preview element

### Method 2: Manual Integration

```javascript
// Create uploader instance
const uploader = new UniversalFileUpload({
    defaultFolder: 'ebps/documents',
    isPublic: false
});

// Manual upload
const fileInput = document.getElementById('my-file-input');
await uploader.uploadFile(fileInput);

// Get uploaded file data
const fileData = uploader.getUploadedFile('document');
console.log(fileData.key, fileData.url);
```

### Method 3: Event-Based Integration

```javascript
// Listen for upload completion
document.addEventListener('fileUploadComplete', (event) => {
    const { input, result, inputName } = event.detail;
    console.log(`File ${inputName} uploaded:`, result);
    
    // Update your UI or trigger additional actions
    updateFileList(result);
});
```

## Testing Guide

### 1. Test File Upload
1. Go to any module with file upload (EBPS, Darta Chalani, Recommendations)
2. Select a file
3. Verify it uploads to Backblaze (check browser network tab)
4. Confirm file appears in Backblaze bucket with proper tenant prefix

### 2. Test File Retrieval
1. Upload a file using the forms
2. Navigate to where files are displayed/downloaded
3. Verify files are retrieved from Backblaze correctly
4. Check temporary URLs are generated for private files

### 3. Test Different File Types
- **Images**: Should show preview after upload
- **Documents**: Should upload without preview
- **Large files**: Should show upload progress

### 4. Verify Module Coverage
Test uploads in:
- [ ] EBPS Business Registration
- [ ] EBPS Map Applications  
- [ ] Darta Chalani file submissions
- [ ] Recommendation applications
- [ ] File tracking documents

## Configuration Requirements

### 1. Backblaze Configuration
Ensure these are set in your `.env`:
```env
USE_CLOUD_STORAGE=true
BACKBLAZE_APPLICATION_KEY_ID=your_key_id
BACKBLAZE_APPLICATION_KEY=your_key
BACKBLAZE_BUCKET=your_bucket_name
BACKBLAZE_REGION=your_region
APP_ABBREVIATION=your_tenant_prefix
```

### 2. Route Configuration
Verify these API routes exist in `routes/api.php`:
```php
Route::post('/upload/signed-url', [DirectUploadController::class, 'getSignedUrl']);
Route::post('/upload/confirm', [DirectUploadController::class, 'confirmUpload']);
Route::post('/upload/temporary-url', [DirectUploadController::class, 'getTemporaryUrl']);
```

## Benefits

### ✅ What's Now Working:
1. **All file uploads go to Backblaze** instead of local storage
2. **Direct browser uploads** bypass server for better performance
3. **Automatic tenant prefixing** for multi-tenant file organization
4. **Progress indicators** show upload status
5. **Consistent error handling** across all modules
6. **Image previews** work correctly
7. **Temporary URLs** for private file access

### 🚀 Performance Improvements:
- Faster uploads (direct to cloud)
- Reduced server load
- Better user experience with progress bars
- Automatic retry capabilities

## Troubleshooting

### Upload Fails
1. Check browser console for JavaScript errors
2. Verify Backblaze credentials in `.env`
3. Ensure CSRF token is present in meta tags
4. Check network tab for failed API calls

### Files Not Appearing
1. Verify `getStorageDisk('private')` returns 'backblaze'
2. Check tenant prefix configuration
3. Ensure bucket permissions are correct

### Retrieval Issues
1. Check if files exist in correct bucket path
2. Verify temporary URL generation for private files
3. Ensure proper disk parameter in retrieval calls

## Example Form Template

```blade
<form wire:submit.prevent="submit" data-use-direct-upload>
    <div class="mb-3">
        <label for="document" class="form-label">Upload Document</label>
        <input type="file" 
               class="form-control" 
               id="document" 
               name="document"
               data-direct-upload
               data-upload-folder="{{$module}}/documents"
               data-is-public="false"
               accept=".pdf,.jpg,.jpeg,.png">
        <!-- Progress container will be auto-created -->
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

This integration ensures all your modules now properly use Backblaze storage with the same reliability as Customer KYC!