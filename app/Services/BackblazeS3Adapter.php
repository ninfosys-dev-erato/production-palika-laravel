<?php

namespace App\Services;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Config;
use League\Flysystem\UnableToWriteFile;

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
            // Calculate MD5 hash for the contents
            if (is_string($body)) {
                $md5Hash = base64_encode(md5($body, true));
                
                // Create a new config with the Content-MD5 header but without ACL
                $configArray = $config->toArray();
                unset($configArray['visibility']); // Remove visibility to avoid ACL issues
                $newConfig = new Config(array_merge($configArray, ['ContentMD5' => $md5Hash]));
                
                // Call parent's write method with the modified config
                parent::write($path, $body, $newConfig);
            } else {
                // For streams, call parent's writeStream method
                parent::writeStream($path, $body, $config);
            }
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }


} 