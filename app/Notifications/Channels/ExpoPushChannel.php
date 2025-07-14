<?php

namespace App\Notifications\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Log;

class ExpoPushChannel
{
    protected $httpClient;

    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * Send the notification.
     */
    public function send($notifiable, BaseNotification $notification)
    {
        if (method_exists($notification, 'toExpoPush')) {

            $message = $notification->toExpoPush($notifiable);
            try {
                $response = $this->httpClient->post('https://exp.host/--/api/v2/push/send', [
                    'json' => $message,
                ]);

                if ($response->getStatusCode() === 200) {
                    Log::info('Expo push notification sent successfully.');
                }

            } catch (\Exception $e) {
                Log::error('Failed to send Expo push notification: ' . $e->getMessage());
            }
        } else {
            Log::error('The notification does not support Expo push notifications.');
        }
    }
}
