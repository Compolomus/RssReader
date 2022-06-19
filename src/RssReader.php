<?php

declare(strict_types=1);

namespace Compolomus\RssReader;

use DateTime;
use DOMDocument;
use DOMElement;
use DOMXPath;

class RssReader
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function getAll(): array
    {
        $dom = new DOMDocument();
        $result = [];
        $ids = [];

        foreach ($this->cache->getCacheChannels() as $chanel) {
            $dom->load($chanel);
            $items = $dom->getElementsByTagName('item');
            $xpath = new DOMXpath($dom);
            foreach ($items as $item) {
                $data = $this->getItemData($item, $xpath);
                $result[] = $data;
                $ids[] = $data['cacheId'];
            }
        }

        if (count($ids)) {
            $this->cache->updateCacheIds($ids);
        }

        return $result;
    }

    public function getItemData(DOMElement $item, DOMXpath $xpath)
    {
        $link = $item->getElementsByTagName('link')->item(0)->nodeValue;
        preg_match('#\/(\d{3,})\/{0,1}#', $link, $matches);
        $timestamp = (new DateTime($item->getElementsByTagName('pubDate')->item(0)->nodeValue))->getTimestamp();
        $id = $matches[1];
        $cacheId = $this->cache->generateId($link);

        if (!in_array($cacheId, $this->cache->getCacheIds(), true)) {
            return [
                'id' => $id,
                'title' => $item->getElementsByTagName('title')->item(0)->nodeValue,
                'desc' => trim(strip_tags($item->getElementsByTagName('description')->item(0)->nodeValue)),
                'link' => $link,
                'timestamp' => $timestamp,
                'img' => $xpath->query('//enclosure/@url')->item(0)->nodeValue,
                'cacheId' => $cacheId
            ];
        }
    }

}
