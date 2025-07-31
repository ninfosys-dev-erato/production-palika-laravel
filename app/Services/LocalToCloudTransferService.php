<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class LocalToCloudTransferService
{
    private string $cloudDisk;
    private string $localDisk;

    public function __construct(string $cloudDisk = 'backblaze', string $localDisk = 'local')
    {
        $this->cloudDisk = $cloudDisk;
        $this->localDisk = $localDisk;
    }

    /**
     * Transfer a file from local storage to cloud storage
     *
     * @param string $localPath Path to file in local storage
     * @param string $cloudPath Desired path in cloud storage (optional)
     * @param bool $deleteLocal Whether to delete the local file after transfer
     * @return string|null Returns the cloud path on success, null on failure
     */
    public function transferFile(string $localPath, string $cloudPath = null, bool $deleteLocal = true): ?string
    {
        try {
            // Use the same path if cloudPath is not specified
            $cloudPath = $cloudPath ?: $localPath;

            // Check if local file exists
            if (!Storage::disk($this->localDisk)->exists($localPath)) {
                Log::warning("Local file not found for transfer: {$localPath}");
                return null;
            }

            // Get file content from local storage
            $fileContent = Storage::disk($this->localDisk)->get($localPath);
            
            if ($fileContent === false) {
                Log::error("Failed to read local file: {$localPath}");
                return null;
            }

            // Store in cloud storage
            $success = Storage::disk($this->cloudDisk)->put($cloudPath, $fileContent);
            
            if (!$success) {
                Log::error("Failed to upload file to cloud storage: {$cloudPath}");
                return null;
            }

            // Delete local file if requested and upload was successful
            if ($deleteLocal) {
                Storage::disk($this->localDisk)->delete($localPath);
                Log::info("Local file deleted after successful transfer: {$localPath}");
            }

            Log::info("File transferred successfully", [
                'local_path' => $localPath,
                'cloud_path' => $cloudPath,
                'deleted_local' => $deleteLocal,
                'cloud_disk' => $this->cloudDisk
            ]);

            return $cloudPath;

        } catch (Exception $e) {
            Log::error("File transfer failed", [
                'local_path' => $localPath,
                'cloud_path' => $cloudPath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }

    /**
     * Transfer multiple files from local to cloud storage
     *
     * @param array $filePaths Array of local file paths or associative array [localPath => cloudPath]
     * @param bool $deleteLocal Whether to delete local files after transfer
     * @return array Returns associative array [originalPath => cloudPath] for successful transfers
     */
    public function transferMultipleFiles(array $filePaths, bool $deleteLocal = true): array
    {
        $results = [];

        foreach ($filePaths as $localPath => $cloudPath) {
            // Handle both indexed and associative arrays
            if (is_numeric($localPath)) {
                $localPath = $cloudPath;
                $cloudPath = null;
            }

            $transferredPath = $this->transferFile($localPath, $cloudPath, $deleteLocal);
            
            if ($transferredPath) {
                $results[$localPath] = $transferredPath;
            }
        }

        return $results;
    }

    /**
     * Get the URL for a file in cloud storage
     *
     * @param string $cloudPath Path to file in cloud storage
     * @param int $expiryMinutes Expiry time in minutes for signed URLs
     * @return string|null
     */
    public function getCloudUrl(string $cloudPath, int $expiryMinutes = 60): ?string
    {
        try {
            // For public cloud storage, get public URL
            if (config("filesystems.disks.{$this->cloudDisk}.visibility") === 'public') {
                return Storage::disk($this->cloudDisk)->url($cloudPath);
            }

            // For private storage, generate temporary URL
            return Storage::disk($this->cloudDisk)->temporaryUrl(
                $cloudPath,
                now()->addMinutes($expiryMinutes)
            );

        } catch (Exception $e) {
            Log::error("Failed to generate cloud URL", [
                'cloud_path' => $cloudPath,
                'cloud_disk' => $this->cloudDisk,
                'error' => $e->getMessage()
            ]);
            
            return null;
        }
    }

    /**
     * Check if a file exists in cloud storage
     *
     * @param string $cloudPath
     * @return bool
     */
    public function cloudFileExists(string $cloudPath): bool
    {
        try {
            return Storage::disk($this->cloudDisk)->exists($cloudPath);
        } catch (Exception $e) {
            Log::error("Error checking cloud file existence", [
                'cloud_path' => $cloudPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete a file from cloud storage
     *
     * @param string $cloudPath
     * @return bool
     */
    public function deleteCloudFile(string $cloudPath): bool
    {
        try {
            return Storage::disk($this->cloudDisk)->delete($cloudPath);
        } catch (Exception $e) {
            Log::error("Error deleting cloud file", [
                'cloud_path' => $cloudPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Clean up orphaned local files (files that exist locally but not in cloud)
     *
     * @param string $directory Directory to clean up
     * @param int $olderThanHours Only clean files older than this many hours
     * @return int Number of files cleaned up
     */
    public function cleanupOrphanedLocalFiles(string $directory, int $olderThanHours = 24): int
    {
        try {
            $localFiles = Storage::disk($this->localDisk)->allFiles($directory);
            $cleanedCount = 0;
            $cutoffTime = now()->subHours($olderThanHours);

            foreach ($localFiles as $localPath) {
                // Check file age
                $lastModified = Storage::disk($this->localDisk)->lastModified($localPath);
                if ($lastModified > $cutoffTime->timestamp) {
                    continue; // Skip recent files
                }

                // Check if file exists in cloud
                if (!$this->cloudFileExists($localPath)) {
                    // File doesn't exist in cloud, safe to delete locally
                    if (Storage::disk($this->localDisk)->delete($localPath)) {
                        $cleanedCount++;
                        Log::info("Cleaned up orphaned local file: {$localPath}");
                    }
                }
            }

            Log::info("Cleanup completed", [
                'directory' => $directory,
                'files_cleaned' => $cleanedCount,
                'older_than_hours' => $olderThanHours
            ]);

            return $cleanedCount;

        } catch (Exception $e) {
            Log::error("Error during local file cleanup", [
                'directory' => $directory,
                'error' => $e->getMessage()
            ]);
            
            return 0;
        }
    }
}