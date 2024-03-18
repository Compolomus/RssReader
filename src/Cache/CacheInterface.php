<?php declare(strict_types=1);

namespace Compolomus\RssReader\Cache;

interface CacheInterface
{
    /** @param array $items Save a list of items */
    public function save(array $items);

    /** @return array Get list of saved items */
    public function get(): array;

    /** @return array Get IDs list of saved items */
    public function getIds(): array;
}
