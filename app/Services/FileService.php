<?php

namespace App\Services;

use App\Services\FileNamingService;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use function PHPUnit\Framework\isEmpty;

class FileService
{
    public function saveFile(
        string $path,
        $filename,
        string|File|TemporaryUploadedFile|\Barryvdh\DomPDF\PDF $file,
        ?string $disk = null
    ): string|false {
        $disk = $disk ?: getStorageDisk('public');
        $path = rtrim($path, '/') . '/';

        try {
            // Normalize file input
            [$fileContent, $originalName, $extension] = $this->resolveFileContent($file);

            // Generate final filename
            $filename = FileNamingService::generateFilename($originalName, $filename);

            // Ensure correct prefix for cloud storage
            $finalPath = $this->applyTenantPrefix($path, $disk);

            // Store the file
            $stored = Storage::disk($disk)->put($finalPath . $filename, $fileContent);

            if (!$stored) {
                $this->logStorageError('File storage failed', $disk, $finalPath . $filename);
                return false;
            }

            $this->logStorageSuccess($disk, $finalPath . $filename);
            return $filename;

        } catch (\Throwable $e) {
            $this->logStorageError('Exception during file storage', $disk, ($finalPath ?? $path) . $filename, $e);
            return false;
        }
    }

    /**
     * Normalize the incoming file and return [content, originalName, extension].
     */
    protected function resolveFileContent(string|File|TemporaryUploadedFile|\Barryvdh\DomPDF\PDF $file): array
    {
        if ($file instanceof TemporaryUploadedFile) {
            $file = new File($file->getRealPath());
        }

        return match (true) {
            $file instanceof \Barryvdh\DomPDF\PDF => [$file->output(), 'document.pdf', 'pdf'],
            $file instanceof File => [
                file_get_contents($file->getRealPath()),
                $file->getFilename(),
                $file->getExtension() ?: 'doc',
            ],
            is_string($file) => [$file, 'document.pdf', 'pdf'],
            default => throw new \InvalidArgumentException('Unsupported file type'),
        };
    }

    /**
     * Apply tenant prefix for cloud disks like R2, Backblaze, or S3.
     */
    protected function applyTenantPrefix(string $path, string $disk): string
    {
        if (in_array($disk, ['r2', 'backblaze', 's3'])) {
            $tenantPrefix = rtrim(env('APP_ABBREVIATION', 'default'), '/') . '/';
            if (strpos($path, $tenantPrefix) !== 0) {
                $path = $tenantPrefix . ltrim($path, '/');
            }
        }

        return $path;
    }

    /**
     * Log details on file storage success.
     */
    protected function logStorageSuccess(string $disk, string $storedPath): void
    {
        $config = config("filesystems.disks.{$disk}") ?? [];

        Log::info('File stored successfully', [
            'disk'        => $disk,
            'driver'      => $config['driver'] ?? null,
            'bucket'      => $config['bucket'] ?? null,
            'endpoint'    => $config['endpoint'] ?? null,
            'url'         => $config['url'] ?? null,
            'root'        => $config['root'] ?? null,
            'visibility'  => $config['visibility'] ?? null,
            'stored_path' => $storedPath,
            'is_cloud'    => in_array($disk, ['r2', 'backblaze', 's3']),
        ]);
    }

    /**
     * Log details when file storage fails or throws an exception.
     */
    protected function logStorageError(string $message, string $disk, string $storedPath, ?\Throwable $e = null): void
    {
        $config = config("filesystems.disks.{$disk}") ?? [];

        Log::error($message, [
            'disk'        => $disk,
            'driver'      => $config['driver'] ?? null,
            'bucket'      => $config['bucket'] ?? null,
            'endpoint'    => $config['endpoint'] ?? null,
            'root'        => $config['root'] ?? null,
            'stored_path' => $storedPath,
            'error'       => $e?->getMessage(),
        ]);
    }


    /**
     * Retrieve file content from storage.
     */
    public function getFile(string $path, string $filename, ?string $disk = null): string|false
    {
        $disk = $disk ?: getStorageDisk('public');
        $filePath = $this->buildTenantAwarePath($path, $filename, $disk);
    
        if (!Storage::disk($disk)->exists($filePath)) {
            Log::warning('File not found', [
                'disk' => $disk,
                'path' => $filePath,
            ]);
            return false;
        }
    
        try {
            return Storage::disk($disk)->get($filePath);
        } catch (\Throwable $e) {
            Log::error('File retrieval failed', [
                'disk' => $disk,
                'path' => $filePath,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    /**
     * Generate a temporary or public-access URL for a stored file.
     */
    public function getTemporaryUrl(
        string $path,
        string $filename,
        ?string $disk = null,
        int $minutes = 5
    ): string|false {
        $disk = $disk ?: getStorageDisk('private');
        $filePath = $this->buildTenantAwarePath($path, $filename, $disk);
    
        if (!Storage::disk($disk)->exists($filePath)) {
            Log::warning('Temporary URL request for missing file', [
                'disk' => $disk,
                'path' => $filePath,
            ]);
            return false;
        }
    
        try {
            if ($this->shouldUseCloudStorage($disk)) {
                return $this->generateCloudTemporaryUrl($disk, $filePath, $minutes);
            }
        
            // Local or public disk fallback
            if ($disk === 'public' || config("filesystems.disks.{$disk}.visibility") === 'public') {
                return Storage::disk($disk)->url($filePath);
            }
        
            if (Storage::disk('local')->exists($filePath)) {
                return \App\Http\Controllers\LocalFileController::getDownloadUrl($filePath);
            }
        
            if ($disk !== 'public' && Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->url($filePath);
            }
        
        } catch (\Throwable $e) {
            Log::warning('Temporary URL generation failed', [
                'disk' => $disk,
                'path' => $filePath,
                'error' => $e->getMessage(),
            ]);
        }
    
        return false;
    }
    
    /**
     * Unified cloud temporary URL generator for R2, Backblaze, or S3.
     */
    protected function generateCloudTemporaryUrl(string $disk, string $filePath, int $minutes): string|false
    {
        $config = config("filesystems.disks.{$disk}", []);
        $visibility = $config['visibility'] ?? 'private';
    
        // Public URL (if accessible)
        if ($visibility === 'public' && !empty($config['url'])) {
            return rtrim($config['url'], '/') . '/' . trim($config['root'] ?? '', '/') . '/' . ltrim($filePath, '/');
        }
    
        // Native Laravel temporary URL
        try {
            return Storage::disk($disk)->temporaryUrl($filePath, now()->addMinutes($minutes));
        } catch (\Exception $e) {
            Log::warning('Native temporaryUrl failed', [
                'disk' => $disk,
                'file' => $filePath,
                'error' => $e->getMessage(),
            ]);
        }
    
        // Fallback: manual presigned URL generation using AWS SDK
        try {
            $adapter = Storage::disk($disk)->getAdapter();
            $client = $adapter->getClient();
            $command = $client->getCommand('GetObject', [
                'Bucket' => $config['bucket'],
                'Key'    => trim($config['root'] ?? '', '/') . '/' . ltrim($filePath, '/'),
            ]);
            $request = $client->createPresignedRequest($command, now()->addMinutes($minutes));
            return (string) $request->getUri();
        } catch (\Throwable $e) {
            Log::warning('Manual presigned URL generation failed', [
                'disk' => $disk,
                'file' => $filePath,
                'error' => $e->getMessage(),
            ]);
        }
    
        return false;
    }
    
    /**
     * Build the final file path with tenant prefix (for cloud disks).
     */
    protected function buildTenantAwarePath(string $path, string $filename, string $disk): string
    {
        $path = rtrim($path, '/') . '/';
        $filePath = $path . $filename;
    
        if (in_array($disk, ['r2', 'backblaze', 's3'])) {
            $tenantPrefix = rtrim(env('APP_ABBREVIATION', 'default'), '/') . '/';
            if (strpos($filePath, $tenantPrefix) !== 0) {
                $filePath = $tenantPrefix . ltrim($filePath, '/');
            }
        }
    
        return $filePath;
    }


    /**
     * Check if we should use cloud storage for the given disk
     */
    private function shouldUseCloudStorage(string $disk): bool
    {
        return !in_array($disk, ['local', 'public']) && 
               config("filesystems.disks.{$disk}.key") !== null;
    }

    public function deleteFile(
        string $path,
        string $filename,
        string $disk = null
    ) {
        $disk = $disk ?: getStorageDisk('public');
        // Ensure path ends with a slash
        $path = rtrim($path, '/') . '/';

        // Full file path
        $filePath = $path . $filename;

        // Check if file exists before deleting
        if (!Storage::disk($disk)->exists($filePath)) {
            return false;
        }

        // Delete the file
        Storage::disk($disk)->delete($filePath);

        return true; // Indicate successful deletion
    }

    public function copyFile(
        string $sourcePath,
        string $sourceFilename,
        string $destinationPath,
        string $destinationFilename = null,
        string $sourceDisk = 'public',
        string $destinationDisk = 'public'
    ) {
        // Ensure source and destination paths end with a slash
        $sourcePath = rtrim($sourcePath, '/') . '/';
        $destinationPath = rtrim($destinationPath, '/') . '/';

        // Construct full file paths
        $sourceFilePath = $sourcePath . $sourceFilename;
        $destinationFilename = $destinationFilename ?? $sourceFilename;
        $destinationFilePath = $destinationPath . $destinationFilename;

        // Check if the source file exists
        if (!Storage::disk($sourceDisk)->exists($sourceFilePath)) {
            throw new \Exception("Source file not found: {$sourceFilePath}");
        }

        // Read the file content from the source disk
        $fileContent = Storage::disk($sourceDisk)->get($sourceFilePath);

        // Write the file content to the destination disk
        if (!Storage::disk($destinationDisk)->put($destinationFilePath, $fileContent)) {
            throw new \Exception("Failed to copy file to: {$destinationFilePath}");
        }

        // Return the full path of the copied file
        return $destinationFilePath;
    }



    public function moveFile(
        string $sourcePath,
        string $sourceFilename,
        string $destinationPath,
        string $destinationFilename = null,
        string $sourceDisk = 'public',
        string $destinationDisk = 'public'
    ) {
        $sourcePath = rtrim($sourcePath, '/') . '/';
        $sourceFilePath = $sourcePath . $sourceFilename;

        if (!Storage::disk($sourceDisk)->exists($sourceFilePath)) {
            throw new \Exception("Source file not found: {$sourceFilePath}");
        }

        $destinationPath = rtrim($destinationPath, '/') . '/';
        $destinationFilename = $destinationFilename ?? $sourceFilename;
        $destinationFilePath = $destinationPath . $destinationFilename;

        // Copy to the destination disk and delete from the source disk
        Storage::disk($destinationDisk)->put(
            $destinationFilePath,
            Storage::disk($sourceDisk)->get($sourceFilePath)
        );
        Storage::disk($sourceDisk)->delete($sourceFilePath);

        return $destinationFilename;
    }


    public function createSymbolicLink(
        string $targetPath,
        string $linkPath
    ) {
        if (!file_exists($targetPath)) {
            throw new \Exception("Target path does not exist: {$targetPath}");
        }

        if (file_exists($linkPath)) {
            throw new \Exception("Link path already exists: {$linkPath}");
        }

        if (!symlink($targetPath, $linkPath)) {
            throw new \Exception("Failed to create symbolic link from {$linkPath} to {$targetPath}");
        }

        return true;
    }

    public function fileExists(
        string $path,
        string $filename,
        string $disk = 'public'
    ) {
        $path = rtrim($path, '/') . '/';
        $filePath = $path . $filename;
        return Storage::disk($disk)->exists($filePath);
    }

    public function listFiles(
        string $path,
        string $disk = 'public'
    ) {
        $path = rtrim($path, '/') . '/';
        return Storage::disk($disk)->files($path);
    }

    public function listDirectories(
        string $path,
        string $disk = 'public'
    ) {
        $path = rtrim($path, '/') . '/';
        return Storage::disk($disk)->directories($path);
    }

    public function saveBase64File(
        string $path,
        string $base64String,
        string $filename = null,
        string $disk = 'public'
    ) {
        // Decode the base64 string
        $decodedFile = base64_decode($base64String);

        // Generate a temporary file
        $tempFilePath = sys_get_temp_dir() . '/' . uniqid('base64_') . '.tmp';
        file_put_contents($tempFilePath, $decodedFile);

        // Create a File instance
        $tempFile = new File($tempFilePath);

        // Use the saveFile method to save the file
        $savedFilename = $this->saveFile($path, $filename, $tempFile, $disk);

        // Delete the temporary file
        unlink($tempFilePath);

        return $savedFilename;
    }

}