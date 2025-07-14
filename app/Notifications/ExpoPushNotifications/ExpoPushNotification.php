<?php

namespace App\Notifications\ExpoPushNotifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpoPushNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $body;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['expo_push'];
    }

    /**
     * Get the push notification details for Expo.
     */
    public function toExpoPush($notifiable)
    {
        return [
            'to' => $notifiable->expo_push_token,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}