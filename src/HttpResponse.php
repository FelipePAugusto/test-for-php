<?php

declare(strict_types=1);

namespace App;

class HttpResponse
{
    private $httpClient;
    private $cache;

    public function __construct(HttpClient $httpClient, CacheInterface $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    public function get(string $url, array $parameters = null): array
    {
        $cacheKey = $this->generateCacheKey('GET', $url, $parameters);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $response = $this->httpClient->call('GET', $url, $parameters);

        $this->cache->set($cacheKey, $response);

        return $response;
    }

    public function post(string $url, array $parameters = null, array $data = null): array
    {
        return $this->httpClient->call('POST', $url, $parameters, $data);
    }

    public function put(string $url, array $parameters = null, array $data = null): array
    {
        $cacheKey = $this->generateCacheKey('PUT', $url, $parameters);

        $this->cache->clear($cacheKey);

        return $this->httpClient->call('PUT', $url, $parameters, $data);
    }

    public function delete(string $url, array $parameters = null): array
    {
        $cacheKey = $this->generateCacheKey('DELETE', $url, $parameters);

        $this->cache->clear($cacheKey);

        return $this->httpClient->call('DELETE', $url, $parameters);
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
