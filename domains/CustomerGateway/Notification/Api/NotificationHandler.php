<?php

namespace Domains\CustomerGateway\Notification\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ExpoPushNotifications\ExpoPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationHandler extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'user_id' => Auth::user(),
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user->expo_push_token) {
            return response()->json(['error' => 'User does not have an Expo push token registered.'], 400);
        }

        $user->notify(new ExpoPushNotification($request->title, $request->body));

        return response()->json(['message' => 'Notification sent successfully.']);
    }
}