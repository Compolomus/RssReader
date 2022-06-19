<?php

namespace Compolomus\RssReader;

interface CacheInterface
{
    public function saveIds();

    public function getIds(): array;
}
