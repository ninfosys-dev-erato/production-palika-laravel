<?php

namespace Src\Ebps\Jobs;

use Src\Ebps\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Ebps\Notifications\OrganizationStatusUpdated;

class SendOrganizationStatusMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $organization;

    /**
     * Create a new job instance.
     *
     * @param  Organization $organization
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Assuming a one-to-one relationship with user or fetching the first user if using a collection
        $user = $this->organization->user ?? $this->organization->users()->first();
        
        if ($user) {
            $user->notify(new OrganizationStatusUpdated($this->organization));
        }
    }
}
