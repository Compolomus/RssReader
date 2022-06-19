<?php

declare(strict_types=1);

namespace Compolomus\RssReader;

use SplFileObject;

class Cache implements CacheInterface
{
    private SplFileObject $cache;

    private SplFileObject $cacheIds;

    private string $cacheFile;

    private string $cacheIdsFile;

    public function __construct(string $dir)
    {
        $this->cacheFile = $dir . '/cacheChannels.txt';
        $this->cacheIdsFile = $dir . '/cacheIds.txt';

        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $this->cache = new SplFileObject($this->cacheFile, 'a+b');
        $this->cacheIds = new SplFileObject($this->cacheIdsFile, 'a+b');
    }

    public function addChannel(string $url): bool
    {
        if (!in_array($url, $this->getCacheChannels(), true)) {
            return (bool) $this->cache->fwrite($url . PHP_EOL);
        }

        return false;
    }

    public function generateId(string $id): int
    {
        return crc32($id);
    }

    public function getCacheChannels(): array
    {
        return file_exists($this->cacheFile) ? file(
            $this->cacheFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        ) : [];
    }

    public function getCacheIds(): array
    {
        return file_exists($this->cacheIdsFile) ? file(
            $this->cacheIdsFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        ) : [];
    }

    public function updateCacheIds(array $ids): void
    {
        if (count($ids)) {
            $this->cacheIds->fwrite(implode(PHP_EOL, $ids) . PHP_EOL);
        }
    }
}
