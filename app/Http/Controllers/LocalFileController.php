<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocalFileController extends Controller
{
    /**
     * Serve a file from local storage
     *
     * @param Request $request
     * @return Response|StreamedResponse
     */
    public function serve(Request $request)
    {
        try {
            $path = base64_decode($request->query('path'));
            
            // Validate the path to prevent directory traversal
            if (!$this->isValidPath($path)) {
                abort(403, 'Invalid file path');
            }

            // Check if file exists in local storage
            if (!Storage::disk('local')->exists($path)) {
                abort(404, 'File not found');
            }

            // Get file info
            $mimeType = Storage::disk('local')->mimeType($path);
            $size = Storage::disk('local')->size($path);
            $filename = basename($path);

            // Log file access
            Log::info('Local file served', [
                'path' => $path,
                'filename' => $filename,
                'mime_type' => $mimeType,
                'size' => $size
            ]);

            // Stream the file
            return new StreamedResponse(function () use ($path) {
                $stream = Storage::disk('local')->readStream($path);
                if ($stream === false) {
                    abort(500, 'Unable to read file');
                }
                fpassthru($stream);
                fclose($stream);
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Length' => $size,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'private, max-age=3600', // Cache for 1 hour
            ]);

        } catch (\Exception $e) {
            Log::error('Error serving local file', [
                'path' => $request->query('path'),
                'error' => $e->getMessage()
            ]);
            
            abort(500, 'Error serving file');
        }
    }

    /**
     * Validate that the path is safe and allowed
     *
     * @param string $path
     * @return bool
     */
    private function isValidPath(string $path): bool
    {
        // Prevent directory traversal
        if (str_contains($path, '..') || str_contains($path, './')) {
            return false;
        }

        // Only allow certain directories
        $allowedPrefixes = [
            'livewire-tmp/',
            'customer-kyc/',
            'customers/',
            'documents/',
            'uploads/',
            // Add other allowed directories as needed
        ];

        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get download link for a local file
     *
     * @param string $path
     * @return string
     */
    public static function getDownloadUrl(string $path): string
    {
        return route('local-file.serve', ['path' => base64_encode($path)]);
    }
}