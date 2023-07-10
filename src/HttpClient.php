<?php

declare(strict_types=1);

namespace App;

class HttpClient
{
    private $httpResponse;

    public function __construct(HttpResponse $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function get(string $url, array $parameters = null): array
    {
        return $this->httpResponse->call('GET', $url, $parameters);
    }

    public function call(string $method, string $url, array $parameters = null, array $data = null): array
    {
        $opts = [
            'http' => [
                'method'  => $method,
                'header'  => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null
            ]
        ];

        $url .= ($parameters ? '?' . http_build_query($parameters) : '');
        
        $response = file_get_contents($url, false, stream_context_create($opts));
        
        return json_decode($response, true);
    }
}
