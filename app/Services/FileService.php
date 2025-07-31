<?php

namespace App\Services;

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
        string|File|TemporaryUploadedFile|PDF $file,
        string $disk = null
    ) {
        $disk = $disk ?: getStorageDisk('public');
        if ($file instanceof TemporaryUploadedFile) {
            $file = new File($file->getRealPath());
        }

        if (empty($filename)) {
            $filename = random_int(0, 1000000000);
        }

        // Determine file type and content
        if ($file instanceof \Barryvdh\DomPDF\PDF) {
            $extension = 'pdf';
            $fileContent = $file->output(); // Get raw PDF content
        } elseif ($file instanceof File) {
            $extension = $file->getExtension() ?: 'doc';
            $fileContent = file_get_contents($file->getRealPath());
        } elseif (is_string($file)) {
            $extension = 'pdf';
            $fileContent = $file;
        } else {
            throw new \Exception('Unsupported file type');
        }
        // Check if the filename is empty or does not have an extension
        if (empty($filename) || pathinfo($filename, PATHINFO_EXTENSION) === '') {
            // Append timestamp and extension
            $filename .= now()->format('dMyHis') . '.' . $extension;
        }

        // Ensure path ends with a slash
        $path = rtrim($path, '/') . '/';

        // Store the file correctly
        Storage::disk($disk)->put($path . $filename, $fileContent);

        return $filename;
    }

        public function getFile(
string $path,
        string $filename,
        string $disk = null
    ) {
        $disk = $disk ?: getStorageDisk('public');
        // Ensure path ends with a slash
        $path = rtrim($path, '/') . '/';

        // Full file path
        $filePath = $path . $filename;
        if (!Storage::disk($disk)->exists($filePath)) {
            //            throw new \Exception("File not found: {$filePath}");
            return false;
        }
        // Return file contents or a file URL
        return Storage::disk($disk)->get($filePath); // Or use `Storage::url($filePath)` for a public URL
    }

    public function getTemporaryUrl(
        string $path,
        string $filename,
        string $disk = null,
        int $minutes = 5
    ) {
        $disk = $disk ?: getStorageDisk('private');

        // Ensure path ends with a slash
        $path = rtrim($path, '/') . '/';

        // Full file path
        $filePath = $path . $filename;

        // HYBRID APPROACH: Try cloud storage first, then local fallback
        
        // 1. If we're configured for cloud storage, check if file exists there
        if ($this->shouldUseCloudStorage($disk)) {
            if (Storage::disk($disk)->exists($filePath)) {
                try {
                    // Check if it's a public cloud disk
                    if ($disk == 'public' || config("filesystems.disks.{$disk}.visibility") === 'public') {
                        return Storage::disk($disk)->url($filePath);
                    }
                    
                    // Generate temporary signed URL for private cloud storage
                    return Storage::disk($disk)->temporaryUrl($filePath, now()->addMinutes($minutes));
                    
                } catch (\Exception $e) {
                    Log::warning("Failed to get cloud URL, falling back to local", [
                        'file_path' => $filePath,
                        'disk' => $disk,
                        'error' => $e->getMessage()
                    ]);
                    // Fall through to local storage check
                }
            }
        }

        // 2. Fallback: Check if file exists in local storage
        if (Storage::disk('local')->exists($filePath)) {
            // Use our LocalFileController for serving local files
            return \App\Http\Controllers\LocalFileController::getDownloadUrl($filePath);
        }

        // 3. Last fallback: Check public disk if different from main disk
        if ($disk !== 'public' && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->url($filePath);
        }

        // File not found anywhere
        Log::warning("File not found in any storage location", [
            'file_path' => $filePath,
            'checked_disks' => [$disk, 'local', 'public']
        ]);
        
        return false;
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