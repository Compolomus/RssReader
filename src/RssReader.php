<?php declare(strict_types=1);

namespace Compolomus\RssReader;

use DateTime;
use DOMDocument;
use DOMXPath;
use function count;

class RssReader
{
    public function __construct(
        public array           $channels = [],
        public ?CacheInterface $cache = null,
    ) {
        if (null === $cache) {
            $this->cache = new FileCache();
        }
    }

    /**
     * @throws \Exception
     */
    protected function getPostsFromChannel(string $chanel): ?array
    {
        // Load document
        $dom = new DOMDocument();
        $dom->load($chanel);

        // Extract all items
        $items = $dom->getElementsByTagName('item');

        // Build XPath object
        $xpath = new DOMXpath($dom);

        // Parse all items in loop
        $result = [];
        foreach ($items as $item) {
            $link      = $item->getElementsByTagName('link')->item(0)->nodeValue;
            $itemId    = crc32($link);
            $timestamp = (new DateTime($item->getElementsByTagName('pubDate')->item(0)->nodeValue))->getTimestamp();

            // Extract posts which is not in a cache
            if (!in_array($itemId, $this->cache->getIds(), false)) {
                $result[] = [
                    'id'        => $itemId,
                    'title'     => $item->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc'      => trim(strip_tags($item->getElementsByTagName('description')->item(0)->nodeValue)),
                    'link'      => $link,
                    'timestamp' => $timestamp,
                    'img'       => $xpath->query('//enclosure/@url')->item(0)->nodeValue,
                ];
            }
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function getAll(): array
    {
        $result = [];
        foreach ($this->channels as $chanel) {
            $result[] = $this->getPostsFromChannel($chanel);
        }

        $result = array_merge(...$result);
        $ids    = array_column($result, 'id');

        if (count($ids)) {
            $this->cache->saveIds($ids);
        }

        return $result;
    }
}
