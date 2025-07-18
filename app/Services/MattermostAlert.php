<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MattermostAlert
{
    public function alert(Throwable $e, Request $request): void
    {
        $user = $request->user();
        $userType = $user ? class_basename($user) : 'Guest';
        $userInfo = $user ? [
            'ID' => $user->id,
            'Name' => $user->name ?? '',
            'Email' => $user->email ?? '',
        ] : ['Guest'];

        $data = [
            'text' => ':rotating_light: **Laravel Exception Alert**',
            'attachments' => [[
                'color' => '#D9534F',
                'fields' => [
                    [
                        'title' => 'App / Environment',
                        'value' => config('app.name') . ' (`' . config('app.env') . '`)',
                        'short' => true,
                    ],
                    [
                        'title' => 'Server Host',
                        'value' => $request->getHost(),
                        'short' => true,
                    ],
                    [
                        'title' => 'User Type',
                        'value' => $userType,
                        'short' => true,
                    ],
                    [
                        'title' => 'User Info',
                        'value' => '```json' . "\n" . json_encode($userInfo, JSON_PRETTY_PRINT) . "\n```",
                        'short' => false,
                    ],
                    [
                        'title' => 'Request URL',
                        'value' => $request->fullUrl(),
                        'short' => false,
                    ],
                    [
                        'title' => 'Request Method',
                        'value' => $request->method(),
                        'short' => true,
                    ],
                    [
                        'title' => 'Request Payload',
                        'value' => '```json' . "\n" . json_encode($request->all(), JSON_PRETTY_PRINT) . "\n```",
                        'short' => false,
                    ],
                    [
                        'title' => 'Exception Message',
                        'value' => '`' . $e->getMessage() . '`',
                        'short' => false,
                    ],
                    [
                        'title' => 'File',
                        'value' => '`' . $e->getFile() . '`',
                        'short' => true,
                    ],
                    [
                        'title' => 'Line',
                        'value' => '`' . $e->getLine() . '`',
                        'short' => true,
                    ],
                ],
                'ts' => now()->timestamp
            ]]
        ];

        try {
            Http::post(config('mattermost.url'), $data);
        } catch (\Exception $ex) {
            Log::error('Failed to send Mattermost alert', ['error' => $ex->getMessage()]);
        }
    }
}
