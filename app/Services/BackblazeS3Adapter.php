<?php

namespace App\Services;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Config;
use League\Flysystem\UnableToWriteFile;
use League\Flysystem\UnableToRetrieveMetadata;

class BackblazeS3Adapter extends AwsS3V3Adapter
{
    public function write(string $path, string $contents, Config $config): void
    {
        $this->uploadWithMd5($path, $contents, $config);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->uploadWithMd5($path, $contents, $config);
    }

    protected function uploadWithMd5(string $path, $body, Config $config): void
    {
        try {
            // Clean up the path to prevent duplication
            $cleanPath = $this->cleanPath($path);
            
            // Calculate MD5 hash for the contents
            if (is_string($body)) {
                $md5Hash = base64_encode(md5($body, true));
                
                // Create a new config with the Content-MD5 header but without ACL
                $configArray = $config->toArray();
                unset($configArray['visibility']); // Remove visibility to avoid ACL issues
                $newConfig = new Config(array_merge($configArray, ['ContentMD5' => $md5Hash]));
                
                // Call parent's write method with the modified config
                parent::write($cleanPath, $body, $newConfig);
            } else {
                // For streams, call parent's writeStream method
                parent::writeStream($cleanPath, $body, $config);
            }
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function fileSize(string $path): \League\Flysystem\FileAttributes
    {
        try {
            // Clean up the path to prevent duplication
            $cleanPath = $this->cleanPath($path);
            return parent::fileSize($cleanPath);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::warning('Backblaze fileSize failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            
            // Return a default file size if we can't retrieve it
            return new \League\Flysystem\FileAttributes($path, 0);
        }
    }

    protected function cleanPath(string $path): string
    {
        // Remove any duplicate path segments
        $pathParts = explode('/', trim($path, '/'));
        $cleanParts = [];
        
        foreach ($pathParts as $part) {
            if (!empty($part) && !in_array($part, $cleanParts)) {
                $cleanParts[] = $part;
            }
        }
        
        return implode('/', $cleanParts);
    }

    public function mimeType(string $path): \League\Flysystem\FileAttributes
    {
        try {
            $cleanPath = $this->cleanPath($path);
            return parent::mimeType($cleanPath);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::warning('Backblaze mimeType failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            
            // Return a default mime type
            return new \League\Flysystem\FileAttributes($path, null, null, null, 'application/octet-stream');
        }
    }

    public function lastModified(string $path): \League\Flysystem\FileAttributes
    {
        try {
            $cleanPath = $this->cleanPath($path);
            return parent::lastModified($cleanPath);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::warning('Backblaze lastModified failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            
            // Return current time as default
            return new \League\Flysystem\FileAttributes($path, null, null, time());
        }
    }
} 