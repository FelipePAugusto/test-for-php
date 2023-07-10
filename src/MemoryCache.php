<?php

declare(strict_types=1);

namespace App;

class MemoryCache implements CacheInterface
{
    private $cache = [];

    public function get(string $key): ?array
    {
        return $this->cache[$key] ?? null;
    }

    public function set(string $key, array $value): void
    {
        $this->cache[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    public function clear(string $key): void
    {
        unset($this->cache[$key]);
    }
}
