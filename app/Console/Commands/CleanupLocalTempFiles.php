<?php

namespace App\Console\Commands;

use App\Services\LocalToCloudTransferService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupLocalTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:cleanup-local-temp 
                            {--hours=24 : Files older than this many hours will be cleaned up}
                            {--directory=livewire-tmp : Directory to clean up}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old temporary files from local storage';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $directory = $this->option('directory');
        $dryRun = $this->option('dry-run');

        $this->info("Cleaning up local temporary files...");
        $this->info("Directory: {$directory}");
        $this->info("Files older than: {$hours} hours");
        $this->info("Dry run: " . ($dryRun ? 'Yes' : 'No'));

        try {
            $transferService = new LocalToCloudTransferService();
            
            if ($dryRun) {
                $filesToClean = $this->getFilesToClean($directory, $hours);
                $this->info("Files that would be cleaned up:");
                foreach ($filesToClean as $file) {
                    $this->line("  - {$file}");
                }
                $this->info("Total files: " . count($filesToClean));
                return 0;
            }

            $cleanedCount = $transferService->cleanupOrphanedLocalFiles($directory, $hours);
            
            $this->info("Cleanup completed successfully.");
            $this->info("Files cleaned up: {$cleanedCount}");

            return 0;

        } catch (\Exception $e) {
            $this->error("Error during cleanup: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get list of files that would be cleaned up
     */
    private function getFilesToClean(string $directory, int $hours): array
    {
        $files = Storage::disk('local')->allFiles($directory);
        $cutoffTime = Carbon::now()->subHours($hours);
        $filesToClean = [];

        foreach ($files as $file) {
            $lastModified = Storage::disk('local')->lastModified($file);
            if ($lastModified < $cutoffTime->timestamp) {
                $filesToClean[] = $file;
            }
        }

        return $filesToClean;
    }
}