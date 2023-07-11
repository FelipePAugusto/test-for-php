<?php

declare(strict_types=1);

namespace App;

class HttpClient
{
    private $httpRequest;
    private $cache;

    public function __construct(HttpRequest $httpRequest, CacheInterface $cache)
    {
        $this->httpRequest = $httpRequest;
        $this->cache = $cache;
    }

    public function get(string $url, array $parameters = null): array
    {
        $cacheKey = $this->generateCacheKey('GET', $url, $parameters);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $response = $this->httpRequest->call('GET', $url, $parameters);

        $this->cache->set($cacheKey, $response);

        return $response;
    }

    public function post(string $url, array $parameters = null, array $data = null): array
    {
        return $this->httpRequest->call('POST', $url, $parameters, $data);
    }

    public function put(string $url, array $parameters = null, array $data = null): array
    {
        $cacheKey = $this->generateCacheKey('PUT', $url, $parameters);

        $this->cache->clear($cacheKey);

        return $this->httpRequest->call('PUT', $url, $parameters, $data);
    }

    public function delete(string $url, array $parameters = null): array
    {
        $cacheKey = $this->generateCacheKey('DELETE', $url, $parameters);

        $this->cache->clear($cacheKey);

        return $this->httpRequest->call('DELETE', $url, $parameters);
    }

    private function generateCacheKey(string $method, string $url, array $parameters = null): string
    {
        $key = $method . '-' . $url;

        if (!empty($parameters)) {
            $key .= '?' . http_build_query($parameters);
        }

        return $key;
    }
}
