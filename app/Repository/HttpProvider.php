<?php

namespace App\Repository;

use App\Contracts\HttpInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class HttpProvider implements HttpInterface
{
    public Client $httpManager;

    public function __construct()
    {
        $this->httpManager = new Client([
            'verify' => false,
        ]);
    }

    public function get(string $url, array $args = [], array $header = []): array | ConnectException
    {
        try {
            $query = http_build_query($args);
            if (!empty($query)) {
                $url .= '?' . $query;
            }
            $response = $this->httpManager->get($url, [
                'headers' => $header,
            ]);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);

        } catch (ConnectException $e) {
            return $e; // Return the ConnectException on failure
        }
    }


    public function post(string $url, array $args = [], array $header = [], bool $asJson = true): array|ConnectException
    {
        try {
            $options = [
                'headers' => $header,
                'verify'  => false, // optional for local/dev
            ];

            if ($asJson) {
                $options['json'] = $args;
            } else {
                $options['form_params'] = $args;
            }

            $response = $this->httpManager->post($url, $options);
            $body = $response->getBody()->getContents();

            return json_decode($body, true);
        } catch (ConnectException $e) {
            return $e;
        }
    }


}
