<?php

namespace Src\Ebps\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrganizationStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $organization;
    public $appUrl;

    public function __construct($organization)
    {
        $this->organization = $organization;
        // Set your application URL, or pull from config/env
        $this->appUrl = config('app.url');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->organization->status === 'rejected') {
            return (new MailMessage)
                ->subject('E-Palika मा स्वागत छ! - Registration Rejected')
                ->greeting($notifiable->name . ',')
                ->markdown('emails.organization-reject', [
                    'name' => $notifiable->name,
                    'reason' => $this->organization->reason_to_reject ?? 'No specific reason provided.',
                    'appUrl' => $this->appUrl,
                ]);
        } 

        return (new MailMessage)
            ->subject('E-Palika मा स्वागत छ! - Registration Approved')
            ->greeting($notifiable->name . ',')
            ->markdown('emails.organization-approve', [
                'name' => $notifiable->name,
                'appUrl' => $this->appUrl,
            ]);
    }
}
