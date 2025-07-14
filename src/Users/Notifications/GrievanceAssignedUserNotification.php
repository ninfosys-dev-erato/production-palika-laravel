<?php

namespace Src\Users\Notifications;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceNotificationSetting;

class GrievanceAssignedUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $grievanceDetail;

    /**
     * Create a new notification instance.
     */
    public function __construct(GrievanceDetail $grievanceDetail)
    {
        $this->grievanceDetail = $grievanceDetail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $notificationSettings = GrievanceNotificationSetting::where('module', 'Grievance')->first();

        $channels = ['database'];

        if ($notificationSettings) {
            if ($notificationSettings->mail) {
                $channels[] = 'mail';
            }
    
            if ($notificationSettings->sms) {
                $channels[] = SmsChannel::class;
            }
    
            // if ($notificationSettings->fcm) {
            //     $channels[] = ExpoPushChannel::class;
            // }
        }

    return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting( $notifiable->name . ',')
                    ->markdown('emails.grievance-assign-user', [
                        'name' => $notifiable->name,
                        'token' => $this->grievanceDetail->token,
                        'grievanceSubject' => $this->grievanceDetail->subject,
                        'grievanceDescription' => $this->grievanceDetail->description,

                    ]);
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): string
    {

        $message = "नमस्ते " . $notifiable->name . ","
                 . " "
                 . "तपाईंलाई E-Palika मा नयाँ गुनासो तोकिएको छ।"
                 . " "
                 . "गुनासो टोकन: " . $this->grievanceDetail->token . ","
                 . " "
                 . "कृपया स्थिति हेर्न र आवश्यक कारबाही गर्न तुरुन्त गुनासो पृष्ठमा जानुहोस्।";

        return $message;
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "A new grievance has been assigned to you. Please review and take necessary action.",
            'grievance_token' => $this->grievanceDetail->token,
            'grievance_subject' => $this->grievanceDetail->subject,
            'grievance_description' => $this->grievanceDetail->description,
        ];
    }
}