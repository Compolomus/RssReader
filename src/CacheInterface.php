<?php declare(strict_types=1);

namespace Compolomus\RssReader;

interface CacheInterface
{
    public function saveIds(array $ids);

    public function getIds(): array;
}
