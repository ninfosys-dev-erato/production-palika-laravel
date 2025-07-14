<?php

namespace Src\Customers\Notifications;

use App\Notifications\Channels\ExpoPushChannel;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class CustomerRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private string $appUrl;
    private string $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($appUrl, $password)
    {
        $this->appUrl = $appUrl;
        $this->password = $password;
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
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        App::setLocale($notifiable->language_preference->value);

        return (new MailMessage)
                    ->subject('E-Palika मा स्वागत छ!')
                    ->greeting( $notifiable->name . ',')
                    ->markdown('emails.customer-registration', [
                        'name' => $notifiable->name,
                        'appUrl' => $this->appUrl
                    ]);
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): string
    {
        App::setLocale($notifiable->language_preference->value);
    

        $message = "नमस्ते " . $notifiable->name . ", तपाईंको खाता E-Palika मा सफलतापूर्वक सिर्जना गरिएको छ।"
                 . " "
                 . "कृपया हाम्रो मोबाइल एप डाउनलोड गर्नुहोस् र तपाईंको KYC प्रक्रिया पूरा गर्नुहोस्।" . $this->appUrl 
                 . " "
                 . "लगइन गर्नको लागि: मोबाइल नम्बर: " . $notifiable->mobile_no . ", पासवर्ड: " . $this->password;
    
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
            'message' => $this->getLocalizedMessage($notifiable),
            'app_url' => $this->appUrl,
        ];
    }
    
    private function getLocalizedMessage($notifiable): string
    {
        return "Hello {$notifiable->name}, your account has been successfully created on E-Palika. Please download our mobile app and complete your KYC process.";
    }
    
}