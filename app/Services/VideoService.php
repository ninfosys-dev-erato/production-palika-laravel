<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VideoService
{
    public static function storeVideo(
        File|TemporaryUploadedFile $video,
        string $path,
        string $disk = 'public',
        $desiredFilename = null
    ) {
        $tempPath = $video->store($path);
        $finalFilename = $desiredFilename ?? basename($tempPath);

        Storage::disk($disk)->put(
            "{$path}/{$finalFilename}",
            Storage::get($tempPath)
        );

        return $finalFilename;
    }

    public static function transferBetweenDisks(
        string $path,
        string $filename,
        string $fromDisk,
        string $toDisk
    ) {
        $fullPath = "{$path}/{$filename}";

        if (Storage::disk($fromDisk)->exists($fullPath)) {
            $contents = Storage::disk($fromDisk)->get($fullPath);
            Storage::disk($toDisk)->put($fullPath, $contents);
            Storage::disk($fromDisk)->delete($fullPath);
        }
    }

    public static function getVideo(string $path, string $video_name, $disk = 'public'): ?string
    {
        $fullPath = "{$path}/{$video_name}";
        if ($disk === 'public') {
            return Storage::disk($disk)->url($fullPath);
        } else {
            return Storage::disk($disk)->temporaryUrl($fullPath, now()->addMinutes(3));
        }
    }

    public static function deleteVideo(string $path, string $filename, string $disk = 'public'): bool
    {
        $fullPath = "{$path}/{$filename}";
        if (Storage::disk($disk)->exists($fullPath)) {
            return Storage::disk($disk)->delete($fullPath);
        }
        return false;
    }
}
