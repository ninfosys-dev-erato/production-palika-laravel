<?php

namespace App\Contracts;

use GuzzleHttp\Exception\ConnectException;

interface HttpInterface
{
    public  function get(string $url, array $args = [], array $header = []): array | ConnectException;
    public  function post(string $url, array $args = [], array $header = [], bool $asJson = true): array | ConnectException;
}
