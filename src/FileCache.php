<?php

declare(strict_types=1);

namespace App;

class FileCache implements CacheInterface
{
    private $cachePath;

    public function __construct(string $cachePath)
    {
        $this->cachePath = $cachePath;
    }

    public function get(string $key): ?array
    {
        $filePath = $this->getCacheFilePath($key);

        if (file_exists($filePath)) {
            $contents = file_get_contents($filePath);
            return json_decode($contents, true);
        }

        return null;
    }

    public function set(string $key, array $value): void
    {
        $filePath = $this->getCacheFilePath($key);
        $contents = json_encode($value);

        file_put_contents($filePath, $contents);
    }

    public function has(string $key): bool
    {
        $filePath = $this->getCacheFilePath($key);
        return file_exists($filePath);
    }

    public function clear(string $key): void
    {
        $filePath = $this->getCacheFilePath($key);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function getCacheFilePath(string $key): string
    {
        return $this->cachePath . '/' . md5($key) . '.cache';
    }
}
