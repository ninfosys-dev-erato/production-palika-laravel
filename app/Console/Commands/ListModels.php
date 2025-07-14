<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ListModels extends Command
{
    protected $signature = 'list:models {folder?}';
    protected $description = 'List all models in src/{folder}/Models or all folders if none specified, and create factories if missing';

    public function handle()
    {
        $folder = $this->argument('folder');
        $basePath = base_path('src');

        if ($folder) {
            $this->processModelsInFolder("{$basePath}/{$folder}/Models");
        } else {
            $folders = File::directories($basePath);
            foreach ($folders as $subfolder) {
                $modelsPath = "{$subfolder}/Models";
                if (File::exists($modelsPath)) {
                    $this->info("Scanning Models in " . str_replace(base_path() . '/', '', $modelsPath) . ":");
                    $this->processModelsInFolder($modelsPath);
                }
            }
        }
    }

    protected function processModelsInFolder($path)
    {
        if (!File::exists($path)) {
            $this->error("The folder {$path} does not exist.");
            return;
        }

        $files = File::files($path);
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $modelName = $file->getFilenameWithoutExtension();
                $this->info("Processing model: {$modelName}");

                $factoryPath = base_path("database/factories/{$modelName}Factory.php");

                // Check if the factory already exists
                if (File::exists($factoryPath)) {
                    if ($this->confirm("Factory for {$modelName} already exists. Do you want to replace it?")) {
                        $this->createFactory($file);
                    } else {
                        $this->info("Skipped factory creation for {$modelName}.");
                    }
                } else {
                    $this->createFactory($file);
                }
            }
        }
    }

    protected function createFactory($file)
    {
        // Get the full file path
        $filePath = $file->getRealPath();

        // Get the namespace from the file
        $namespace = $this->extractNamespace($filePath);

        if ($namespace) {
            // Run Artisan command to create the factory with the real model namespace
            $process = Process::fromShellCommandline("php artisan make:factory {$file->getFilenameWithoutExtension()}Factory --model={$namespace}");
            $process->run();

            if ($process->isSuccessful()) {
                $this->info("Factory created for {$file->getFilenameWithoutExtension()}.");
            } else {
                $this->error("Failed to create factory for {$file->getFilenameWithoutExtension()}. Error: {$process->getErrorOutput()}");
            }
        } else {
            $this->error("Could not determine namespace for model {$file->getFilenameWithoutExtension()}.");
        }
    }

    public function extractNamespace(string $file) : string
    {
        $contents = file_exists($file) ? file_get_contents($file) : $file;
        $namespace = $class = '';
        $getting_namespace = $getting_class = false;

        foreach (token_get_all($contents) as $token) {

            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $getting_namespace = true;
            }

            if (is_array($token) && $token[0] == T_CLASS) {
                $getting_class = true;
            }

            // While we're grabbing the namespace name...
            if ($getting_namespace === true) {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } else if ($token === ';') {
                    $getting_namespace = false;
                }
            }

            if ($getting_class === true) {
                if (is_array($token) && $token[0] == T_STRING) {
                    $class = $token[1];
                    break;
                }
            }
        }
        return $namespace ? $namespace . '\\' . $class : $class;
    }
}
