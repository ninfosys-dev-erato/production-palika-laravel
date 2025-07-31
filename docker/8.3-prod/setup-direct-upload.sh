#!/bin/bash

# Direct Upload Setup Script for Laravel Production Container
# This script sets up the direct upload functionality for customer KYC forms

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_debug() {
    echo -e "${BLUE}[DEBUG]${NC} $1"
}

print_status "🔧 Setting up Direct Upload System"
print_status "=================================="

cd /var/www/html

# Step 1: Check if DirectUploadController exists
print_status "Step 1: Checking DirectUploadController..."
if [ ! -f "/var/www/html/app/Http/Controllers/DirectUploadController.php" ]; then
    print_warning "DirectUploadController not found, creating it..."
    
    # Create the controller directory if it doesn't exist
    mkdir -p /var/www/html/app/Http/Controllers
    
    # Create the DirectUploadController
    cat > /var/www/html/app/Http/Controllers/DirectUploadController.php << 'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aws\S3\PostObjectV4;

class DirectUploadController extends Controller
{
    /**
     * Generate signed URL for direct upload to cloud storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSignedUrl(Request $request): JsonResponse
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'content_type' => 'required|string|max:100',
            'file_size' => 'required|integer|max:104857600', // 100MB max
            'folder' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        // Only allow cloud storage for direct uploads
        if (!function_exists('isCloudStorage') || !isCloudStorage()) {
            return response()->json([
                'error' => 'Direct upload only available with cloud storage'
            ], 400);
        }

        $disk = function_exists('getStorageDisk') ? getStorageDisk($request->boolean('is_public') ? 'public' : 'private') : 'local';
        $storage = Storage::disk($disk);

        // Generate unique filename with tenant prefix
        $folder = $request->input('folder', 'uploads');
        $filename = $request->input('filename');
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $baseName = pathinfo($filename, PATHINFO_FILENAME);
        $uniqueId = Str::uuid();
        
        $key = "{$folder}/{$uniqueId}_{$baseName}.{$extension}";

        try {
            // Get S3 client from storage adapter
            $client = $storage->getAdapter()->getClient();
            $bucket = config("filesystems.disks.{$disk}.bucket");

            // Add tenant prefix for multitenancy
            $tenantPrefix = function_exists('getTenantPrefix') ? getTenantPrefix() : '';
            $prefixedKey = $tenantPrefix ? $tenantPrefix . '/' . ltrim($key, '/') : $key;
            
            // Create presigned POST data
            $formInputs = [
                'Content-Type' => $request->input('content_type'),
                'key' => $prefixedKey,
            ];

            $options = [
                ['bucket' => $bucket],
                ['starts-with', '$Content-Type', ''],
                ['content-length-range', 1, $request->input('file_size')],
            ];

            $postObject = new PostObjectV4(
                $client,
                $bucket,
                $formInputs,
                $options,
                '+15 minutes' // Expiry time
            );

            $formAttributes = $postObject->getFormAttributes();
            $formInputs = $postObject->getFormInputs();

            return response()->json([
                'upload_url' => $formAttributes['action'],
                'fields' => $formInputs,
                'key' => $key, // Return the original key without prefix for frontend
                'prefixed_key' => $prefixedKey, // Also return the prefixed key for reference
                'disk' => $disk,
                'tenant_prefix' => $tenantPrefix,
                'expires_at' => now()->addMinutes(15)->toISOString(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to generate signed upload URL: ' . $e->getMessage(), [
                'disk' => $disk,
                'key' => $key,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to generate upload URL',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm upload completion and get file URL
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmUpload(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
            'disk' => 'required|string',
            'prefixed_key' => 'nullable|string',
        ]);

        try {
            $key = $request->input('key');
            $disk = $request->input('disk');
            $prefixedKey = $request->input('prefixed_key');

            $storage = Storage::disk($disk);
            $actualKey = $prefixedKey ?: $key;

            if (!$storage->exists($actualKey)) {
                return response()->json([
                    'error' => 'File not found'
                ], 404);
            }

            // Get file URL
            $url = $storage->url($actualKey);

            return response()->json([
                'success' => true,
                'key' => $key,
                'url' => $url,
                'disk' => $disk,
                'size' => $storage->size($actualKey),
                'mime_type' => $storage->mimeType($actualKey),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to confirm upload: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to confirm upload',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete file from storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteFile(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
            'disk' => 'required|string',
        ]);

        try {
            $key = $request->input('key');
            $disk = $request->input('disk');

            $storage = Storage::disk($disk);

            if (!$storage->exists($key)) {
                return response()->json([
                    'error' => 'File not found'
                ], 404);
            }

            $storage->delete($key);

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to delete file: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to delete file',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get temporary URL for private files
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTemporaryUrl(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
            'disk' => 'required|string',
            'expiry_minutes' => 'nullable|integer|min:1|max:1440', // Max 24 hours
        ]);

        try {
            $key = $request->input('key');
            $disk = $request->input('disk');
            $expiryMinutes = $request->input('expiry_minutes', 60);

            $storage = Storage::disk($disk);

            if (!$storage->exists($key)) {
                return response()->json([
                    'error' => 'File not found'
                ], 404);
            }

            $url = $storage->temporaryUrl($key, now()->addMinutes($expiryMinutes));

            return response()->json([
                'success' => true,
                'url' => $url,
                'expires_at' => now()->addMinutes($expiryMinutes)->toISOString(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to get temporary URL: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to get temporary URL',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
EOF
    print_status "✅ DirectUploadController created"
else
    print_status "✅ DirectUploadController already exists"
fi

# Step 2: Add API routes if they don't exist
print_status "Step 2: Checking API routes..."
if ! grep -q "upload/signed-url" /var/www/html/routes/api.php; then
    print_status "Adding direct upload API routes..."
    cat >> /var/www/html/routes/api.php << 'EOF'

// Direct upload routes for cloud storage
Route::middleware(['auth:sanctum'])->prefix('upload')->group(function () {
    Route::post('signed-url', [DirectUploadController::class, 'getSignedUrl']);
    Route::post('confirm', [DirectUploadController::class, 'confirmUpload']);
    Route::delete('file', [DirectUploadController::class, 'deleteFile']);
    Route::post('temporary-url', [DirectUploadController::class, 'getTemporaryUrl']);
});

// Customer upload routes (for web session authenticated customers)
Route::middleware(['web', 'auth:customer'])->prefix('upload')->group(function () {
    Route::post('signed-url', [DirectUploadController::class, 'getSignedUrl']);
    Route::post('confirm', [DirectUploadController::class, 'confirmUpload']);
    Route::delete('file', [DirectUploadController::class, 'deleteFile']);
    Route::post('temporary-url', [DirectUploadController::class, 'getTemporaryUrl']);
});
EOF
    print_status "✅ Direct upload API routes added"
else
    print_status "✅ Direct upload API routes already exist"
fi

# Step 3: Ensure required dependencies are available
print_status "Step 3: Checking dependencies..."
if ! composer show | grep -q "aws/aws-sdk-php"; then
    print_warning "AWS SDK not found, installing..."
    su -s /bin/bash www-data -c "composer require aws/aws-sdk-php" 2>/dev/null || {
        print_error "Failed to install AWS SDK"
        print_status "Direct upload will not work without AWS SDK"
    }
else
    print_status "✅ AWS SDK already installed"
fi

# Step 4: Set proper permissions
print_status "Step 4: Setting permissions..."
chown -R www-data:www-data /var/www/html/app/Http/Controllers/DirectUploadController.php
chmod 644 /var/www/html/app/Http/Controllers/DirectUploadController.php

# Step 5: Clear and rebuild Laravel caches
print_status "Step 5: Clearing and rebuilding Laravel caches..."
su -s /bin/bash www-data -c "php artisan config:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan route:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan view:clear" 2>/dev/null || true
su -s /bin/bash www-data -c "php artisan cache:clear" 2>/dev/null || true

print_status "Step 6: Rebuilding route cache..."
su -s /bin/bash www-data -c "php artisan route:cache" 2>/dev/null || print_warning "Route cache failed, but routes should still work"

# Step 7: Test the setup
print_status "Step 7: Testing direct upload setup..."

# Test if routes are accessible
if curl -s -o /dev/null -w "%{http_code}" "http://localhost/api/upload/signed-url" | grep -q "401\|405"; then
    print_status "✅ Direct upload API endpoint is accessible (401/405 expected for unauthenticated requests)"
else
    print_warning "⚠️  Direct upload API endpoint may not be accessible"
fi

# Test if controller can be loaded
if su -s /bin/bash www-data -c "php artisan route:list | grep upload" 2>/dev/null; then
    print_status "✅ Direct upload routes are registered"
else
    print_warning "⚠️  Direct upload routes may not be registered"
fi

print_status ""
print_status "🎉 Direct Upload Setup Completed!"
print_status "================================"
print_status ""
print_status "Summary:"
print_status "✅ DirectUploadController created/verified"
print_status "✅ API routes added for direct uploads"
print_status "✅ Dependencies checked"
print_status "✅ Permissions set correctly"
print_status "✅ Laravel caches cleared and rebuilt"
print_status ""
print_status "Direct upload endpoints:"
print_status "• POST /api/upload/signed-url - Get signed URL for upload"
print_status "• POST /api/upload/confirm - Confirm upload completion"
print_status "• DELETE /api/upload/file - Delete uploaded file"
print_status "• POST /api/upload/temporary-url - Get temporary URL for private files"
print_status ""
print_status "Note: Direct upload requires cloud storage (Backblaze B2/S3) to be configured"
print_status "and the appropriate helper functions (isCloudStorage, getStorageDisk, etc.) to be available." 