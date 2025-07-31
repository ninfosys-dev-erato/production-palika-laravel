<?php

namespace App\Services;

use App\Jobs\TransferFileToCloudJob;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LivewireFileService
{
    /**
     * Handle temporary file upload - always store locally first
     *
     * @param TemporaryUploadedFile $file
     * @param string|null $targetPath Target path for final storage
     * @param bool $transferToCloud Whether to queue transfer to cloud storage
     * @param string|null $modelClass Model class to update after cloud transfer
     * @param int|null $modelId Model ID to update after cloud transfer
     * @param string|null $modelField Model field to update with cloud path
     * @return string|null Local file path on success
     */
    public static function handleTemporaryFile(
        TemporaryUploadedFile $file,
        string $targetPath = null,
        bool $transferToCloud = true,
        string $modelClass = null,
        int $modelId = null,
        string $modelField = null
    ): ?string {
        try {
            // Always use local disk for initial upload
            $localDisk = 'local';
            
            // Get the original filename
            $originalName = $file->getFilename();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            
            // Generate a unique filename
            $filename = uniqid() . '_' . time() . '.' . $extension;
            
            // Create path - use targetPath if provided, otherwise use livewire-tmp
            $path = $targetPath ? rtrim($targetPath, '/') . '/' . $filename : 'livewire-tmp/' . $filename;
            
            // Store the file content locally
            $content = file_get_contents($file->getRealPath());
            $result = Storage::disk($localDisk)->put($path, $content);
            
            if ($result) {
                Log::info('Livewire file uploaded to local storage successfully', [
                    'original_name' => $originalName,
                    'stored_path' => $path,
                    'disk' => $localDisk,
                    'will_transfer_to_cloud' => $transferToCloud
                ]);
                
                // Queue transfer to cloud storage if requested
                if ($transferToCloud && self::shouldUseCloudStorage()) {
                    self::queueCloudTransfer($path, null, true, $modelClass, $modelId, $modelField);
                }
                
                return $path;
            } else {
                Log::error('Failed to upload Livewire file to local storage', [
                    'original_name' => $originalName,
                    'target_path' => $path
                ]);
                
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Livewire file upload exception', [
                'error' => $e->getMessage(),
                'file' => $file->getFilename()
            ]);
            
            return null;
        }
    }

    /**
     * Get temporary URL for a file - checks both local and cloud storage
     *
     * @param string $path File path
     * @param int $expiryMinutes URL expiry time in minutes
     * @return string|null
     */
    public static function getTemporaryUrl(string $path, int $expiryMinutes = 60): ?string
    {
        try {
            // First check if file exists in cloud storage and we're using cloud
            if (self::shouldUseCloudStorage()) {
                $cloudDisk = getStorageDisk();
                if (Storage::disk($cloudDisk)->exists($path)) {
                    if (config("filesystems.disks.{$cloudDisk}.visibility") === 'public') {
                        return Storage::disk($cloudDisk)->url($path);
                    } else {
                        return Storage::disk($cloudDisk)->temporaryUrl($path, now()->addMinutes($expiryMinutes));
                    }
                }
            }
            
            // Fallback to local storage
            if (Storage::disk('local')->exists($path)) {
                // For local files, we need to create a route or use a different approach
                // since local disk doesn't support public URLs
                return self::createLocalFileUrl($path);
            }
            
            Log::warning('File not found in any storage for URL generation', ['path' => $path]);
            return null;
            
        } catch (\Exception $e) {
            Log::warning('Failed to get temporary URL', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return null;
        }
    }

    /**
     * Queue file transfer to cloud storage
     *
     * @param string $localPath Local file path
     * @param string|null $cloudPath Target cloud path (optional)
     * @param bool $deleteLocal Whether to delete local file after transfer
     * @param string|null $modelClass Model class to update
     * @param int|null $modelId Model ID to update
     * @param string|null $modelField Model field to update
     */
    public static function queueCloudTransfer(
        string $localPath,
        string $cloudPath = null,
        bool $deleteLocal = true,
        string $modelClass = null,
        int $modelId = null,
        string $modelField = null
    ): void {
        try {
            TransferFileToCloudJob::dispatch(
                $localPath,
                $cloudPath,
                $deleteLocal,
                $modelClass,
                $modelId,
                $modelField,
                getStorageDisk()
            )->delay(now()->addSeconds(30)); // Small delay to ensure file operations complete

            Log::info('Cloud transfer job queued', [
                'local_path' => $localPath,
                'cloud_path' => $cloudPath,
                'model_class' => $modelClass,
                'model_id' => $modelId
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to queue cloud transfer', [
                'local_path' => $localPath,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Transfer file immediately to cloud storage (synchronous)
     *
     * @param string $localPath Local file path
     * @param string|null $cloudPath Target cloud path
     * @param bool $deleteLocal Whether to delete local file after transfer
     * @return string|null Cloud path on success
     */
    public static function transferToCloudNow(
        string $localPath,
        string $cloudPath = null,
        bool $deleteLocal = true
    ): ?string {
        try {
            $transferService = new LocalToCloudTransferService(getStorageDisk());
            return $transferService->transferFile($localPath, $cloudPath, $deleteLocal);
        } catch (\Exception $e) {
            Log::error('Immediate cloud transfer failed', [
                'local_path' => $localPath,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    /**
     * Clean up temporary file from local storage
     *
     * @param string $path File path
     */
    public static function cleanupTemporaryFile(string $path): void
    {
        try {
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
                Log::info('Local temporary file cleaned up', ['path' => $path]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to cleanup local temporary file', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if cloud storage should be used
     *
     * @return bool
     */
    private static function shouldUseCloudStorage(): bool
    {
        return getStorageDisk() !== 'local' && getStorageDisk() !== 'public';
    }

    /**
     * Create a local file URL using the LocalFileController
     *
     * @param string $path
     * @return string|null
     */
    private static function createLocalFileUrl(string $path): ?string
    {
        try {
            return \App\Http\Controllers\LocalFileController::getDownloadUrl($path);
        } catch (\Exception $e) {
            Log::warning('Failed to create local file URL', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
} 