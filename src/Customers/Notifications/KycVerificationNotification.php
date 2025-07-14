<?php

namespace Src\Customers\Notifications;

use App\Notifications\Channels\ExpoPushChannel;
use App\Notifications\Channels\SmsChannel;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class KycVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $status;
    private ?array $rejectionReasons;
    protected SmsService $smsService;

    public function __construct(string $status, ?array $rejectionReasons = null, SmsService $smsService = null)
    {
        $this->status = $status;
        $this->rejectionReasons = $rejectionReasons;
        $this->smsService = $smsService ?? new SmsService();
    }

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
    public function toMail($notifiable): MailMessage
    {
        App::setLocale($notifiable->language_preference->value);

        $subject = __("Regarding KYC Verification Status");

        return (new MailMessage)
            ->subject($subject)
            ->markdown('emails.kyc_status', [
                'status' => $this->status,
                'rejectionReasons' => $this->status === 'rejected' ? $this->formatRejectionReasons() : '',
            ]);

    }

    public function toSms($notifiable): string
    {
        App::setLocale($notifiable->language_preference->value);

        if ($this->status === 'approved') {
            return __("Dear customer, Your KYC has been approved.");
        } elseif ($this->status === 'rejected') {
            return __("Dear customer, Your KYC has been rejected. Reason:") . " " . $this->formatRejectionReasons();
        } else { 
            return __("Dear customer, Your KYC has been submitted successfully and is under review. You will be notified upon verification.");
        }
    }

    public function toExpoPush($notifiable): array
    {
        App::setLocale($notifiable->language_preference->value);
        
        if ($this->status === 'approved') {
            $message =  __("Dear customer, Your KYC has been approved.");
        } elseif ($this->status === 'rejected') {
            $message = __("Dear customer, Your KYC has been rejected. Reason:") . " " . $this->formatRejectionReasons();
        } else { 
            $message = __("Dear customer, Your KYC has been submitted successfully and is under review. You will be notified upon verification.");
        }

        return [
            'to' => $notifiable->expo_push_token,
            'title' => __("KYC Verification Status"),
            'body' => $message,
        ];
    }

    public function toArray(object $notifiable): array
    {
        App::setLocale($notifiable->language_preference->value);
    
        return [
            'status' => $this->status,
            'message' => $this->getLocalizedMessage(),
            'rejection_reasons' => $this->rejectionReasons,
        ];
    }

    private function getLocalizedMessage(): string
    {
        return match ($this->status) {
            'approved' => __("Dear customer, Your KYC has been approved."),
            'rejected' => __("Dear customer, Your KYC has been rejected. Reason:") . " " . $this->formatRejectionReasons(),
            default => __("Dear customer, Your KYC has been submitted successfully and is under review. You will be notified upon verification."),
        };
    }


    private function formatRejectionReasons(): string
    {
        return $this->rejectionReasons ? implode(', ', $this->rejectionReasons) : 'N/A';
    }
}