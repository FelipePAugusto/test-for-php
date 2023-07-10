<?php

declare(strict_types=1);

namespace App;

interface CacheInterface
{
    public function get(string $key): ?array;

    public function set(string $key, array $value): void;

    public function has(string $key): bool;

    public function clear(string $key): void;
}
