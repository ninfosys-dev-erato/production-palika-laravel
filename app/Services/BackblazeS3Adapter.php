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
        // Handle Livewire specific path issues
        if (str_contains($path, 'livewire-tmp/livewire-tmp')) {
            $path = str_replace('livewire-tmp/livewire-tmp', 'livewire-tmp', $path);
        }
        
        // Remove any duplicate path segments
        $pathParts = explode('/', trim($path, '/'));
        $cleanParts = [];
        
        foreach ($pathParts as $part) {
            if (!empty($part)) {
                // Only add if it's not already the last part (prevents immediate duplicates)
                if (empty($cleanParts) || end($cleanParts) !== $part) {
                    $cleanParts[] = $part;
                }
            }
        }
        
        $cleanPath = implode('/', $cleanParts);
        
        // Log path cleaning for debugging
        if ($path !== $cleanPath) {
            \Log::info('Path cleaned', [
                'original' => $path,
                'cleaned' => $cleanPath
            ]);
        }
        
        return $cleanPath;
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

    public function fileExists(string $path): bool
    {
        try {
            $cleanPath = $this->cleanPath($path);
            return parent::fileExists($cleanPath);
        } catch (\Exception $e) {
            \Log::warning('Backblaze fileExists failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function read(string $path): string
    {
        try {
            $cleanPath = $this->cleanPath($path);
            return parent::read($cleanPath);
        } catch (\Exception $e) {
            \Log::warning('Backblaze read failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function readStream(string $path)
    {
        try {
            $cleanPath = $this->cleanPath($path);
            return parent::readStream($cleanPath);
        } catch (\Exception $e) {
            \Log::warning('Backblaze readStream failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function delete(string $path): void
    {
        try {
            $cleanPath = $this->cleanPath($path);
            parent::delete($cleanPath);
        } catch (\Exception $e) {
            \Log::warning('Backblaze delete failed: ' . $e->getMessage(), [
                'path' => $path,
                'cleanPath' => $cleanPath ?? 'not set',
                'error' => $e->getMessage()
            ]);
            // Don't throw on delete failures for temporary files
        }
    }
} 