<?php

namespace App\Services;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Http\File;

class FileNamingService
{
    /**
     * Generate a consistent filename for both local and cloud storage
     *
     * @param string $originalName Original filename
     * @param string|null $customFilename Custom filename (optional)
     * @return string Generated filename
     */
    public static function generateFilename(string $originalName, string $customFilename = null): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        
        if (!empty($customFilename)) {
            // If custom filename provided, use it
            $filename = $customFilename;
        } else {
            // Use the same naming scheme as FileService for consistency
            $filename = random_int(0, 1000000000);
        }

        // Check if the filename already has an extension
        if (empty($filename) || pathinfo($filename, PATHINFO_EXTENSION) === '') {
            // Append timestamp and extension using the same format as FileService
            $filename .= now()->format('dMyHis') . '.' . $extension;
        }

        return $filename;
    }

    /**
     * Generate filename from various file types
     *
     * @param mixed $file File object (TemporaryUploadedFile, File, etc.)
     * @param string|null $customFilename Custom filename (optional)
     * @return string Generated filename
     */
    public static function generateFromFile($file, string $customFilename = null): string
    {
        $originalName = '';

        if ($file instanceof TemporaryUploadedFile) {
            $originalName = $file->getFilename();
        } elseif ($file instanceof File) {
            $originalName = $file->getFilename();
        } elseif (is_string($file)) {
            $originalName = 'file.pdf'; // Default for string content
        } else {
            $originalName = 'file.doc'; // Default fallback
        }

        return self::generateFilename($originalName, $customFilename);
    }

    /**
     * Extract extension from filename
     *
     * @param string $filename
     * @return string
     */
    public static function getExtension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION) ?: 'doc';
    }

    /**
     * Validate filename for security
     *
     * @param string $filename
     * @return bool
     */
    public static function isValidFilename(string $filename): bool
    {
        // Prevent directory traversal and dangerous characters
        if (str_contains($filename, '..') || 
            str_contains($filename, '/') || 
            str_contains($filename, '\\') ||
            str_contains($filename, '?') ||
            str_contains($filename, '*') ||
            str_contains($filename, '<') ||
            str_contains($filename, '>') ||
            str_contains($filename, '|') ||
            str_contains($filename, ':')) {
            return false;
        }

        return true;
    }
}