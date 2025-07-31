<?php

namespace App\Console\Commands;

use App\Services\LocalToCloudTransferService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TransferPendingFilesToCloud extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:transfer-to-cloud 
                            {--directory=livewire-tmp : Directory to transfer files from}
                            {--max-files=50 : Maximum number of files to transfer in one run}
                            {--dry-run : Show what would be transferred without actually transferring}';

    /**
     * The console command description.
     */
    protected $description = 'Transfer pending local files to cloud storage';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $directory = $this->option('directory');
        $maxFiles = (int) $this->option('max-files');
        $dryRun = $this->option('dry-run');

        $this->info("Transferring local files to cloud storage...");
        $this->info("Directory: {$directory}");
        $this->info("Max files: {$maxFiles}");
        $this->info("Dry run: " . ($dryRun ? 'Yes' : 'No'));

        try {
            $transferService = new LocalToCloudTransferService();
            
            // Get all files in the directory
            $files = Storage::disk('local')->allFiles($directory);
            $filesToTransfer = array_slice($files, 0, $maxFiles);

            if ($dryRun) {
                $this->info("Files that would be transferred:");
                foreach ($filesToTransfer as $file) {
                    $this->line("  - {$file}");
                }
                $this->info("Total files: " . count($filesToTransfer));
                return 0;
            }

            $transferredFiles = $transferService->transferMultipleFiles($filesToTransfer, true);
            
            $this->info("Transfer completed successfully.");
            $this->info("Files transferred: " . count($transferredFiles));

            if (count($transferredFiles) > 0) {
                $this->info("Transferred files:");
                foreach ($transferredFiles as $localPath => $cloudPath) {
                    $this->line("  {$localPath} -> {$cloudPath}");
                }
            }

            return 0;

        } catch (\Exception $e) {
            $this->error("Error during transfer: " . $e->getMessage());
            return 1;
        }
    }
}