<?php

namespace App\Notifications\Channels;

use App\Models\User;
use Illuminate\Support\Facades\Notification;

class MailChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function send($notifiable, Notification $notification)
    {
        //
    }
}
