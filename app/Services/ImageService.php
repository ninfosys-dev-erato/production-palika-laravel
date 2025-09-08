<?php

namespace App\Services;

use App\Enums\DurationType;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Intervention\Image\Exceptions\DecoderException;

class ImageService
{
    public static function compressAndStoreImage(
        File|TemporaryUploadedFile|UploadedFile $image,
        string $path,
        ?string $disk = null,
        $desiredFilename = null
    ) {
        $disk = $disk ?: getStorageDisk('public');
        
        try {
            // Validate the uploaded file
            if (!$image->isValid()) {
                throw new \Exception('Invalid uploaded file');
            }

            // Check if the file is actually an image
            $mimeType = $image->getMimeType();
            $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            
            if (!in_array($mimeType, $allowedMimeTypes)) {
                // If it's not an image, store it as a regular file
                return self::storeAsRegularFile($image, $path, $disk, $desiredFilename);
            }

            // Store the image temporarily on local disk to ensure filesystem path access
            if ($image instanceof TemporaryUploadedFile) {
                $tempPath = $image->store($path, 'local');
                $tempFullPath = Storage::disk('local')->path($tempPath);
            } else {
                $tempPath = $image->store($path);
                $tempFullPath = Storage::path($tempPath);
            }
            
            // Verify the file exists and is readable
            if (!file_exists($tempFullPath) || !is_readable($tempFullPath)) {
                throw new \Exception('Temporary file not accessible');
            }

            // Try to read the image with error handling
            try {
                $imageInstance = Image::read($tempFullPath);
            } catch (DecoderException $e) {
                // If image decoding fails, try to store as regular file
                \Log::warning('Image decoding failed, storing as regular file: ' . $e->getMessage());
                return self::storeAsRegularFile($image, $path, $disk, $desiredFilename);
            } catch (\Exception $e) {
                // For any other image processing error, store as regular file
                \Log::warning('Image processing failed, storing as regular file: ' . $e->getMessage());
                return self::storeAsRegularFile($image, $path, $disk, $desiredFilename);
            }

            // Scale down the image if it's too large
            $imageInstance->scaleDown(width: 1920);
            
            // Determine the filename
            $finalFilename = $desiredFilename ?? basename($tempPath);
            
            // Ensure proper file extension
            if (!pathinfo($finalFilename, PATHINFO_EXTENSION)) {
                $extension = self::getExtensionFromMimeType($mimeType);
                $finalFilename .= '.' . $extension;
            }

            // Store the processed image
            Storage::disk($disk)->put("{$path}/{$finalFilename}", $imageInstance->encode());
            
            // Clean up temporary file (from the correct disk)
            if ($image instanceof TemporaryUploadedFile) {
                Storage::disk('local')->delete($tempPath);
            } else {
                Storage::delete($tempPath);
            }

            return $finalFilename;
            
        } catch (\Exception $e) {
            \Log::error('ImageService::compressAndStoreImage error: ' . $e->getMessage());
            
            // Fallback: store as regular file
            return self::storeAsRegularFile($image, $path, $disk, $desiredFilename);
        }
    }

    /**
     * Store file as regular file without image processing
     */
    private static function storeAsRegularFile(
        File|TemporaryUploadedFile|UploadedFile $file,
        string $path,
        string $disk,
        $desiredFilename = null
    ): string {
        $finalFilename = $desiredFilename ?? $file->getClientOriginalName();
        
        // Ensure unique filename
        if (!$desiredFilename) {
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $finalFilename = $name . '_' . uniqid() . '.' . $extension;
        }

        Storage::disk($disk)->putFileAs($path, $file, $finalFilename);
        
        return $finalFilename;
    }

    /**
     * Get file extension from MIME type
     */
    private static function getExtensionFromMimeType(string $mimeType): string
    {
        $mimeToExtension = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        return $mimeToExtension[$mimeType] ?? 'jpg';
    }

    public static function base64Save($file, $path, ?string $disk = null, $desiredFilename = null): ?string
    {
        $disk = $disk ?: getStorageDisk('public');
        
        try {
            if ($file === null || empty($file)) {
                return null;
            }

            $file_parts = explode(";base64,", $file);

            // Check if the base64 string is valid
            if (count($file_parts) != 2) {
                \Log::warning('Invalid base64 format: missing separator');
                return null; // Invalid base64 format
            }

            $file_type_aux = explode("/", $file_parts[0]);
            // Check if the file type is present
            if (count($file_type_aux) != 2) {
                \Log::warning('Invalid base64 format: missing file type');
                return null; // Invalid base64 format
            }

            $file_type = $file_type_aux[1]; // Get the file extension (like pdf, docx)
            $file_base64 = base64_decode($file_parts[1], true);

            // Check if base64 decode was successful
            if ($file_base64 === false) {
                \Log::warning('Failed to decode base64 data');
                return null;
            }

            // Validate file size (optional - adjust as needed)
            if (strlen($file_base64) > 10 * 1024 * 1024) { // 10MB limit
                \Log::warning('File size too large: ' . strlen($file_base64) . ' bytes');
                return null;
            }

            // Generate a unique ID for the filename
            $uniqId = uniqid() . '_' . date('Y-m-d_H-i-s') . '.' . $file_type;

            if ($desiredFilename !== null) {
                $filename_parts = explode('.', $desiredFilename);
                $uniqId = $filename_parts[0] . '_' . $uniqId;
            }

            // Store the decoded file
            Storage::disk($disk)->put("{$path}/{$uniqId}", $file_base64);

            return $uniqId;
            
        } catch (\Exception $e) {
            \Log::error('ImageService::base64Save error: ' . $e->getMessage());
            return null;
        }
    }

    public static function getImage(string $path, string $file, ?string $disk = null): ?string
    {
        $disk = $disk ?: getStorageDisk('public');
        $fullPath = "{$path}/{$file}";
        if (!Storage::disk($disk)->exists($fullPath)) {
            return false;
        }
        if ($disk === 'public') {
            return Storage::disk($disk)->url($fullPath);
        } else {
            // Check if the driver supports temporary URLs
            try {
                return Storage::disk($disk)->temporaryUrl($fullPath, now()->addMinutes(3));
            } catch (\RuntimeException $e) {
                // If temporary URLs are not supported, try to get a regular URL
                // or use a different approach based on the driver
                $driver = Storage::disk($disk)->getDriver();
                
                if (method_exists($driver, 'url')) {
                    return $driver->url($fullPath);
                } else {
                    // For drivers that don't support URLs, we might need to stream the file
                    // or use a different approach
                    \Log::warning("Storage driver for disk '{$disk}' does not support URLs or temporary URLs");
                    return false;
                }
            }
        }
    }

    public static function isBase64($string): bool
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $string)) {
            return true;
        }

        $decoded = base64_decode($string, true);
        return $decoded !== false && base64_encode($decoded) === $string;
    }

    public static function createImageFromBase64($base64String)
    {
        try {
            if (empty($base64String)) {
                throw new \Exception('Empty base64 string provided');
            }

            $base64String = preg_replace('/^data:image\/(\w+);base64,/', '', $base64String);
            $base64String = str_replace(' ', '+', $base64String);

            $imageData = base64_decode($base64String, true);

            if ($imageData === false) {
                throw new \Exception('Failed to decode base64 data');
            }

            // Validate that it's actually image data
            if (strlen($imageData) < 10) {
                throw new \Exception('Image data too small to be valid');
            }

            $tempFilePath = tempnam(sys_get_temp_dir(), 'img_');
            
            if (file_put_contents($tempFilePath, $imageData) === false) {
                throw new \Exception('Failed to write temporary file');
            }

            return new \Illuminate\Http\UploadedFile($tempFilePath, 'image.jpg', null, null, true);
            
        } catch (\Exception $e) {
            \Log::error('ImageService::createImageFromBase64 error: ' . $e->getMessage());
            throw $e;
        }
    }
}
