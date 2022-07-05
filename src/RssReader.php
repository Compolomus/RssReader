<?php declare(strict_types=1);

namespace Compolomus\RssReader;

use DateTime;
use DOMDocument;
use DOMXPath;
use function array_column;
use function array_merge;
use function count;
use function crc32;
use function in_array;
use function strip_tags;
use function trim;

class RssReader
{
    public function __construct(
        public array           $channels = [],
        public ?CacheInterface $cache = null,
        public int             $limit = 0,
    ) {
        if (!empty($_ENV['RSSREADER_LIMIT'])) {
            $this->limit = (int) $_ENV['RSSREADER_LIMIT'];
        }

        if (null === $this->cache) {
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
     * Return array with only unique elements
     *
     * @param array $array
     *
     * @return array
     */
    public function getUnique(array $array): array
    {
        $serialized = array_map('serialize', $array);
        $unique     = array_unique($serialized);

        return array_intersect_key($array, $unique);
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

        // Merge results from all sources
        $result = array_merge(...$result);

        // Only unique records
        $result = $this->getUnique($result);

        // Sort array by timestamp column
        usort($result, static function ($a, $b) {
            if ($a['timestamp'] === $b['timestamp']) {
                return 0;
            }
            // ASC order
            return ($a['timestamp'] > $b['timestamp']) ? 1 : -1;
        });

        // Extract IDs and save them all
        $ids = array_column($result, 'id');
        if (count($ids)) {
            $this->cache->saveIds($ids);
        }

        // Slice last few posts if limit is set
        if (!empty($this->limit)) {
            $result = array_slice($result, -$this->limit, $this->limit);
        }

        return $result;
    }
}
