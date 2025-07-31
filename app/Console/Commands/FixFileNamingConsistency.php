<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\LocalToCloudTransferService;

class FixFileNamingConsistency extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:fix-naming-consistency 
                            {--dry-run : Show what would be fixed without actually making changes}
                            {--transfer-all : Transfer all local files to cloud with consistent naming}';

    /**
     * The console command description.
     */
    protected $description = 'Fix file naming consistency between local and cloud storage';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $transferAll = $this->option('transfer-all');

        $this->info("Fixing file naming consistency...");
        $this->info("Dry run: " . ($dryRun ? 'Yes' : 'No'));

        try {
            // Check local files that need to be transferred
            $localFiles = $this->getLocalFilesToTransfer();
            
            if (empty($localFiles)) {
                $this->info("No local files found that need transfer.");
                return 0;
            }

            $this->info("Found " . count($localFiles) . " local files to check:");
            
            $transferService = new LocalToCloudTransferService();
            $transferredCount = 0;

            foreach ($localFiles as $localFile) {
                $this->line("  - {$localFile}");
                
                if (!$dryRun && $transferAll) {
                    // Transfer the file
                    $cloudPath = $transferService->transferFile($localFile, null, false); // Don't delete local yet
                    
                    if ($cloudPath) {
                        $transferredCount++;
                        $this->info("    ✓ Transferred to cloud: {$cloudPath}");
                    } else {
                        $this->error("    ✗ Failed to transfer: {$localFile}");
                    }
                }
            }

            if ($dryRun) {
                $this->info("Dry run completed. Run without --dry-run to actually transfer files.");
            } else if ($transferAll) {
                $this->info("Transfer completed. {$transferredCount} files transferred successfully.");
            }

            // Show cloud files for comparison
            $this->showCloudFiles();

            return 0;

        } catch (\Exception $e) {
            $this->error("Error during consistency fix: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get local files that need to be transferred
     */
    private function getLocalFilesToTransfer(): array
    {
        $directories = [
            'customer-kyc/images',
            'livewire-tmp',
        ];

        $localFiles = [];

        foreach ($directories as $directory) {
            if (Storage::disk('local')->exists($directory)) {
                $files = Storage::disk('local')->allFiles($directory);
                $localFiles = array_merge($localFiles, $files);
            }
        }

        return $localFiles;
    }

    /**
     * Show cloud files for comparison
     */
    private function showCloudFiles(): void
    {
        $this->info("\nCloud storage files:");
        
        $cloudDisk = getStorageDisk();
        if ($cloudDisk === 'local') {
            $this->warn("Cloud storage is set to local - no cloud files to show.");
            return;
        }

        $directories = [
            'customer-kyc/images',
        ];

        foreach ($directories as $directory) {
            $this->line("  Directory: {$directory}");
            
            try {
                if (Storage::disk($cloudDisk)->exists($directory)) {
                    $files = Storage::disk($cloudDisk)->allFiles($directory);
                    
                    foreach ($files as $file) {
                        $size = Storage::disk($cloudDisk)->size($file);
                        $this->line("    - {$file} (" . $this->formatBytes($size) . ")");
                    }
                } else {
                    $this->line("    (directory does not exist)");
                }
            } catch (\Exception $e) {
                $this->error("    Error accessing cloud directory: " . $e->getMessage());
            }
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        
        return sprintf("%.1f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
    }
}