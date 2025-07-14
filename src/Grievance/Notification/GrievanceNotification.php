<?php

namespace Src\Grievance\Notification;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceNotificationSetting;
use Src\Users\Notifications\GrievanceAssignedUserNotification;

class GrievanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public GrievanceDetail $grievance;

    public function __construct(GrievanceDetail $grievance)
    {
        $this->grievance = $grievance;
    }

    public function via($notifiable): array
    {
        $settings = GrievanceNotificationSetting::where('module', 'Grievance')->first();

        $channels = ['database'];

    if ($settings) {
        if ($settings->mail) {
            $channels[] = 'mail';
        }
    }

    return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('नयाँ गुनासो तपाईंलाई तोकिएको छ')
            ->markdown('emails.grievance-assignment', [
                'name' => $notifiable->name,
                'subject' => $this->grievance->subject,
                'description' => $this->grievance->description,
                'priority' => $this->grievance->priority,
                'customerName' => $this->grievance->customer->name ?? 'Unknown',
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "A new grievance has been assigned to you.",
            'subject' => $this->grievance->subject,
            'description' => $this->grievance->description,
            'priority' => $this->grievance->priority,
            'customer_name' => $this->grievance->customer->name ?? 'Unknown',
        ];
    }

}
