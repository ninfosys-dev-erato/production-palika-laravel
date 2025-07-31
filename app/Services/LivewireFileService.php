<?php

namespace App\Services;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LivewireFileService
{
    public static function handleTemporaryFile(TemporaryUploadedFile $file, string $disk = null)
    {
        try {
            $disk = $disk ?: getStorageDisk();
            
            // Get the original filename
            $originalName = $file->getFilename();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            
            // Generate a unique filename
            $filename = uniqid() . '_' . time() . '.' . $extension;
            
            // Create a clean path for Livewire temporary files
            $path = 'livewire-tmp/' . $filename;
            
            // Store the file content
            $content = file_get_contents($file->getRealPath());
            $result = Storage::disk($disk)->put($path, $content);
            
            if ($result) {
                Log::info('Livewire file uploaded successfully', [
                    'original_name' => $originalName,
                    'stored_path' => $path,
                    'disk' => $disk
                ]);
                
                return $path;
            } else {
                Log::error('Failed to upload Livewire file', [
                    'original_name' => $originalName,
                    'disk' => $disk
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
    
    public static function getTemporaryUrl(string $path, string $disk = null)
    {
        try {
            $disk = $disk ?: getStorageDisk();
            
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->temporaryUrl($path, now()->addMinutes(5));
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Failed to get temporary URL', [
                'path' => $path,
                'disk' => $disk,
                'error' => $e->getMessage()
            ]);
            
            return null;
        }
    }
    
    public static function cleanupTemporaryFile(string $path, string $disk = null)
    {
        try {
            $disk = $disk ?: getStorageDisk();
            
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
                Log::info('Temporary file cleaned up', ['path' => $path]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to cleanup temporary file', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
        }
    }
} 