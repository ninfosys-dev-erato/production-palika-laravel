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
        if (!isCloudStorage()) {
            return response()->json([
                'error' => 'Direct upload only available with cloud storage'
            ], 400);
        }

        $disk = getStorageDisk($request->boolean('is_public') ? 'public' : 'private');
        $storage = Storage::disk($disk);

        // Generate unique filename with tenant prefix
        $folder = $request->input('folder', 'uploads');
        $filename = $request->input('filename');
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $baseName = pathinfo($filename, PATHINFO_FILENAME);
        $uniqueId = Str::uuid();
        
        // For cloud storage, the root prefix is automatically handled by Laravel
        // based on the 'root' parameter in filesystems.php
        $key = "{$folder}/{$uniqueId}_{$baseName}.{$extension}";

        try {
            // Get S3 client from storage adapter
            $client = $storage->getAdapter()->getClient();
            $bucket = config("filesystems.disks.{$disk}.bucket");

            // Add tenant prefix for multitenancy - Laravel's root config handles this automatically
            // but for direct uploads we need to manually add the prefix
            $tenantPrefix = getTenantPrefix();
            $prefixedKey = $tenantPrefix . '/' . ltrim($key, '/');
            
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
                'error' => 'Failed to generate upload URL'
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
            'disk' => 'required|string|in:backblaze,s3,public,local',
            'prefixed_key' => 'nullable|string', // For direct uploads that use prefixed keys
        ]);

        $key = $request->input('key');
        $disk = $request->input('disk');
        $prefixedKey = $request->input('prefixed_key');

        try {
            $storage = Storage::disk($disk);

            // For cloud storage with direct uploads, check the prefixed key
            // For regular uploads through Laravel, check the regular key (Laravel handles prefix automatically)
            $checkKey = $key;
            if ($prefixedKey && isCloudStorage() && in_array($disk, ['s3', 'backblaze'])) {
                // For direct uploads, we need to check without the tenant prefix since
                // Laravel storage will automatically add it when checking
                $checkKey = $key;
            }

            // Verify file exists
            if (!$storage->exists($checkKey)) {
                return response()->json([
                    'error' => 'File not found'
                ], 404);
            }

            // Get file URL
            $url = getStorageUrl($checkKey, $disk);

            return response()->json([
                'success' => true,
                'key' => $checkKey,
                'url' => $url,
                'disk' => $disk,
                'size' => $storage->size($checkKey),
                'tenant_prefix' => getTenantPrefix(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to confirm upload: ' . $e->getMessage(), [
                'key' => $key,
                'disk' => $disk,
                'prefixed_key' => $prefixedKey,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to confirm upload'
            ], 500);
        }
    }

    /**
     * Delete uploaded file
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteFile(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
            'disk' => 'required|string|in:backblaze,s3,public,local',
        ]);

        $key = $request->input('key');
        $disk = $request->input('disk');

        try {
            $success = deleteFromStorage($key, $disk);

            return response()->json([
                'success' => $success,
                'message' => $success ? 'File deleted successfully' : 'Failed to delete file'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to delete file: ' . $e->getMessage(), [
                'key' => $key,
                'disk' => $disk,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to delete file'
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
            'disk' => 'required|string|in:backblaze,s3,public,local',
            'expiry_minutes' => 'nullable|integer|min:1|max:10080', // Max 7 days
        ]);

        $key = $request->input('key');
        $disk = $request->input('disk');
        $expiryMinutes = $request->input('expiry_minutes', 60);

        try {
            $url = getStorageUrl($key, $disk, $expiryMinutes);

            return response()->json([
                'url' => $url,
                'expires_at' => now()->addMinutes($expiryMinutes)->toISOString(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to get temporary URL: ' . $e->getMessage(), [
                'key' => $key,
                'disk' => $disk,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to generate temporary URL'
            ], 500);
        }
    }
}