<?php

declare(strict_types=1);

namespace Compolomus\RssReader;

interface CacheInterface
{
    public function addChannel(string $url): bool;

    public function getCacheChannels(): array;

    public function getCacheIds(): array;

    public function generateId(string $id): int;
}
