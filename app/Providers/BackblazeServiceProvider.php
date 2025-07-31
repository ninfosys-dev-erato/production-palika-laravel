<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

class BackblazeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Storage::extend('backblaze', function ($app, $config) {
            $client = new S3Client([
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => 'latest',
                'endpoint' => $config['endpoint'],
                'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? true,
                'http' => [
                    'verify' => true,
                ],
            ]);

            $adapter = new AwsS3V3Adapter(
                $client,
                $config['bucket'],
                $config['root'] ?? '',
                null,
                null,
                $config
            );

            return new Filesystem($adapter, $config);
        });
    }
}