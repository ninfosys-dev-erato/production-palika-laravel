<?php

namespace Src\Customers\Notifications;

use App\Notifications\Channels\ExpoPushChannel;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class GrievanceStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private string $status;
    private string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $token)
    {
        $this->status = $status;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $preferences = json_decode($notifiable->notification_preference, true);

        $channels = ['database']; 

        if (!empty($preferences)) {
            if (!empty($preferences['mail'])) {
                $channels[] = 'mail';
            }
            if (!empty($preferences['sms'])) {
                $channels[] = SmsChannel::class;
            }
            if (!empty($preferences['expo'])) {
                $channels[] = ExpoPushChannel::class;
            }
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        App::setLocale($notifiable->language_preference->value);

        $subject = __("Regarding Grievance Status");
            return (new MailMessage)
            ->subject($subject)
            ->markdown('emails.grievance_status', [
                'status' => $this->status,
                'token' => $this->token,
            ]);
                    
    }

    public function toSms(object $notifiable): string
    {
        App::setLocale($notifiable->language_preference->value);

        $statusMessage = '';
    
        if ($this->status === 'closed') {
            $statusMessage = __("Your grievance (token: :token) has been successfully closed. No further action is required.", ['token' => $this->token]);
        } elseif ($this->status === 'investigating') {
            $statusMessage = __("The investigation for your grievance (token: :token) is complete. We will notify you soon with the final resolution.", ['token' => $this->token]);
        } elseif ($this->status === 'submit') {
            $statusMessage = __("Thank you for submitting your grievance (Token: :token). Our team is reviewing your concerns with priority.", ['token' => $this->token]);
        }
        return $statusMessage;
    }
    
    /**
     * Get the Expo Push representation of the notification.
     */
    public function toExpoPush(object $notifiable): array
    {
        App::setLocale($notifiable->language_preference->value);
        
        $message = '';

        if ($this->status === 'closed') {
            $statusMessage = __("Your grievance (token: :token) has been successfully closed. No further action is required.", ['token' => $this->token]);
        } elseif ($this->status === 'investigating') {
            $statusMessage = __("The investigation for your grievance (token: :token) is complete. We will notify you soon with the final resolution.", ['token' => $this->token]);
        } elseif ($this->status === 'submit') {
            $statusMessage = __("Thank you for submitting your grievance (Token: :token). Our team is reviewing your concerns with priority.", ['token' => $this->token]);
        }

        return [
            'to' => $notifiable->expo_push_token,
            'title' => "गुनासो स्थिति अपडेट",
            'body' => $message
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
            'token' => $this->token,
            'message' => $this->getLocalizedMessage($notifiable),
        ];
    }
    

    private function getLocalizedMessage($notifiable): string
    {
        App::setLocale($notifiable->language_preference->value);
    
        return match ($this->status) {
            'closed' => __("Your grievance (token: :token) has been successfully closed. No further action is required.", ['token' => $this->token]),
            'investigating' => __("The investigation for your grievance (token: :token) is complete. We will notify you soon with the final resolution.", ['token' => $this->token]),
            'submit' => __("Thank you for submitting your grievance (Token: :token). Our team is reviewing your concerns with priority.", ['token' => $this->token]),
            default => __("Grievance status has been updated."),
        };
    }

}