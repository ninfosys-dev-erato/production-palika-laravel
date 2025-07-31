<?php

namespace App\Services;

use App\Enums\DurationType;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageService
{
    public static function compressAndStoreImage(
        File|TemporaryUploadedFile|UploadedFile $image,
        string $path,
        string $disk = null,
        $desiredFilename = null
    ) {
        $disk = $disk ?: getStorageDisk('public');
        // Store the image temporarily
        $tempPath = $image->store($path);
        $imageInstance = Image::read(Storage::path($tempPath));
        $imageInstance->scaleDown(width: 1920);
        // Determine the filename
        $finalFilename = $desiredFilename ?? basename($tempPath);
        Storage::disk($disk)->put("{$path}/{$finalFilename}", $imageInstance->encode());

        return $finalFilename;  // Return the final filename
    }
    public static function base64Save($file, $path, string $disk = null, $desiredFilename = null): ?string
    {
        $disk = $disk ?: getStorageDisk('public');
        
        if ($file !== null) {
            $file_parts = explode(";base64,", $file);

            // Check if the base64 string is valid
            if (count($file_parts) != 2) {
                return null; // Invalid base64 format
            }

            $file_type_aux = explode("/", $file_parts[0]);
            // Check if the file type is present
            if (count($file_type_aux) != 2) {
                return null; // Invalid base64 format
            }

            $file_type = $file_type_aux[1]; // Get the file extension (like pdf, docx)
            $file_base64 = base64_decode($file_parts[1]);

            // Generate a unique ID for the filename
            $uniqId = uniqid() . '_' . date('Y-m-d_H-i-s') . '.' . $file_type;

            if ($desiredFilename !== null) {
                $filename_parts = explode('.', $desiredFilename);
                $uniqId = $filename_parts[0] . '_' . $uniqId;
            }

            // Store the decoded file
            Storage::disk($disk)->put("{$path}/{$uniqId}", $file_base64);

            return $uniqId;
        }

        return null;
    }

    public static function getImage(string $path, string $file, $disk = null): ?string
    {
        $disk = $disk ?: getStorageDisk('public');
        $fullPath = "{$path}/{$file}";
        if (!Storage::disk($disk)->exists($fullPath)) {
            return false;
        }
        if ($disk === 'public') {
            return Storage::disk($disk)->url($fullPath);
        } else {
            return Storage::disk($disk)->temporaryUrl($fullPath, now()->addMinutes(3));
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
        $base64String = preg_replace('/^data:image\/(\w+);base64,/', '', $base64String);
        $base64String = str_replace(' ', '+', $base64String);

        $imageData = base64_decode($base64String);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tempFilePath, $imageData);

        return new \Illuminate\Http\UploadedFile($tempFilePath, 'image.jpg', null, null, true);
    }
}
