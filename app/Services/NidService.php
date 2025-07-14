<?php

namespace App\Services;

use App\Repository\HttpProvider;
use Illuminate\Support\Facades\Cache;

class NidService
{
    public HttpProvider $httpProvider;
    public function __construct()
    {
        $this->httpProvider = new HttpProvider();
    }
    public function getAccessToken(): string|bool
    {
        return Cache::remember('nid_api_token', 1800, function () {
            $url = config('nid.auth_url');
            $username = config('nid.username');
            $password = config('nid.password');
            $headers = [
                'Authorization' => 'Basic ' . base64_encode("$username:$password"),
                'Accept' => 'application/json',
            ];
            $body = [
                'grant_type' => config('nid.grant_type'),
            ];
            $response = $this->httpProvider->post($url, $body, $headers);
            if (!empty($response['token']) && !empty($response['expiresIn'])) {
                Cache::put('nid_api_token', $response['token'], $response['expiresIn'] - 60);
                return $response['token'];
            }
            return false;
        });
    }

    public function verifyNid(
        string $nin,
        string $fullName,
        string $gender,
        string $dobLoc
    ): bool {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return false;
            }
            $url = config('nid.verification_url');
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $body = [
                'nin'      => $nin,
                'fullName' => $fullName,
                'gender'   => $gender,
                'dobLoc'   => $dobLoc,
            ];
            $response = $this->httpProvider->post($url, $body, $headers,true);
            if (!is_array($response)) {
                return false;
            }
            return $response['detailMatch'] ?? false;
        } catch (\Throwable $e) {
            dd($e->getMessage());
            return false;
        }
    }

}