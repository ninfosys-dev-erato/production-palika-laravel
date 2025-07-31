<?php

namespace App\Jobs;

use App\Services\LocalToCloudTransferService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TransferFileToCloudJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300; // 5 minutes

    public function __construct(
        private string $localPath,
        private ?string $cloudPath = null,
        private bool $deleteLocal = true,
        private ?string $modelClass = null,
        private ?int $modelId = null,
        private ?string $modelField = null,
        private string $cloudDisk = 'backblaze'
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transferService = new LocalToCloudTransferService($this->cloudDisk);
        
        // Transfer the file
        $cloudPath = $transferService->transferFile(
            $this->localPath,
            $this->cloudPath,
            $this->deleteLocal
        );

        if ($cloudPath === null) {
            throw new \Exception("Failed to transfer file: {$this->localPath}");
        }

        // Update the model if specified
        if ($this->modelClass && $this->modelId && $this->modelField) {
            $this->updateModelWithCloudPath($cloudPath);
        }

        Log::info("File transfer job completed successfully", [
            'local_path' => $this->localPath,
            'cloud_path' => $cloudPath,
            'model_class' => $this->modelClass,
            'model_id' => $this->modelId,
            'model_field' => $this->modelField
        ]);
    }

    /**
     * Update the model with the cloud file path
     */
    private function updateModelWithCloudPath(string $cloudPath): void
    {
        try {
            if (!class_exists($this->modelClass)) {
                Log::warning("Model class does not exist: {$this->modelClass}");
                return;
            }

            $model = $this->modelClass::find($this->modelId);
            
            if (!$model) {
                Log::warning("Model not found", [
                    'class' => $this->modelClass,
                    'id' => $this->modelId
                ]);
                return;
            }

            // Update the model field with cloud path
            $model->{$this->modelField} = $cloudPath;
            $model->save();

            Log::info("Model updated with cloud path", [
                'model_class' => $this->modelClass,
                'model_id' => $this->modelId,
                'field' => $this->modelField,
                'cloud_path' => $cloudPath
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update model with cloud path", [
                'model_class' => $this->modelClass,
                'model_id' => $this->modelId,
                'error' => $e->getMessage()
            ]);
            
            // Don't fail the job for model update issues
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("File transfer job failed", [
            'local_path' => $this->localPath,
            'cloud_path' => $this->cloudPath,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    /**
     * Get the display name for the queued job.
     */
    public function displayName(): string
    {
        return 'Transfer File to Cloud: ' . basename($this->localPath);
    }
}